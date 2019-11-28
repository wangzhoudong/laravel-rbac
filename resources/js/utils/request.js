/**
 * axios封装
 * 请求拦截、响应拦截、错误统一处理
 */
import axios from 'axios'
import { Message } from 'element-ui'
import { router } from '../router'
import Cookies from 'js-cookie'

/**
 * 提示函数
 * 禁止点击蒙层、显示一秒后关闭
 */
const tip = response => {
  let message = '网络错误，请稍后再试'
  if (typeof response === 'string') {
    message = response
  }
  if ((typeof response === 'object') && (response !== null) && response.hasOwnProperty('message')) {
    message = response.message
  }
  if ((typeof response === 'object') && (response !== null) && response.hasOwnProperty('msg')) {
    message = response.msg
  }
  Message({
    message: message,
    type: 'error',
    duration: 5 * 1000
  })
}

const toLogin = () => {
    // window.location.href = '/api/login?returnUrl=' + encodeURIComponent(window.location.href)
    // const path = router.currentRoute.path
    router.push({ path: '/login' })
}

/**
 * 请求失败后的错误统一处理
 * @param {Number} status 请求失败的状态码
 * @param response
 */
const errorHandle = (status, response) => {
  // 状态码判断
  switch (status) {
    // 401: 未登录状态，跳转登录页
    case 401:
      // tip('无权访问！！！ 401 ')
        toLogin()
      break
    // 403 token过期
    // 清除token并跳转登录页
    case 403:
      tip('无权访问！！！ 403 ')

      break
    case 404:
      tip('请求的资源不存在 404')
      break
    default:
      return tip(response)
  }
}

const headers = {
  'Content-Type': 'application/json;charset=UTF-8',
  'Accept': 'application/json, */*'
}

// 创建axios实例
const instance = axios.create({
  timeout: 10000,
  headers: headers

})
// 设置post请求头
instance.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded'
let token = document.head.querySelector('meta[name="csrf-token"]');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}
// 添加请求拦截器
instance.interceptors.request.use(function(config) {
  // 在发送请求之前做些什么
    if (Cookies.get('TOKEN')) {
        const token = Cookies.getJSON('TOKEN')
        config.headers.common['Authorization'] = `Bearer ${token.access_token}`
    }
  return config
}, function(error) {
  // 对请求错误做些什么
  return Promise.reject(error)
})

// 响应拦截器
instance.interceptors.response.use(
  // 请求成功
  res => (res.status === 200 || res.status === 201) ? Promise.resolve(res) : Promise.reject(res),
  // 请求失败
  error => {
    const { response } = error
    if (response) {
      // 请求已发出，但是不在2xx的范围
      errorHandle(response.status, response.data)
      return Promise.reject(response)
    } else {
      // 处理断网的情况
      // eg:请求超时或断网时，更新state的network状态
      // network状态在app.vue中控制着一个全局的断网提示组件的显示隐藏
      // 关于断网组件中的刷新重新获取数据，会在断网组件中说明
    }
  })

export default instance
