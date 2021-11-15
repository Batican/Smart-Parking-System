<template>
  <div class="header">
    <nav class="navbar navbar-light bg-light navbar-expand-lg">
      <router-link :to="{ name: 'user' }" class="navbar-brand"
        >Parking System</router-link
      >
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav" 
        aria-expanded="false" 
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navbarNav" class="collapse navbar-collapse">
        <ul class="navbar-nav">

          <li class="nav-item">
            <router-link
              class="nav-link"
              data-toggle="collapse"
              :to="{ name: 'user' }"
            >
              Users
            </router-link>
          </li>
        
          <li class="nav-item ">
            <router-link
              class="nav-link"
              data-toggle="collapse"
              :to="{ name: 'Departments' }"
            >
              Departments
            </router-link>
          </li>
          
          <li class="nav-item">
            <router-link
              class="nav-link"
              data-toggle="collapse"
              :to="{ name: 'ParkingSlot' }"
            >
              Parking Slots
            </router-link>
          </li>

          

        </ul>
      </div>
    </nav>

    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  watch: {
    $route() {
      $("#navbarCollapse").collapse("hide");
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
