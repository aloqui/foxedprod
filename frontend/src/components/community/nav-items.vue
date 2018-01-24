<template>
  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <router-link class="nav-item" tag="li" to="/discover" exact>
        <a class="nav-link" href="">Home</a>
      </router-link>
      <router-link class="nav-item" tag="li" to="/community">
        <a class="nav-link" href="">Community</a>
      </router-link>
      <router-link class="nav-item" tag="li" to="/community">
        <a class="nav-link" href="">Code Now.</a>
      </router-link>
      <input class="m-1" type="text" placeholder="Search...">
    </ul>
  </div>
</template>
<script>
  export default {
    name: 'nav-items'
  }
</script>

<style>

</style>