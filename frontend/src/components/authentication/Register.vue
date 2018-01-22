<template>

  <div class="">

    <div class="card pl-5 pr-5 pt-3 pb-3">
      <div class="card-body">
        <h5 class="text-center mt-2 mb-4 font--bold content__title">Create an account</h5>
        <div class="form-group" :class="{'has-error': theErrors.name }">
          <input v-model="user.name" class="form-control content__input--dark" type="text" placeholder="Full Name">
          <p class="help-block" v-for="error in theErrors.name"> {{error}}</p>
        </div>
        <div class="form-group" :class="{'has-error': theErrors.username }">
          <input v-model="user.username" class="form-control content__input--dark" type="text" placeholder="Username">
          <p class="help-block" v-for="error in theErrors.username"> {{error}}</p>
        </div>
        <div class="form-group" :class="{'has-error': theErrors.email }">
          <input v-model="user.email" class="form-control content__input--dark" type="email" placeholder="Email">
          <p class="help-block" v-for="error in theErrors.email"> {{error}}</p>
        </div>
        <div class="form-group" :class="{'has-error': theErrors.password }">
          <input v-model="user.password" class="form-control content__input--dark" type="password" placeholder="Password">
          <p class="help-block" v-for="error in theErrors.password"> {{error}}</p>
        </div>
        <div class="form-group" :class="{'has-error': theErrors.password_confirmation }">
          <input v-model="user.password_confirmation" class="form-control content__input--dark" type="password" placeholder="Confirm Password">
          <p class="help-block" v-for="error in theErrors.password_confirmation"> {{error}}</p>
        </div>
        <div class="form-group mr-0 text-left">
          <select v-model="user.prof">
            <option value="0" default>Student</option>
            <option value="1">Professor</option>
          </select>
        </div>
        <button @click="register()" class="btn mb-2 form__button--register-dark">
          Register
          <div class="spinner p-1 d-flex align-items-center" v-if="loading">
              <i class="animate__spin fas fa-circle-notch m-auto"></i>
          </div>
        </button>
      </div>
    </div>
  </div>

</template>

<script>
  import swal from 'sweetalert'
  export default {
    data() {
      return {
        loading: null,
        user: {
          name: null,
          email: null,
          password: null,
          username: null,
          password_confirmation: null,
          prof: '0'
        },
        theErrors: {
          name: [],
          email: [],
          username: [],
          password: [],
          password_confirmation: [],
          prof: []
        },
        email: '',
        password: ''
      }
    },
    methods: {
      removeSpace() {
        if (this.user.username) {
          this.user.username = this.user.username.replace(/\s+/g, '');
        }
      },
      register() {

        this.loading = true;
        console.log(this.loading)
        this.removeSpace();
        this.$http.post('api/register/', this.user)
          .then(response => {
            this.login();
            this.loading = false;
            console.log(this.loading)
            // swal("Succesfully Registered!", {
            //   icon: "success",
            // });
          })
          .catch(error => {
            this.loading = false;
            console.log(this.loading)
            let data = error.body.errors
            console.log("data", data)
            for (let key in this.theErrors) {
              this.theErrors[key] = []
              let errMsg = data[key]
              if (errMsg) {
                this.theErrors[key] = errMsg
              }
            }
          })
      },
      login(user) {
        var data = {
          username: this.user.email,
          password: this.user.password
        }
        this.$http.post("api/auth/login", data)
          .then(response => {
            this.$auth.setToken(response.body.access_token, response.body.expires_in + Date.now())
            location.reload()            
            this.$router.push("/")

            console.log(response)
          })
      },
    }
  }

</script>

<style scoped lang="scss">
  select {
    color: #555555;
    border-radius: 8px;
    padding: 10px 25px;
    font-size: 18px;
    option {}
  }

  .fas,
  i {
    color: black !important;
  }

</style>
