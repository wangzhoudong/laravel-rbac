import user from '../../api/user'
import Cookies from 'js-cookie'

const state = {
  item: {},
  list: {},
  formProps: {
    visible: false,
    name: ''
  },
  bindProps: {
    visible: false,
    bindRoleIds: []
  },
  updatePasswordProps: {
    visible: false
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
  },
  SET_UPDATE_PASSWORD_PROPS: (state, payload = {}) => {
    state.updatePasswordProps = {
      ...state.updatePasswordProps,
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
      user.query(params).then(({ data }) => {
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
      user.find(id).then(({ data }) => {
        commit('SET_ITEM', { item: data })
        resolve(data)
      })
    })
  },
  getBindRoleIds({ commit }, params = {}) {
    const { id } = params
    if (!id) {
      throw new Error('没有传入ID')
    }
    return new Promise(resolve => {
      user.getBindRole(id).then(({ data }) => {
        commit('SET_BIND_PROPS', { bindRoleIds: data })
        resolve(data)
      })
    })
  },
  login({ commit }, params) {
    return new Promise((resolve, reject) => {
      user.login(params).then(({ data }) => {
        // 处理token
        Cookies.set('TOKEN', data)
        resolve(data)
      }).catch(({ data }) => {
        reject(data)
      })
    })
  },
  me() {
    return new Promise(resolve => {
      user.me().then(({ data }) => {
        Cookies.set('USER', data)
        resolve(data)
      })
    })
  },
  logout() {
    return new Promise(resolve => {
      user.logout().then(({ data }) => {
        Cookies.remove('TOKEN')
        Cookies.remove('USER')
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

