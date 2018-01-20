<template>
  <div class="navigation">

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="#">FF</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>


      <welcome-nav-items></welcome-nav-items>
     
    </nav>
  </div>
</template>

<script>
import welcomeNavItems from './welcome-nav-items.vue'
  export default {
    name: 'welcome-nav-list',
    components: {
      'welcome-nav-items': welcomeNavItems
    }
  }
</script>

<style scoped>
  form input {
    width: 100%;
  }
</style>