<template>
  <div class="mt-5 pt-5">
    <div class="container">
      <div class="row ">
        <div class="col section-block">
          <form>
            <h1 class="font--semi-bold">EDIT PROFILE</h1>
            <hr>
            <div class="row">
              <div class="col">
                <p class="content__helper">@{{ basicInfo.username }}</p>
                <p class="content__helper">Your Email is
                  <span class="content__helper--negative text-uppercase font--bold" v-show="!basicInfo.confirmed">not</span> confirmed.</p>
                <p class="content__helper content__helper--positive" v-show="newEmail">A mail has been sent to your Email address.</p>
                <p class="content__helper content__helper--positive" v-show="notif"> {{notif}}</p>
                <p class="content__helper content__helper--negative" v-show="negativeNotif"> {{negativeNotif}}</p>
                <div class="d-flex flex-column align-items-start">
                  <p class="content__helper mt-2">Change Password</p>
                  <div class="d-flex">
                    <div>
                      <p class="help-block" v-for="error in errorHandling.old_password">{{error}}</p>
                      <p class="content__helper mt-2" v-if="!errorHandling.old_password">Old Password</p>
                      <input class="form-control " type="password" v-model="changePasswordData.old_password" placeholder="Old Password" />
                    </div>
                  </div>
                  <div class="d-flex mt-2">
                    <div>
                      <p class="help-block" v-for="error in errorHandling.password">{{error}}</p>
                      <p class="content__helper mt-2" v-if="!errorHandling.password">New Password</p>
                      <input class="form-control mr-1" type="password" v-model="changePasswordData.password" placeholder="New Password" />
                    </div>
                    <div>
                      <p class="help-block" v-for="error in errorHandling.confirm_password">{{error}}</p>
                      <p class="content__helper mt-2" v-if="!errorHandling.confirm_password">Confirm New Password</p>
                      <input class="form-control ml-1" type="password" v-model="changePasswordData.confirm_password" placeholder="Confirm New Password"
                      />
                    </div>
                  </div>
                  <div class="d-flex mt-2">
                    <button class="btn content__button--passive content__helper" @click.prevent="changePassword">Change Password</button>
                  </div>
                </div>
                <div class="d-flex flex-column align-items-start">

                  <p class="content__helper mt-4">Change Basic Information</p>
                  <div class="d-flex mt-2">
                    <div class=" m r-1">
                      <p class="help-block" v-for="error in errorHandling.name">{{error}}</p>
                      <p class="content__helper" v-if="!errorHandling.name">Full Name</p>
                      <input class="form-control" type="text" placeholder="Full Name" v-model="basicInfo.name" />
                    </div>
                    <div class=" ml-1">
                      <p class="help-block" v-for="error in errorHandling.email">{{error}}</p>
                      <p class="content__helper" v-if="!errorHandling.email">Email Address</p>
                      <input class="form-control" type="email" placeholder="Email Address" v-model="basicInfo.email" />
                    </div>
                  </div>
                  <div class="mt-2">
                    <p class="help-block" v-for="error in errorHandling.username">{{error}}</p>
                    <p class="content__helper" v-if="!errorHandling.username">Username</p>
                    <input class="form-control" type="text" placeholder="Username" v-model="basicInfo.username" />
                  </div>
                  <div class="d-flex mt-2">
                    <button class="btn content__button--passive content__helper" @click="updateBasicProfile">Update Profile</button>
                  </div>
                </div>

              </div>
              <div class="col">

              </div>
            </div>
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
        basicInfo: {},
        changePasswordData: {},
        errorHandling: {},
        newEmail: false,
        notif: null,
        negativeNotif: null
      }
    },
    mounted() {
      this.fetchAuth()

    },
    methods: {
      fetchAuth() {
        this.$http.get(`api/user/profile/`)
          .then(this.refreshAuth)
      },
      refreshAuth(data) {
        console.log(data)
        // this.Auth = data.body
        // this.basicInfo.name = data.body.user.name
        // this.basicInfo.username = data.body.user.username
        this.basicInfo = data.body.user
        this.basicInfo.email = data.body.email
      },
      postLanguages() {
        console.log("Language request")
      },
      postTechnicalSkills() {
        console.log("Technical Skills request")
      },
      postUserDetails() {
        console.log("User Details request")
      },
      changePassword() {
        this.notif = null
        this.negativeNotif = null
        this.errorHandling = {}
        this.$http.post(`api/user/change-password`, this.changePasswordData)
          .then(response => {
            this.notif = response.body.response
          })
          .catch(response => {
            this.errorHandling = response.body.errors
            this.negativeNotif = response.body.response

          })
      },
      updateBasicProfile() {
        this.errorHandling = {}
        this.$http.post(`api/user/profile/basic`, this.basicInfo)
          .then(response => {
            swal(`Successfully updated your profile!`, {
              icon: "success",
            });
            if (response.body.new_email) {
              this.newEmail = true
              this.basicInfo.confirmed = false
            }
          })
          .catch(response => {
            this.errorHandling = response.body.errors
          })
      }
    }
  }

</script>
