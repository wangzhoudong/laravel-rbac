import request from '../utils/request'

export default {
  query: (params = {}) => {
    return request.get('/api/rbac/role', { params })
  },
  get: (params = {}) => {
    return request.get('/api/rbac/role/all', { params })
  },
  append: (params) => {
    return request.post('/api/rbac/role', params)
  },
  update: (id, params) => {
    return request.put(`/api/rbac/role/${id}`, params)
  },
  remove: (id) => {
    return request.delete(`/api/rbac/role/${id}`, {})
  },
  find: (id) => {
    return request.get(`/api/rbac/role/${id}`)
  },
  getBindMenus: (id) => {
    return request.get(`/api/rbac/role/${id}/menus`)
  },
  bindMenu: (id, params) => {
    return request.put(`/api/rbac/role/${id}/menus`, params)
  }
}
