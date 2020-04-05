<template>
    <div id="user-edit-tab-info">
        <vx-card title="User Info" code-toggler>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('User.Name')}}</span>
                </div>
                <div class="vx-row vx-col sm:w-5/12">
                    <div class="vx-col sm:w-1/12 mt-3">
                        <span>({{$t('User.First')}})</span>
                    </div>
                    <div class="vx-col sm:w-11/12">
                        <vs-input class="w-full"  v-model="user_data.first_name" v-validate="'required'"
                                  name="first_name"/>
                        <span class="text-danger text-sm" >{{ errors.first('first_name') }}</span>
                    </div>
                </div>
                <div class="vx-row vx-col sm:w-5/12">
                    <div class="vx-col sm:w-1/12 mt-3">
                        <span>({{$t('User.Last')}})</span>
                    </div>
                    <div class="vx-col sm:w-11/12">
                        <vs-input class="w-full" v-model="user_data.last_name" v-validate="'required'"
                                  name="last_name"/>
                        <span class="text-danger text-sm" >{{ errors.first('last_name') }}</span>
                    </div>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('User.Name')}}({{$t('User.Kana')}})</span>
                </div>
                <div class="vx-row vx-col sm:w-5/12">
                    <div class="vx-col sm:w-1/12 mt-3">
                        <span>({{$t('User.First')}})</span>
                    </div>
                    <div class="vx-col sm:w-11/12">
                        <vs-input class="w-full" v-model="user_data.local_first_name" v-validate="'required'"
                                  name="local_first_name"/>
                        <span class="text-danger text-sm" v-show="errors.has('local_first_name')">{{ errors.first('local_first_name') }}</span>
                    </div>
                </div>
                <div class="vx-row vx-col sm:w-5/12">
                    <div class="vx-col sm:w-1/12 mt-3">
                        <span>({{$t('User.Last')}})</span>
                    </div>
                    <div class="vx-col sm:w-11/12">
                        <vs-input class="w-full" v-model="user_data.local_last_name" v-validate="'required'"
                                  name="local_last_name"/>
                        <span class="text-danger text-sm" v-show="errors.has('local_last_name')">{{ errors.first('local_last_name') }}</span>
                    </div>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('User.EmployeeNumber')}}</span>
                </div>
                <div class="vx-col">
                    <vs-input class="w-full" v-model="user_data.employee_number" name="employee_number"/>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('User.Birthday')}}</span>
                </div>
                <div class="vx-col">
                    <flat-pickr v-model="user_data.birthdate" :config="{ dateFormat: 'Y-m-d', maxDate: new Date() }"
                                class="w-full" v-validate="'required'" name="birthdate"/>
                    <span class="text-danger text-sm" v-show="errors.has('birthdate')">{{ errors.first('birthdate') }}</span>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('User.Rank')}}</span>
                </div>
                <div class="vx-col sm:w-1/6">
                    <v-select :options="rankOptions" v-model="rank_local" class="mb-4 md:mb-0"/>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('User.Store')}}</span>
                </div>
                <div class="vx-col sm:w-1/6">
                    <v-select :options="storeOptions" v-model="store_local" name="store" class="mb-4 md:mb-0"/>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('User.Email')}}</span>
                </div>
                <div class="vx-col">
                    <vs-input
                            v-validate="'required|email|min:3'"
                            data-vv-validate-on="blur"
                            name="email"
                            placeholder="メール"
                            v-model="user_data.email"
                            class="w-full"/>
                    <span class="text-danger text-sm" v-show="errors.has('email')">{{ errors.first('email') }}</span>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('User.Phone')}}</span>
                </div>
                <div class="vx-col">
                    <vs-input class="w-full" v-model="user_data.phone" name="phone"/>
                    <span class="text-danger text-sm" v-show="errors.has('phone')">{{ errors.first('phone') }}</span>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('User.ZipCode')}}</span>
                </div>
                <div class="vx-col">
                    <vs-input class="w-full" v-model="user_data.zip_code" name="zip_code"/>
                </div>
                <div class="vx-col">
                    <vs-button class="bg-primary-gradient w-full" icon-pack="feather" icon="icon-search" @click="fetch_address_user(user_data.zip_code)"                   >{{$t('User.GetAddress')}}
                    </vs-button>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('User.State')}}</span>
                </div>
                <div class="vx-col sm:w-1/6">
                    <v-select :options="stateOptions" v-model="state_local" name="state" class="mb-4 md:mb-0"/>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-row vx-col sm:w-1/2">
                    <div class="vx-col sm:w-1/3 mt-3">
                        <span>{{$t('User.City')}}</span>
                    </div>
                    <div class="vx-col">
                        <vs-input class="w-full" v-model="user_data.city" name="city"/>
                    </div>
                </div>
                <div class="vx-row vx-col sm:w-1/2">
                    <div class="vx-col sm:w-1/3 mt-3">
                        <span>{{$t('User.Street')}}</span>
                    </div>
                    <div class="vx-col">
                        <vs-input class="w-full" v-model="user_data.street" name="street"/>
                    </div>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/6 mt-3">
                    <span>{{$t('User.Building')}}</span>
                </div>
                <div class="vx-col">
                    <vs-input class="w-full" v-model="user_data.building" name="building"/>
                </div>
            </div>
            <div class="vx-row">
                <div class="vx-col md:w-3/4 sm:w-1/2 w-full"></div>
                <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                    <vs-button class="bg-primary-gradient w-full" @click="save_changes"  >{{$t('OK')}}</vs-button>
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
        rankOptions: [
          {label: 'A', value: 'A'},
          {label: 'B', value: 'B'},
          {label: 'C', value: 'C'},
        ],

        storeOptions: [],
        stateOptions: [],

        user_data: {
          uuid: '',
          first_name: '',
          local_first_name: '',
          last_name: '',
          local_last_name: '',
          employee_number: '',
          rank: '',
          birthdate: '',
          phone: null,
          email: '',
          zip_code: '',
          state: '',
          city: '',
          street: '',
          building: '',
          active: 1,
          stores: []
        },
        user_not_found: false,
      }
    },
    methods: {
      save_changes() {
        vm.$validator.validateAll().then(result => {
          if (result) {
            if (vm.user_data.uuid) {
              return vm.$store.dispatch("userManagement/editRecord", vm.user_data)
            } else {
              return vm.$store.dispatch("userManagement/createRecord", vm.user_data)
            }
          } else {
            throw new Error('Form invalid')
          }
        }).then(() => {
          // this.$router.push("/dashboard/user/list-view")
        })
          .catch((err) => {
            if (vm.user_data.uuid) {
              vm.$toastr.error(vm.$t('Message.UpdateFail'), vm.$t('Message.UpdateFail'), {})
            } else {
              vm.$toastr.error(vm.$t('Message.CreateFail'), vm.$t('Message.CreateFail'), {})
            }
          })
      },
      capitalize(str) {
        return str.slice(0, 1).toUpperCase() + str.slice(1, str.length)
      },
      fetch_user_data(uuid) {
        vm.$store.dispatch("userManagement/fetchUser", uuid)
          .then(res => {
            vm.user_data = res.data.data.item
          })
          .catch(err => {
            if (err.response.status === 404) {
              this.user_not_found = true
              return
            }
            console.error(err)
          })
      },
      fetch_store_list() {
        vm.$store.dispatch("storeManagement/fetchStores", {ignore_limit: 1})
          .then(res => {
            vm.storeOptions = res.data.data.items.map(item => {
              return {label: item.name, value: item.uuid}
            })
          })
          .catch(err => {
            vm.storeOptions = []
            console.error(err)
          })
      },
      fetch_address_user(zipCode) {
        vm.$store.dispatch("userManagement/fetchAddressUser", zipCode)
          .then(res => {
            vm.stateOptions = res.data.data.length > 0 ? res.data.data.items.map(state => {
              return {label: state.state_name, value: state.state_name}
            }) : [];
          })
          .catch(err => {
            this.stateOptions = [];
            console.error(err)
          })
      }
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
          this.fetch_user_data(this.$route.params.uuid)
        }
      })
    },
    computed: {
      rank_local: {
        get() {
          return vm.rankOptions.find(rank => rank.value == this.user_data.rank)
        },
        set(obj) {
          vm.user_data.rank = obj.value
        }
      },
      store_local: {
        get() {
          let storeUuid = vm.user_data.stores.length > 0 ? vm.user_data.stores[0].uuid : '';
          return vm.storeOptions.find(store => store.value == storeUuid) || vm.storeOptions[0]
        },
        set(obj) {
          vm.user_data.stores = [{
            uuid: obj.value
          }]
        }
      },
      state_local: {
        get() {
          return vm.stateOptions.find(state => state.value == this.user_data.state)
        },
        set(obj) {
          vm.user_data.state = obj.value
        }
      },
    },
  }
</script>

<style scoped>

</style>