import menuApi from '../../api/menu'

const state = {
  tree: [],
  allTree: [],
  formProps: {
    modelName: '',
    visible: false
  },
  bindProps: {
    visible: false,
    bindApis: []
  },
  item: {}
}

const mutations = {
  SET_TREE: (state, data) => {
    state.tree = treeHandle(data)
  },
  SET_ALL_TREE: (state, data) => {
    state.allTree = treeHandle(data)
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
  SET_ITEM: (state, payload = {}) => {
    state.item = payload.item
  }
}

const actions = {
  get({ commit }) {
    menuApi.get().then(({ data }) => {
      commit('SET_TREE', data)
    })
  },
  getAll({ commit }) {
    menuApi.getAll().then(({ data }) => {
      commit('SET_ALL_TREE', data)
    })
  },
  getBindApis({ commit }, id) {
    return new Promise(resolve => {
      menuApi.getBindApis(id).then(({ data }) => {
        commit('SET_BIND_PROPS', { bindApis: data })
        resolve(data)
      })
    })
  },
  getItem({ commit }, id) {
    return new Promise(resolve => {
      menuApi.find(id).then(({ data }) => {
        commit('SET_ITEM', { item: data })
        resolve(data)
      })
    })
  }
}

const treeHandle = data => {
  const map = new Map()
  data.forEach(item => {
    map.set(item.id, item)
  })

  const tree = []
  data.forEach(item => {
    const mapItem = map.get(item.pid)
    if (mapItem) { // 说明不是顶级
      (mapItem.children || (mapItem.children = [])).push(item)
    } else {
      item.alwaysShow = true
      tree.push(item)
    }
  })

  return tree
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}

