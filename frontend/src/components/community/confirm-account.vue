<template>
  <div class="confirm-account">
    <div class="confirm-account-block d-flex justify-content-between align-items-center">
      <p class="font--semi-bold">Please confirm your email address.</p> 
      <p class="btn mr-auto ml-1 hover-pointer text-underline" @click="resendCode"><u>Resend Code</u></p>
      <form class="d-flex" @submit.prevent="confirm">
        <input class="form-control content__button--passive mr-2" type="text" v-model="token.token" placeholder="Code">
        <button class="btn content__helper content__button--passive" type="submit">Confirm</button>
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
      resendCode() {
        this.$http.post('api/user/email/resend-code')
            .then(response => {
              swal("A mail has been sent to your Email!", {
                icon: "success",
              });
            })
            .catch(response => {
              
            })
            
      },
      confirm() {
        if (this.token.token.length > 0) {
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
