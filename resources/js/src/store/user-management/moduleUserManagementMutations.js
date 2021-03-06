/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_USERS(state, users) {
    state.users = users
  },
  REMOVE_RECORD(state, itemUuid) {
    const userIndex = state.users.items.findIndex((u) => u.uuid == itemUuid)
    state.users.items.splice(userIndex, 1)
  },
}
