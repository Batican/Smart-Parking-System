<template>
  <v-app id="inspire" >
    <app-nav-bar :is_open="drawer"></app-nav-bar>

    <app-bar @changeStatusDrawer="drawer = !drawer"></app-bar>

    <app-main></app-main>
  </v-app>
</template>

<script>
  import AppBar from "../Layouts/Includes/AppBar.vue"
  import AppNavBar from "../Layouts/Includes/AppNavBar.vue"
  import AppMain from "../Layouts/Includes/AppMain.vue"

  export default {
    data: () => ({ 
      drawer: true,
    }),
    components : {
      AppBar,
      AppNavBar,
      AppMain,
    }
  }
</script>