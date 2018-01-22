<template>
  <div class="">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="#">FF</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <nav-items></nav-items>
      <div class="btn-group">
        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <button class="dropdown-item" type="button">Profile</button>
          <button class="dropdown-item" type="button">Another action</button>
          <div class="dropdown-divider"></div>
          <router-link class="nav-item" tag="li" to="/">
            <button class="dropdown-item" type="button">Logout</button>
          </router-link>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
  import navItems from './nav-items.vue'
  export default {
    name: 'nav-list',
    components: {
      'nav-items': navItems
    }
  }
</script>

<style scoped>
  form input {
    width: 100%;
  }

  .dropdown-menu {
    right: 0;
    left: auto;
    top: 57px;
  }
</style>