<template>
  <div class="mt-5 pt-5">
    <div class="container">
      <div class="row">
        <div class="col d-flex flex-column">
          <h1 class="font--bold">Reset Password</h1>
          <p>Please enter your email address.</p>
          <div class="form-group">
            <input class="form-control" type="text" v-model="email" placeholder="Email Address">
          </div>
          <button class="btn btn-primary mt-2" type="submit">Submit</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
          email: ''
      }
    },
    methods: {
      patch() {
        this.$http.post()
          .then()
          .catch()
      }
    },
    mounted() {
      this.patch
    }
  }

</script>
