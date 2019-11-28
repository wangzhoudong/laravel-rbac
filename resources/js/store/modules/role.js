import role from '../../api/role'

const state = {
  list: {},
  item: {},
  formProps: {
    visible: false,
    name: ''
  },
  bindProps: {
    visible: false,
    bindMenuIds: []
  }
}

const mutations = {
  SET_LIST: (state, payload = {}) => {
    state.list = payload.list
  },
  SET_ITEM: (state, payload = {}) => {
    state.item = payload.item
  },
  SET_FORM_PROPS: (state, payload = {}) => {
    state.formProps = {
      ...state.formProps,
      ...payload
    }
  },
  SET_BIND_PROPS: (state, payload = {}) => {
    state.bindProps = {
      ...state.bindProps,
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
      role.query(params).then(({ data }) => {
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
      role.find(id).then(({ data }) => {
        commit('SET_ITEM', { item: data })
        resolve(data)
      })
    })
  },
  getBindMenuIds({ commit }, params = {}) {
    const { id } = params
    if (!id) {
      throw new Error('没有传入ID')
    }
    return new Promise(resolve => {
      role.getBindMenus(id).then(({ data }) => {
        commit('SET_BIND_PROPS', { bindMenuIds: data })
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
