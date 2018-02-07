<template>
  <div class="mt-5 pt-5">
    <div class="container">
      <div class="row">
        <div class="col d-flex flex-column content m-auto section-block ">
          <h1 class="font--bold">Reset Password</h1>
          <p class="mt-3 mb-2">Please enter your email address.</p>
          <div class="form-group">
            <input class="form-control" type="text" v-model="resetData.email" placeholder="Email Address">
          </div>
          <button  class="btn mb-2 form__button--register-dark" @click="resetPassword">
            Reset Password
            <div class="spinner p-1 d-flex align-items-center" v-if="loading">
              <i class="animate__spin fas fa-circle-notch m-auto"></i>
            </div>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
          email: '',
          loading: false,
          resetData: {}
      }
    },
    methods: {
      resetPassword() {
        this.$http.post(`api/passwordReset/confirm`, this.resetData) 
          .then(response => {
            console.log(response)
          })
          .catch(response => {
            console.log(response)
          })
        
      }
    },
    mounted() {
      this.patch
    }
  }

</script>
