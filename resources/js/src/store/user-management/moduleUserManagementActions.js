/*=========================================================================================
  File Name: moduleCalendarActions.js
  Description: Calendar Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import axios from "@/axios.js"

export default {
  // addItem({ commit }, item) {
  //   return new Promise((resolve, reject) => {
  //     axios.post("/api/data-list/products/", {item: item})
  //       .then((response) => {
  //         commit('ADD_ITEM', Object.assign(item, {id: response.data.id}))
  //         resolve(response)
  //       })
  //       .catch((error) => { reject(error) })
  //   })
  // },
  createRecord({ commit },  obj) {
    return new Promise((resolve, reject) => {
      axios.post(`/v1/api/users`, obj)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchUsers({commit}, params) {
    const queryString = Object.keys(params).filter(key => params[key]).map(key => key + '=' + params[key]).join('&');

    return new Promise((resolve, reject) => {
      axios.get("/v1/api/users" + (queryString ? '?' + queryString : ''))
        .then((response) => {
          commit('SET_USERS', response.data.data)
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  fetchUser({}, userUuid) {
    return new Promise((resolve, reject) => {
      axios.get(`/v1/api/users/${userUuid}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchAddressUser({}, zipCode) {
    return new Promise((resolve, reject) => {
      zipCode = zipCode || '';
      axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
      axios.get(`https://api.zipaddress.net/?zipcode=${zipCode}`,  { headers: {} })
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, userUuid) {
    return new Promise((resolve, reject) => {
      axios.put(`/v1/api/users/${userUuid}`, {
        active : 0
      })
        .then((response) => {
          commit('REMOVE_RECORD', userUuid)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  editRecord({ commit }, obj) {
    return new Promise((resolve, reject) => {
      axios.put(`/v1/api/users/${obj.uuid}`, obj)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
