import api from '../../api/api'
import role from "../../api/role";

const state = {
  list: {},
  formProps: {
    visible: false,
    name: '',
    modules: []
  }
}

const mutations = {
  SET_LIST: (state, payload = {}) => {
    state.list = payload.list
  },
  SET_FORM_PROPS: (state, payload = {}) => {
    state.formProps = {
      ...state.formProps,
      ...payload
    }
  }
}

const actions = {
  getList({ commit }, params = {}) {
    Object.keys(params).forEach(param => {
      if (params[param] === '') { delete params[param] }
    })
    return new Promise(resolve => {
      api.query(params).then(({ data }) => {
        commit('SET_LIST', { list: data })
        resolve(data)
      })
    })
  },
getDetail({ commit }, params = {}) {
    const { id } = params
    if (!id) {
        throw new Error('没有传入ID')
    }
    return new Promise(resolve => {
        api.find(id).then(({ data }) => {
            commit('SET_FORM_PROPS', { item: data })
            resolve(data)
        })
    })
},
  getModules({ commit }) {
    return new Promise((resolve, reject) => {
      api.getModules().then(({ data }) => {
        data.unshift({
          label: '全部',
          value: null
        })
        commit('SET_FORM_PROPS', { modules: data })
        resolve(data)
      })
    })
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}

