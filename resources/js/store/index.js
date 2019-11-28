import Vue from 'vue'
import Vuex from 'vuex'
import getters from './getters'
import app from './modules/app'
import settings from './modules/settings'
import user from './modules/user'
import menu from './modules/menu'
import api from './modules/api'
import role from './modules/role'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    app,
    settings,
    user,
    menu,
    api,
    role
  },
  getters
})

export default store
