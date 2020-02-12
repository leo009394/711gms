<!-- =========================================================================================
    File Name: TheFooter.vue
    Description: Footer component
    Component Name: TheFooter
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template functional>
    <footer class="the-footer flex-wrap justify-between" :class="classes">
        <p>
          <span>COPYRIGHT &copy;</span>
          <span>{{ new Date().getFullYear() }} </span>
          <a href="https://1.envato.market/vuexy_admin" target="_blank" rel="nofollow">Pixinvent</a>
          <span class="hidden sm:inline-block">, All rights Reserved</span>
        </p>
    </footer>
</template>

<script>
import BuyNow from '../../components/BuyNow.vue'

export default {
    name: "the-footer",
    props: {
        classes: {
            type: String,
        },
    },
    inject: {
      components:{
          default: {
            BuyNow
          }
      }
    }
}
</script>
