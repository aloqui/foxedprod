<template>
  <nav class="navbar navbar__logged-in fixed-top navbar-toggleable-md navbar-light bg-faded">
    <div class="container d-flex align-items-center justify-items-center mt-2 mb-2">
      <!-- <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button> -->
      <a class="navbar-brand" href="/#/">
        <span class="font--bold">Foxed</span>
        <span class="font--light">Folio</span>
      </a>
      <login v-if="! isAuth"></login>
      <div class="form-group mt-auto mb-auto " v-if="isAuth">
        <div class="algolia-search">
          <div class="dropdown ">
            <ais-index app-id="TN5MR9QHP4" api-key="a933713f38f230be88643278a41c7281" index-name="threads">
              <ais-search-box id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <ais-input class="form-control" placeholder="Search for threads..." autofocus></ais-input>
              </ais-search-box>
              <div class="dropdown-menu box-shadow p-2" aria-labelledby="dropdownMenuButton">
                <ais-results class="">
                  <div class="ais-results__header p-2" slot="header">
                    <p class="font--bold text-uppercase">Threads searched:</p>
                  </div>
                  <template slot-scope="{ result }">
                    <router-link :to="result.path">
                      <li class="p-2 d-flex ">
                        <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                        <p class="content__helper ml-auto align-self-center">@{{result.channel.slug}}</p>
                      </li>
                    </router-link>
                  </template>
                </ais-results>
                <ais-no-results></ais-no-results>
              </div>
            </ais-index>
          </div>
        </div>
      </div>
      <div class="d-flex align-items-center justify-content-center nav-links" v-if="isAuth">
        <router-link class="ml-2 mr-2" tag="li" to="/">
          <a>Home</a>
        </router-link>
        <router-link class="ml-2 mr-2" tag="li" to="/community">
          <a>Community</a>
        </router-link>
        <user-notifications :user="user"></user-notifications>
        <li>
          <div class="dropdown ml-1 d-flex flex-column align-items-end justify-content-end">
            <div class="btn d-flex align-items-center" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="round-block mr-2 ">
                <img class="picture" :src="user.avatar_path" alt="" id="picture">
              </div>
            </div>
            <ul class="dropdown-menu font--light  mr-auto" aria-labelledby="dropdownMenuButton">
              <router-link class="" :to="'/'+user.username+'/codes'">
                <li class="p-2">
                  <p class="font--bold" v-text="user.name"></p>
                  <p class="content__helper font--light">@{{user.username}}</p>
                </li>
              </router-link>
              <div class="dropdown-divider"></div>
              <router-link class="" :to="'/'+user.username+'/codes'">
                <li class="p-2">
                  <p>Profile</p>
                </li>
              </router-link>
              <router-link class="" :to="'/'+user.username+'/threads'">
                <li class="p-2">
                  <p>My Threads</p>
                </li>
              </router-link>
              <div class="dropdown-divider"></div>
              <router-link class="" :to="'/account'">
                <li class="p-2">
                  <p>Settings</p>
                </li>
              </router-link>
              <li class="p-2" @click="logout">
                <p class="" href="#">Logout</p>
              </li>
            </ul>
          </div>
        </li>
      </div>
    </div>
  </nav>
</template>

<script>
  import Login from './authentication/Login.vue';
  import PictureMixin from '../mixins/pictureMixin.js';
  import UserNotifications from './community/UserNotifications.vue'
  export default {
    components: {
      'login': Login,
      'user-notifications': UserNotifications
    },
    mixins: [PictureMixin],
    data() {
      return {
        isAuth: null,
        user: {},
        query: ''
      }
    },
    // computed: {
    //     authenticatedUser() {
    //     return this.$auth.getAuthenticatedUser()
    //     }
    // },
    mounted() {
      this.isAuth = this.$auth.isAuthenticated()
      this.setAuthenticatedUser()
      this.fixPicture()
    },
    watch: {
      $route: function () {
        this.isAuth = this.$auth.isAuthenticated()
        if (this.isAuth) {
          this.setAuthenticatedUser()
        }
      }
    },
    methods: {
      setAuthenticatedUser() {
        this.$http.get('api/user')
          .then(this.refresh)
      },
      search() {
        this.$router.replace(`/threads/search?q=${this.query}`)
        this.$emit('searched', this.query);
      },
      refresh(data) {
        this.$auth.setAuthenticatedUser(data.body)
        this.user = data.body
        console.log(this.$auth.getAuthenticatedUser())
      },
      logout() {
        this.$auth.destroyToken()
        this.$router.push("/")
        location.reload()
      }

    }
  }

</script>

<style scope lang="scss">
  .navbar {
    color: #fcfcfc;
    width: 100%;
    .navlinks {
      color: #fff;
    }
    .navbar-brand {
      color: #fcfcfc;
      &:hover {
        color: #fcfcfc;
        &>.font--bold {
          color: darken(#e76814, 4%);
        }
      }
    }
  }

  .navbar__logged-in {
    background-color: lighten(#000, 8%);
  }

  .router-link-active {
    color: red;
  }

</style>
