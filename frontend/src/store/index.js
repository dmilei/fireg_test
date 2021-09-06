import Vue from 'vue'
import Vuex from 'vuex'
import axios from "axios";

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    options: {
      customerSites: [],
      equipmentTypes: [],
    },
    fireExtinguishers: []
  },
  mutations: {
    updateOptions (state, options) {
      state.options.customerSites = options.customer_sites
      state.options.equipmentTypes = options.equipment_types
    },
    updateFireExtinguishers (state, data) {
      state.fireExtinguishers = data
    },
  },
  actions: {
    fetchOptions({ commit }) {
      return new Promise((resolve) => {
        axios.get('http://localhost:9000/api/options')
            .then((response) => {
              commit('updateOptions', response.data)
              resolve()
            })
      })
    },
    fetchFireExtinguishers({ commit }) {
      axios.get('http://localhost:9000/api/extinguishers')
          .then((response) => {
            commit('updateFireExtinguishers', response.data)
          })
    },
    saveFireExtinguisher ({ commit }, payload) {
      return new Promise((resolve, reject) => {
        axios.post('http://localhost:9000/api/extinguishers', payload)
            .then((response) => {
              resolve(response)
            })
            .catch((err) => {
              console.log(err)
              const errors = []
              Object.keys(err.response.data.errors).forEach((key) => {
                err.response.data.errors[key].forEach((item) => errors.push(item))
              });
              reject(errors)
            })
      })
    },
    updateFireExtinguisher ({ commit }, {id, payload}) {
        return new Promise((resolve, reject) => {
            axios.put(`http://localhost:9000/api/extinguishers/${id}`, payload)
                .then((response) => {
                    resolve(response)
                })
                .catch((err) => {
                    console.log(err)
                    const errors = []
                    Object.keys(err.response.data.errors).forEach((key) => {
                        err.response.data.errors[key].forEach((item) => errors.push(item))
                    });
                    reject(errors)
                })
        })
    },
    deleteFireExtinguisher ({ commit }, id) {
        return new Promise((resolve, reject) => {
            axios.delete(`http://localhost:9000/api/extinguishers/${id}`)
                .then(response => resolve(response))
                .catch((err) => {
                    console.log(err)
                    reject(err)
                })
        })
    }
  },
  modules: {
  }
})
