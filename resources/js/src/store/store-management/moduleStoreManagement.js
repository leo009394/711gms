/*=========================================================================================
  File Name: moduleStoreManagement.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import state from './moduleStoreManagementState.js'
import mutations from './moduleStoreManagementMutations.js'
import actions from './moduleStoreManagementActions.js'
import getters from './moduleStoreManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state: state,
  mutations: mutations,
  actions: actions,
  getters: getters
}

