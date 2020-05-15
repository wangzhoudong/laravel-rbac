import request from '../utils/request'

export default {
  query: (params = {}) => {
    return request.get('/api/rbac/user', { params })
  },
  get: (params = {}) => {
    return request.get('/api/rbac/user/get', { params })
  },
  append: (params) => {
    return request.post('/api/rbac/user', params)
  },
  update: (id, params) => {
    return request.put(`/api/rbac/user/${id}`, params)
  },
  updatePassword: (id, params) => {
    if (!params.password) {
      throw new Error('没有传入密码')
    }
    return request.put(`/api/rbac/user/${id}/password`, params)
  },
  remove: (id) => {
    return request.delete(`/api/rbac/user/${id}`, {})
  },
  find: (id) => {
    return request.get(`/api/rbac/user/${id}`)
  },
  findByMobile: (mobile) => {
    return request.get(`/api/rbac/user/mobile/${mobile}`)
  },
  getBindRole: (id) => {
    return request.get(`/api/rbac/user/${id}/roles`)
  },
  bindRole: (id, params) => {
    return request.put(`/api/rbac/user/${id}/roles`, params)
  },
  login: (params) => {
    const pattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/
    if (pattern.test(params.username)) {
      params.email = params.username
    } else {
      params.mobile = params.username
    }
    delete params.username
    return request.post(`/api/rbac/auth/login`, params)
  },
  me: () => {
    return request.post(`/api/rbac/auth/me`)
  },
  logout: () => {
    return request.post(`/api/rbac/auth/logout`)
  }
}

