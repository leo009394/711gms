/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_STORES(state, stores) {
    state.stores = stores
  },
  REMOVE_RECORD(state, itemUuid) {
    const storeIndex = state.stores.items.findIndex((u) => u.uuid == itemUuid)
    state.stores.items.splice(storeIndex, 1)
  },
}
