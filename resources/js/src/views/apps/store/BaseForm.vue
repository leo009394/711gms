<template>
    <div id="store-edit-tab-info">
        <vx-card title="Store Info" code-toggler>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('Store.Name')}}</span>
                </div>
                <div class="vx-col">
                    <vs-input class="w-full" v-model="store_data.name" name="name" v-validate="'required'"/>
                    <span class="text-danger text-sm" >{{ errors.first('name') }}</span>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('Store.Phone')}}</span>
                </div>
                <div class="vx-col">
                    <vs-input class="w-full" v-model="store_data.phone" name="phone"/>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('Store.Address')}}</span>
                </div>
                <div class="vx-col">
                    <vs-input class="w-full" v-model="store_data.address" name="address"/>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('Store.ClosingDate')}}</span>
                </div>
                <div class="vx-col">
                    <flat-pickr v-model="store_data.closing_date" :config="{ dateFormat: 'Y-m-d', maxDate: new Date() }"
                                class="w-full" name="closing_date"/>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('Store.Manager')}}</span>
                </div>
                <div class="vx-col sm:w-1/6">
                    <v-select :options="userOptions" v-model="manager_local" name="state" class="mb-4 md:mb-0"/>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('Store.InCharger')}}</span>
                </div>
                <div class="vx-col sm:w-1/6">
                    <v-select :options="userOptions" v-model="in_charger_local" name="state" class="mb-4 md:mb-0"/>
                </div>
            </div>
        </vx-card>
    </div>
</template>

<script>
  import moduleUserManagement from '@/store/user-management/moduleUserManagement.js'
  import moduleStoreManagement from '@/store/store-management/moduleStoreManagement.js'
  import flatPickr from 'vue-flatpickr-component'
  import 'flatpickr/dist/flatpickr.css'
  import vSelect from 'vue-select'

  let vm = null;
  export default {
    name: "BaseForm",
    components: {
      vSelect,
      flatPickr
    },
    data() {
      return {
        userOptions: [],

        store_data: {
          uuid: '',
          phone: '',
          address: '',
          closing_date: '',
          owner_id: '',
          manager_id: '',
          in_charger_id: '',
          active: 1,
        },
        store_not_found: false,
      }
    },
    methods: {
      save_changes() {
        vm.$validator.validateAll().then(result => {
          if (result) {
            if (vm.user_data.uuid) {
              return vm.$store.dispatch("storeManagement/editRecord", vm.user_data)
            } else {
              return vm.$store.dispatch("storeManagement/createRecord", vm.user_data)
            }
          } else {
            throw new Error('Form invalid')
          }
        }).then(() => {
          vm.$toastr.success(vm.$t('Message.UpdateOk'), vm.$t('Message.UpdateOk'), {})
          this.$router.push("/dashboard/store/list-view")
        })
          .catch((err) => {
            if (vm.user_data.uuid) {
              vm.$toastr.error(vm.$t('Message.UpdateFail'), vm.$t('Message.UpdateFail'), {})
            } else {
              vm.$toastr.error(vm.$t('Message.CreateFail'), vm.$t('Message.CreateFail'), {})
            }
          })
      },
      fetch_store_data(uuid) {
        vm.$store.dispatch("storeManagement/fetchStore", uuid)
          .then(res => {
            vm.user_data = res.data.data.item
          })
          .catch(err => {
            if (err.response.status === 404) {
              this.store_not_found = true
              return
            }
            console.error(err)
          })
      },
      fetch_user_list() {
        vm.$store.dispatch("userManagement/fetchUsers", {ignore_limit: 1})
          .then(res => {
            vm.userOptions = res.data.data.items.map(item => {
              return {label: item.email, value: item.id}
            })
          })
          .catch(err => {
            vm.userOptions = []
            console.error(err)
          })
      },
    },
    created() {
      vm = this
      // Register Module UserManagement Module
      if (!moduleUserManagement.isRegistered) {
        vm.$store.registerModule('userManagement', moduleUserManagement)
        moduleUserManagement.isRegistered = true
      }
      if (!moduleStoreManagement.isRegistered) {
        vm.$store.registerModule('storeManagement', moduleStoreManagement)
        moduleStoreManagement.isRegistered = true
      }
      Promise.all([this.fetch_store_list()]).then(() => {
        if (this.$route.params.uuid !== 'create' && this.$route.params.uuid !== undefined) {
          this.fetch_store_data(this.$route.params.uuid)
        }
      })
    },
    computed: {
      manager_local: {
        get() {
          return vm.userOptions.find(user => user.value == vm.store_data.manager_id)
        },
        set(obj) {
          vm.store_data.manager_id = obj.value
        }
      },
      in_charger_local: {
        get() {
          return vm.userOptions.find(user => user.value == vm.store_data.in_charger_id)
        },
        set(obj) {
          vm.store_data.in_charger_id = obj.value
        }
      }
    },
  }
</script>

<style scoped>

</style>