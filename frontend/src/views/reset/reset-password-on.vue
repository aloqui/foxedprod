<template>
  <div class="reset-password-on mt-5 pt-5">
    <div class="container">
      <div class="row">
        <div class="col d-flex flex-column content m-auto section-block ">
          <h1 class="font--bold">Reset Password</h1>
          <p class="mt-3 mb-2">New Password:</p>
          <form @submit.prevent="reset">
            <div class="form-group">

              <input class="form-control" type="password" v-model="resetData.password" placeholder="Password">
              <p class="help-block mb-2 mt-2" v-for="error in errorHandling.password">{{error}}</p>
              <input class="form-control mt-3" type="password" v-model="resetData.passwordConfirm" placeholder="Confirm Password">
              <p class="help-block mb-2 mt-2" v-for="error in errorHandling.passwordConfirm">{{error}}</p>
              <p class="help-block mb-2 mt-2">{{ backEndError.message }}</p>
            </div>
            <button class="btn mb-2 form__button--register-dark">
              Reset Password
              <div class="spinner p-1 d-flex align-items-center" v-if="loading">
                <i class="animate__spin fas fa-circle-notch m-auto"></i>
              </div>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        resetData: {},
        errorHandling: {},
        backEndError: {},
        loading: false
      }
    },
    mounted() {},
    methods: {
      reset() {
        this.loading = true;
        this.resetData.token = this.$route.query.token;
        this.backEndError = {};
        this.errorHandling = {};
        this.$http.post(`api/passwordReset`, this.resetData)
          .then(response => {
            this.loading = false;
            this.$router.push(`/`);
            swal(`Password reset successful!`, {
              icon: "success",
            });
          })
          .catch(response => {
            this.loading = false;
            if (response.body.errors)
              this.errorHandling = response.body.errors
            if (response.body.message)
              this.backEndError = response.body
          })
      }
    }
  }

</script>
