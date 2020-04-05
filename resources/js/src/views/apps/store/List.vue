<template>
    <div id="data-list-list-store" class="data-list-container">

        <div class="vx-row mb-5">
            <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                <vs-button class="bg-primary-gradient w-full" icon-pack="feather" icon="icon-plus"
                           @click="$router.push('/dashboard/store/detail/create')">{{$t('Add')}}
                </vs-button>
            </div>
        </div>

        <vx-card ref="filterCard" title="Filters" class="user-list-filters mb-8" actionButtons @refresh="resetColFilters" @remove="resetColFilters">
            <div class="vx-row mb-5">
                <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">{{$t('Store.Name')}}</label>
                    <vs-input class="sm:mr-4 mr-0 sm:w-auto w-full sm:order-normal order-3 sm:mt-0 mt-4"
                              v-model="filter.name" placeholder="Search..."/>
                </div>
                <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">{{$t('Store.Phone')}}</label>
                    <vs-input class="sm:mr-4 mr-0 sm:w-auto w-full sm:order-normal order-3 sm:mt-0 mt-4"
                              v-model="filter.phone" placeholder="Search..."/>
                </div>
                <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">{{$t('Store.Address')}}</label>
                    <vs-input class="sm:mr-4 mr-0 sm:w-auto w-full sm:order-normal order-3 sm:mt-0 mt-4"
                              v-model="filter.address" placeholder="Search..."/>
                </div>
                <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">{{$t('Store.OwnerName')}}</label>
                    <vs-input class="sm:mr-4 mr-0 sm:w-auto w-full sm:order-normal order-3 sm:mt-0 mt-4"
                              v-model="filter.owner_name" placeholder="Search..."/>
                </div>
                <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">{{$t('Store.OwnerMail')}}</label>
                    <vs-input class="sm:mr-4 mr-0 sm:w-auto w-full sm:order-normal order-3 sm:mt-0 mt-4"
                              v-model="filter.owner_mail" placeholder="Search..."/>
                </div>
                <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">{{$t('Store.ManagerName')}}</label>
                    <vs-input class="sm:mr-4 mr-0 sm:w-auto w-full sm:order-normal order-3 sm:mt-0 mt-4"
                              v-model="filter.manager_name" placeholder="Search..."/>
                </div>
                <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">{{$t('Store.ManagerMail')}}</label>
                    <vs-input class="sm:mr-4 mr-0 sm:w-auto w-full sm:order-normal order-3 sm:mt-0 mt-4"
                              v-model="filter.manager_mail" placeholder="Search..."/>
                </div>
                <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">{{$t('Store.InChargerName')}}</label>
                    <vs-input class="sm:mr-4 mr-0 sm:w-auto w-full sm:order-normal order-3 sm:mt-0 mt-4"
                              v-model="filter.in_charger_name" placeholder="Search..."/>
                </div>
                <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">{{$t('Store.InChargerMail')}}</label>
                    <vs-input class="sm:mr-4 mr-0 sm:w-auto w-full sm:order-normal order-3 sm:mt-0 mt-4"
                              v-model="filter.in_charger_mail" placeholder="Search..."/>
                </div>
            </div>
            <div class="vx-row">
                <div class="vx-col md:w-3/4 sm:w-1/2 w-full"></div>
                <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                    <vs-button class="bg-primary-gradient w-full" icon-pack="feather" icon="icon-search"
                               @click="refreshData(true)">{{$t('Search')}}
                    </vs-button>
                </div>
            </div>
        </vx-card>
        <div class="vx-card p-6">

            <div class="flex flex-wrap items-center">
                <!-- ITEMS PER PAGE -->
                <div class="flex-grow">
                    <vs-dropdown vs-trigger-click class="cursor-pointer">
                        <div class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium">
                            <span class="mr-2">{{ currentPage * perPage - (perPage - 1) }} - {{ paginationTotal - currentPage * perPage > 0 ? currentPage * perPage : paginationTotal }} of {{ paginationTotal }}</span>
                            <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4"/>
                        </div>
                        <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
                        <vs-dropdown-menu>

                            <vs-dropdown-item @click="setPerPage(10)">
                                <span>10</span>
                            </vs-dropdown-item>
                            <vs-dropdown-item @click="setPerPage(20)">
                                <span>20</span>
                            </vs-dropdown-item>
                            <vs-dropdown-item @click="setPerPage(25)">
                                <span>25</span>
                            </vs-dropdown-item>
                            <vs-dropdown-item @click="setPerPage(30)">
                                <span>30</span>
                            </vs-dropdown-item>
                        </vs-dropdown-menu>
                    </vs-dropdown>
                </div>

                <!-- AgGrid Table -->
                <ag-grid-vue style="width: 100%;"
                             class="ag-theme-material w-100 my-4 ag-grid-table"
                             colResizeDefault="shift"
                             :columnDefs="columnDefs"
                             :rowData="storesData">
                </ag-grid-vue>
                <vs-pagination
                        :total="paginationTotalPage"
                        :max="7"
                        v-model="currentPage"/>

            </div>
        </div>
    </div>
</template>

<script>
  import vSelect from 'vue-select'
  import {AgGridVue} from "ag-grid-vue"
  import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'
  import moduleStoreManagement from '@/store/store-management/moduleStoreManagement.js'
  import CellRendererActions from "../user/CellRendererActions";
  let vm = null

  export default {
    components: {
      AgGridVue,
      vSelect,
      CellRendererActions,

    },
    data() {
      return {
        // Filter Options
        filter : {
          name : '',
          phone : '',
          address : '',
          owner_name : '',
          owner_mail : '',
          manager_name : '',
          manager_mail : '',
          in_charger_name : '',
          in_charger_mail : ''
        },
        // AgGrid
        columnDefs: [
          {
            headerName: this.$t('No'),
            width: 80,
            valueGetter: function (params) {
              return params.column.colDef.id;
            }
          },
          {
            headerName: this.$t('Store.Name'),
            valueGetter: function (params) {
              console.log(params)
              return params.data.name;
            }
          },
          {
            headerName: this.$t('Store.ManageName'),
            valueGetter: function (params) {
              return params.data.manager_user ? params.data.manager_user.first_name + ' ' + params.data.manager_user.last_name : '';
            }
          },
          {
            headerName: this.$t('Store.ManageMail'),
            valueGetter: function (params) {
              return params.data.manager_user ? params.data.manager_user.email : '';
            }
          },
          {
            headerName: this.$t('Store.InChargerName'),
            valueGetter: function (params) {
              return params.data.in_charger_user ? params.data.in_charger_user.first_name + ' ' + params.data.in_charger_user.last_name: '';
            }
          },
          {
            headerName: this.$t('Store.InChargerMail'),
            valueGetter: function (params) {
              return params.data.in_charger_user ? params.data.in_charger_user.email : '';
            }
          },
          {
            headerName: this.$t('Store.Status'),
            valueGetter: function (params) {
              return params.data.active ? '作業中' : '終了';
            }
          },
          {
            headerName: 'Actions',
            cellRendererFramework: 'CellRendererActions',
          }
        ],
        currentPage: 1,
        perPage: 10,
      }
    },
    created: function () {
      vm = this
      if (!moduleStoreManagement.isRegistered) {
        vm.$store.registerModule('storeManagement', moduleStoreManagement)
        moduleStoreManagement.isRegistered = true
      }
      vm.$store.dispatch("storeManagement/fetchStores", {
        page: vm.currentPage,
        limit: vm.perPage
      }).catch(err => {
        console.error(err)
      })
    },
    computed: {
      storesData() {
        return this.$store.state.storeManagement.stores.items
      },
      paginationTotal() {
        return this.$store.state.storeManagement.stores.pagination
          ? this.$store.state.storeManagement.stores.pagination.total : 0
      },
      paginationTotalPage() {
        return this.$store.state.storeManagement.stores.pagination
          ? this.$store.state.storeManagement.stores.pagination.total_pages : 0
      },
    },
    methods: {
      setPerPage(perPage) {
        vm.currentPage = 1
        vm.perPage = perPage
      },
      refreshData(isSearch) {
        if(isSearch) {
          vm.currentPage = 1
        }
        let payload = vm.filter;
        payload.page = vm.currentPage;
        payload.limit = vm.perPage;

        vm.$store.dispatch("storeManagement/fetchStores", payload).catch(err => {
          console.error(err)
        })
      },
      resetColFilters () {
        vm.currentPage = 1
        vm.filter = {
          name : '',
          phone : '',
          address : '',
          owner_name : '',
          owner_mail : '',
          manager_name : '',
          manager_mail : '',
          in_charger_name : '',
          in_charger_mail : ''
        };
        vm.$refs.filterCard.removeRefreshAnimation()
      }
    },
    watch: {
      'currentPage': function () {
        vm.refreshData()
      },
      'perPage': function () {
        vm.refreshData()
      },
    }
  }
</script>

<style scoped>

</style>
