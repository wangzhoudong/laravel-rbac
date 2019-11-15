import request from '../utils/request'

export default {
  get: (params = {}) => {

    return request.get('/rbac/api/menu?t' , {params:params})
  },
  getAll: (params = {}) => {
    return request.get('/rbac/api/menu/all', params)
  },
  append: (params) => {
    return request.post('/rbac/api/menu', params)
  },
  update: (id, params) => {
    return request.put(`/rbac/api/menu/${id}`, params)
  },
  remove: (id) => {
    return request.delete(`/rbac/api/menu/${id}`, {})
  },
  find: (id) => {
    return request.get(`/rbac/api/menu/${id}`)
  },
  bindApi: (id, params) => {
    return request.put(`/rbac/api/menu/${id}/apis`, params)
  },
  getBindApis: (id) => {
    return request.get(`/rbac/api/menu/${id}/apis`)
  }
}
