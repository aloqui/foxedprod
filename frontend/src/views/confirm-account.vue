<template>
  <div class="mt-5 ">
    <div class="d-flex flex-column align-items-center block-half-height">
      <div class="m-auto">
        <h3 class="font--light text-center">Confirming your Email address..</h3>
        <h3 class="font--light text-center mt-3">You will be redirected automatically.</h3>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        token: {token: this.$route.query.token}
      }
    },
    methods: {
      fetch() {
        this.$http.post(`api${this.$route.path}`, this.token)
          .then(function (response) {
            this.$router.push(`/community`);
            swal(`Hoorray! Email is confirmed!`, {
              icon: "success",
            });
          })
          .catch(() => {
            this.$router.push(`/community`);
            swal("Please contact the Administrator", {
              icon: "error",
            });
          })
      }
    },
    mounted() {
      this.fetch();
    },
    computed: {
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
      }
    },
  }

</script>
