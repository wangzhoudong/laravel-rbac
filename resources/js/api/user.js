import request from '../utils/request'

export default {
  query: (params = {}) => {
    return request.get('/rbac/api/user', { params })
  },
  get: (params = {}) => {
    return request.get('/rbac/api/user/get', { params })
  },
  append: (params) => {
    return request.post('/rbac/api/user', params)
  },
  update: (id, params) => {
    return request.put(`/rbac/api/user/${id}`, params)
  },
  updatePassword: (id, params) => {
    if (!params.password) {
      throw new Error('没有传入密码')
    }
    return request.put(`/rbac/api/user/${id}/password`, params)
  },
  remove: (id) => {
    return request.delete(`/rbac/api/user/${id}`, {})
  },
  find: (id) => {
    return request.get(`/rbac/api/user/${id}`)
  },
  findByMobile: (mobile) => {
    return request.get(`/rbac/api/user/mobile/${mobile}`)
  },
  getBindRole: (id) => {
    return request.get(`/rbac/api/user/${id}/roles`)
  },
  bindRole: (id, params) => {
    return request.put(`/rbac/api/user/${id}/roles`, params)
  },
  login: (params) => {
    const pattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/
    if (pattern.test(params.username)) {
      params.email = params.username
    } else {
      params.mobile = params.username
    }
    delete params.username
    return request.post(`/rbac/api/auth/login`, params)
  },
  me: () => {
    return request.post(`/rbac/api/auth/me`)
  },
  logout: () => {
    return request.post(`/rbac/api/auth/logout`)
  }
}

