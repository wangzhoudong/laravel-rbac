import request from '../utils/request'

export default {
  query: (params = {}) => {
    return request.get('/rbac/api/api', { params })
  },
  get: (params = {}) => {
    return request.get('/rbac/api/api/all', { params })
  },
  append: (params) => {
    return request.post('/rbac/api/api', params)
  },
  update: (id, params) => {
    return request.put(`/rbac/api/api/${id}`, params)
  },
  remove: (id) => {
    return request.delete(`/rbac/api/api/${id}`, {})
  },
  find: (id) => {
    return request.get(`/rbac/api/api/${id}`)
  },
  getModules: () => {
    return request.get(`/rbac/api/api/modules`)
  }
}
