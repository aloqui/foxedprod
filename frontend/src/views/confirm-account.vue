<template>
  <div>
    <h1>Thank you!</h1>
  </div>
</template>
<script>
  export default {
    data() {
      return {
          token: this.$route.query.token
      }
    },
    methods: {
      fetch() {
        this.$http.post(`api${this.$route.path}?token=${this.token}`, this.token)
        .then(function(response) {
            this.$router.push(`/community`);
            
            swal("Account Confirmed!", {
            icon: "success",
          });
        })
        .catch(() => {
          alert("error");
        })
      }
    },
    created() {
      alert(this.$route.query.token + this.$route.path);
      this.fetch();
      
    },
    computed: {
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
      }
    },
  }

</script>
