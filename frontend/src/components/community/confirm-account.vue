<template>
  <div class="confirm-account">
      <div class="confirm-account-block">
          <p>Please confirm your email address. </p>
      </div>
  </div>
</template>
<script>
    export default {
        props: ['user'],
        data() {
            return {
               
            }
        },
        mounted() {
        },
        methods: {
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