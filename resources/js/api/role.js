import request from '../utils/request'

export default {
  query: (params = {}) => {
    return request.get('/rbac/api/role', { params })
  },
  get: (params = {}) => {
    return request.get('/rbac/api/role/all', { params })
  },
  append: (params) => {
    return request.post('/rbac/api/role', params)
  },
  update: (id, params) => {
    return request.put(`/rbac/api/role/${id}`, params)
  },
  remove: (id) => {
    return request.delete(`/rbac/api/role/${id}`, {})
  },
  find: (id) => {
    return request.get(`/rbac/api/role/${id}`)
  },
  getBindMenus: (id) => {
    return request.get(`/rbac/api/role/${id}/menus`)
  },
  bindMenu: (id, params) => {
    return request.put(`/rbac/api/role/${id}/menus`, params)
  }
}
