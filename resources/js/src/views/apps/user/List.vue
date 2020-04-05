<template>
    <div id="data-list-list-user" class="data-list-container">

        <div class="vx-row mb-5">
            <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                <vs-button class="bg-primary-gradient w-full" icon-pack="feather" icon="icon-plus"
                           @click="$router.push('/dashboard/user/detail/create')">{{$t('Add')}}
                </vs-button>
            </div>
        </div>

        <vx-card ref="filterCard" title="Filters" class="user-list-filters mb-8" actionButtons @refresh="resetColFilters" @remove="resetColFilters">
            <div class="vx-row mb-5">
                <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">{{$t('User.Rank')}}</label>
                    <v-select :options="rankOptions" :clearable="false" :dir="$vs.rtl ? 'rtl' : 'ltr'" v-model="rankFilter" class="mb-4 md:mb-0" />
                </div>
                <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">{{$t('User.EmployeeNumber')}}</label>
                    <vs-input class="sm:mr-4 mr-0 sm:w-auto w-full sm:order-normal order-3 sm:mt-0 mt-4"
                              v-model="searchEmployeeNumber" placeholder="Search..."/>
                </div>
                <div class="vx-col md:w-1/2 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">{{$t('User.Name')}}</label>
                    <vs-input class="sm:mr-4 mr-0 sm:w-auto w-full sm:order-normal order-3 sm:mt-0 mt-4"
                              v-model="searchName" placeholder="Search..."/>
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
                             :rowData="usersData">
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
  import moduleUserManagement from '@/store/user-management/moduleUserManagement.js'
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
        rankFilter: { label: 'All', value: '' },
        rankOptions: [
          { label: 'All', value: '' },
          { label: 'A', value: 'A' },
          { label: 'B', value: 'B' },
          { label: 'C', value: 'C' },
        ],
        searchName : '',
        searchEmployeeNumber : '',
        // AgGrid
        columnDefs: [
          {
            headerName: this.$t('No'),
            width: 80,
            field: 'id',
          },
          {
            headerName: this.$t('User.Name'),
            valueGetter: function (params) {
              console.log(params)
              return params.data.first_name + ' ' + params.data.last_name;
            }
          },
          {
            headerName: this.$t('User.EmployeeNumber'),
            field: 'employee_number',
          },
          {
            headerName: this.$t('User.Rank'),
            width: 120,
            field: 'rank',
          },
          {
            headerName: this.$t('User.Email'),
            field: 'email',
          },
          {
            headerName: this.$t('User.Phone'),
            field: 'phone',
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
      if (!moduleUserManagement.isRegistered) {
        vm.$store.registerModule('userManagement', moduleUserManagement)
        moduleUserManagement.isRegistered = true
      }
      vm.$store.dispatch("userManagement/fetchUsers", {
        page: vm.currentPage,
        limit: vm.perPage
      }).catch(err => {
        console.error(err)
      })
    },
    computed: {
      usersData() {
        return this.$store.state.userManagement.users.items
      },
      paginationTotal() {
        console.log(this.$store.state.userManagement.users);
        return this.$store.state.userManagement.users.pagination
          ? this.$store.state.userManagement.users.pagination.total : 0
      },
      paginationTotalPage() {
        return this.$store.state.userManagement.users.pagination
          ? this.$store.state.userManagement.users.pagination.total_pages : 0
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
        vm.$store.dispatch("userManagement/fetchUsers", {
          page: vm.currentPage,
          limit: vm.perPage,
          name : vm.searchName ,
          rank : vm.rankFilter.value,
          employee_number: vm.searchEmployeeNumber,
        }).catch(err => {
          console.error(err)
        })
      },
      resetColFilters () {
        vm.currentPage = 1
        vm.rankFilter = {label: 'All', value: ''};
        vm.searchName = '';
        vm.searchEmployeeNumber = '';
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
