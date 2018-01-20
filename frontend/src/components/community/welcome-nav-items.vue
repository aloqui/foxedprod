<template>
  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <router-link class="nav-item" tag="li" to="/" exact>
        <a class="nav-link" href="">Home</a>
      </router-link>
      <router-link class="nav-item" tag="li" to="/test">
        <a class="nav-link" href="">Explore</a>
      </router-link>
      <router-link class="nav-item" tag="li" to="/community">
        <a class="nav-link" href="">Code Now.</a>
      </router-link>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Username" aria-label="Search">
      <input class="form-control mr-sm-2" type="password" placeholder="Password" aria-label="Search">

      <router-link class="nav-item" tag="li" to="/discover">
        <a class="btn btn-success my-2 my-sm-0" type="submit">Log in</a>
      </router-link>
    </form>
  </div>
</template>
<script>
  export default {
    name: 'welcome-nav-items'
  }
</script>

<style>
  li {
    list-style: none;
  }
</style>