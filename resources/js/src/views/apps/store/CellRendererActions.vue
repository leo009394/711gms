<template>
    <div :style="{'direction': $vs.rtl ? 'rtl' : 'ltr'}">
        <feather-icon icon="Edit3Icon" svgClasses="h-5 w-5 mr-4 hover:text-primary cursor-pointer" @click="editRecord" />
        <feather-icon icon="Trash2Icon" svgClasses="h-5 w-5 hover:text-danger cursor-pointer" @click="confirmDeleteRecord" />
    </div>
</template>

<script>
  export default {
    name: 'CellRendererActions',
    methods: {
      editRecord() {
        this.$router.push("/dashboard/store/detail/" + this.params.data.uuid).catch(() => {})

        /*
          Below line will be for actual product
          Currently it's commented due to demo purpose - Above url is for demo purpose

          this.$router.push("/dashboard/user/" + this.params.data.id).catch(() => {})
        */
      },
      confirmDeleteRecord() {
        this.$vs.dialog({
          type: 'confirm',
          color: 'danger',
          title: `Confirm Delete`,
          text: `You are about to delete "${this.params.data.name}"`,
          accept: this.deleteRecord,
          acceptText: "Delete"
        })
      },
      deleteRecord() {
        /* UnComment below lines for enabling true flow if deleting user */
        this.$store.dispatch("storeManagement/removeRecord", this.params.data.uuid)
          .then(()   => { this.showDeleteSuccess() })
          .catch(err => { console.error(err)       })
      },
      showDeleteSuccess() {
        this.$vs.notify({
          color: 'success',
          title: 'Store Deleted',
          text: 'The selected store was successfully deleted'
        })
      }
    }
  }
</script>
