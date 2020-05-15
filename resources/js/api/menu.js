import request from '../utils/request'

export default {
  get: (params = {}) => {

    return request.get('/api/rbac/menu?t' , {params:params})
  },
  getAll: (params = {}) => {
    return request.get('/api/rbac/menu/all', params)
  },
  append: (params) => {
    return request.post('/api/rbac/menu', params)
  },
  update: (id, params) => {
    return request.put(`/api/rbac/menu/${id}`, params)
  },
  remove: (id) => {
    return request.delete(`/api/rbac/menu/${id}`, {})
  },
  find: (id) => {
    return request.get(`/api/rbac/menu/${id}`)
  },
  bindApi: (id, params) => {
    return request.put(`/api/rbac/menu/${id}/apis`, params)
  },
  getBindApis: (id) => {
    return request.get(`/api/rbac/menu/${id}/apis`)
  }
}
