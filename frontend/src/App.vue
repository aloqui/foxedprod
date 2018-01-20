<template>
  <div class="" id="app">
    <navbar></navbar>
    <div class="">
    <router-view class="mt-5" :key="$route.path"></router-view>
    </div>
  </div>
</template>

<script>
import Navbar from './components/Navbar.vue'
// import Login from './components/authentication/Login.vue'
// import Register from './components/authentication/Register.vue'

export default {
  components: {
    'navbar' : Navbar,
    // 'login' : Login,
    // 'register' : Register
  }
}
</script>

<style>
</style>
