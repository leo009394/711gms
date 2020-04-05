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
  fetchStores({commit}, params) {
    const queryString = Object.keys(params).filter(key => params[key]).map(key => key + '=' + params[key]).join('&');

    return new Promise((resolve, reject) => {
      axios.get("/v1/api/stores" + (queryString ? '?' + queryString : ''))
        .then((response) => {
          commit('SET_STORES', response.data.data)
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  fetchUser({}, userUuid) {
    return new Promise((resolve, reject) => {
      axios.get(`/v1/api/stores/${userUuid}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, userUuid) {
    return new Promise((resolve, reject) => {
      axios.put(`/v1/api/stores/${userUuid}`, {
        active : 0
      })
        .then((response) => {
          commit('REMOVE_RECORD', userUuid)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  editRecord({ commit }, userUuid, obj) {
    return new Promise((resolve, reject) => {
      axios.put(`/v1/api/stores/${userUuid}`, obj)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
