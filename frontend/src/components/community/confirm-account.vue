<template>
  <div class="confirm-account">
    <div class="confirm-account-block d-flex">
      <p>Please confirm your email address. </p>
      <form @submit.prevent="confirm">
        <input type="text" v-model="token.token">
        <button type="submit">Confirm</button>
      </form>
    </div>
  </div>
</template>
<script>
  export default {
    props: ['user'],
    data() {
      return {
        token: {}
      }
    },
    mounted() {},
    methods: {
      confirm() {
        this.$http.post('api/register/confirm', this.token)
          .then(function (response) {
            this.$router.push(`/community`);
            swal("Successfully confirmed your email!", {
              icon: "success",
            });
          })
          .catch(() => {
            // swal("Please contact the Administrator", {
            //   icon: "error",
            // });
          })
      }
      // fetch() {
      //     this.$http.get(`api/user`)
      //         .then(this.refresh())
      // },
      // refresh(data) {
      //     this.user = data.body
      //     console.log("account")
      //     console.log(this.user)
      // }
    }
  }

</script>
