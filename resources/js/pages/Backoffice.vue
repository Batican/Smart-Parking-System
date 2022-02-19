<template>
  <v-app id="inspire" >
    <app-nav-bar :is_open="drawer"></app-nav-bar>

    <app-bar @changeStatusDrawer="drawer = !drawer"></app-bar>
    <notification ref="notify"></notification>
    <app-main></app-main>
  </v-app>
</template>

<script>
  import AppBar from "../Layouts/Includes/AppBar.vue"
  import AppNavBar from "../Layouts/Includes/AppNavBar.vue"
  import AppMain from "../Layouts/Includes/AppMain.vue"
  import notification from "../components/Notification.vue"

  export default {
    data: () => ({ 
      drawer: true,
    }),
    components : {
      AppBar,
      AppNavBar,
      AppMain,
      notification
    },
    mounted() {
      
      this.$root.$notify = this.$refs.notify.open
    }
  }
</script>