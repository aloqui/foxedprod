<template>
  <div class="mt-5 pt-5">
    <div class="container">
      <div class="row ">
        <div class="col-12 mb-4" v-if="!basicInfo.confirmed">
          <confirm-account :user="basicInfo"></confirm-account>
        </div>
        <div class="col section-block">
          <form>
            <h1 class="font--semi-bold">EDIT PROFILE</h1>
            <hr>
            <div class="row">
              <div class="col">
                <div>
                  <p class="content__helper">@{{ basicInfo.username }}</p>
                  <p class="content__helper">Your Email is
                    <span class="content__helper--negative text-uppercase font--bold" v-show="!basicInfo.confirmed">not</span> confirmed.</p>
                  <p class="content__helper content__helper--positive" v-show="newEmail">A mail has been sent to your Email address.</p>
                  <p class="content__helper content__helper--positive" v-show="notif"> {{notif}}</p>
                  <p class="content__helper content__helper--negative" v-show="negativeNotif"> {{negativeNotif}}</p>
                </div>
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
                <form>
                  <p class="content__helper mb-2">Change Your Information</p>
                  <div class="d-flex flex-column align-items-start form-group">
                    <p class="help-block" v-for="error in errorHandling.bio">{{error}}</p>
                    <p class="content__helper" v-if="!errorHandling.bio">Bio</p>
                    <textarea class="form-control mt-2 mb-2" name="bio" cols="30" rows="5" placeholder="Say something about yourself!"
                      v-model="userInfo.bio"></textarea>
                    <span class="content__helper">{{charactersLeft}} characters left</span>

                    <p class="help-block" v-for="error in errorHandling.phone_number">{{error}}</p>
                    <p class="content__helper" v-if="!errorHandling.phone_number">Contact Number</p>
                    <input class="form-control mb-2" type="text" v-model="userInfo.phone_number" placeholder="+63 9** **** ***" />

                    <p class="help-block" v-for="error in errorHandling.birth_date">{{error}}</p>
                    <p class="content__helper" v-if="!errorHandling.birth_date">Birth Date</p>
                    <input class="form-control mb-2" type="date" v-model="userInfo.birth_date">
                    <p class="content__helper mb-2">Education</p>

                    <p class="help-block" v-for="error in errorHandling.primary_education">{{error}}</p>
                    <p class="content__helper" v-if="!errorHandling.primary_education">Primary Education</p>
                    <input class="form-control mb-2" type="text" v-model="userInfo.primary_education" placeholder="Primary Education" />

                    <p class="help-block" v-for="error in errorHandling.secondary_education">{{error}}</p>
                    <p class="content__helper" v-if="!errorHandling.secondary_education">Secondary Education</p>
                    <input class="form-control mb-2" type="text" v-model="userInfo.secondary_education" placeholder="Secondary Education" />

                    <p class="help-block" v-for="error in errorHandling.tertiary_education">{{error}}</p>
                    <p class="content__helper" v-if="!errorHandling.tertiary_education">Tertiary Education</p>
                    <input class="form-control mb-2" type="text" v-model="userInfo.tertiary_education" placeholder="Tertiary Education" />

                    <button class="btn content__button--passive content__helper" @click="updateUserInfo">Update Information</button>
                  </div>
                </form>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import ConfirmAccount from '../../components/community/confirm-account.vue';
  export default {
    components: {
      'confirm-account': ConfirmAccount
    },
    data() {
      return {
        basicInfo: {},
        userInfo: {},
        changePasswordData: {},
        errorHandling: {},
        newEmail: false,
        notif: null,
        negativeNotif: null
      }
    },
    computed: {
      charactersLeft() {
        let left = 280 - this.userInfo.bio.length;
        return left;
      }
    },
    mounted() {
      this.fetchBasicInfo()

    },
    methods: {
      fetchBasicInfo() {
        this.$http.get(`api/user/profile/basic-info`)
          .then(this.refreshBasicInfo)
      },
      fetchUserDetails() {
        this.$http.get(`api/user/profile/user-info`)
          .then(this.refreshUserDetails)
      },
      refreshBasicInfo(data) {
        console.log(data)
        // this.Auth = data.body
        // this.basicInfo.name = data.body.user.name
        // this.basicInfo.username = data.body.user.username
        this.basicInfo = data.body.user
        this.basicInfo.email = data.body.email
        this.userInfo = data.body.user.details
        console.log(this.userInfo)
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
      updateUserInfo() {
        this.errorHandling = {}
        this.$http.post(`api/user/profile/update-user-info`, this.userInfo)
          .then(response => {
            swal(`Successfully updated your profile!`, {
              icon: "success",
            });
          })
          .catch(response => {

            this.errorHandling = response.body.errors
          })
      },
      updateBasicProfile() {
        this.errorHandling = {}
        this.$http.post(`api/user/profile/update-basic-info`, this.basicInfo)
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
