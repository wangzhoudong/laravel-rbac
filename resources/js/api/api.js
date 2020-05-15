import request from '../utils/request'

export default {
  query: (params = {}) => {
    return request.get('/api/rbac/api', { params })
  },
  get: (params = {}) => {
    return request.get('/api/rbac/api/all', { params })
  },
  append: (params) => {
    return request.post('/api/rbac/api', params)
  },
  update: (id, params) => {
    return request.put(`/api/rbac/${id}`, params)
  },
  remove: (id) => {
    return request.delete(`/api/rbac/api/${id}`, {})
  },
  find: (id) => {
    return request.get(`/api/rbac/api/${id}`)
  },
  getModules: () => {
      return request.get(`/api/rbac/api/modules`)
  }
}
