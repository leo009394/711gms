/*=========================================================================================
  File Name: moduleAuthActions.js
  Description: Auth Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import jwt from "../../http/requests/auth/jwt/index.js"


import firebase from 'firebase/app'
import 'firebase/auth'
import router from '@/router'

export default {
    // JWT
    loginJWT({ commit }, payload) {

      return new Promise((resolve,reject) => {
        jwt.login(payload.userDetails.email, payload.userDetails.password)
          .then(response => {
              console.log(response.data.user_data)
            // If there's user data in response
            if(response.data.user_data) {
              // Navigate User to homepage
              router.push(router.currentRoute.query.to || '/')

              // Set accessToken
                localStorage.setItem("accessToken", response.data.access_token)
                localStorage.setItem("tokenExpiry", response.data.expires_at)
                localStorage.setItem("loggedIn", true)

                // Update user details
              commit('UPDATE_USER_INFO', response.data.user_data, {root: true})

              // Set bearer token in axios
              commit("SET_BEARER", response.data.access_token)

              resolve(response)
            }else {
              reject({message: "Wrong Email or Password"})
            }

          })
          .catch(error => { reject(error) })
      })
    },
    fetchAccessToken() {
      return new Promise((resolve) => {
        jwt.refreshToken().then(response => { resolve(response) })
      })
    }
}
