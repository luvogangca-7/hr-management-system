import { createStore } from 'vuex'

export default createStore({
  state: {
    isAdmin: true
  },
  getters: {
  },
  mutations: {
    adminRole(state){
      state.isAdmin = true
    },
    staffRole(state){
      state.isAdmin = false
    }
  },
  actions: {
  },
  modules: {
  }
})
