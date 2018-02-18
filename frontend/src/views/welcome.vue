<template>
  <div>
    <!-- <welcome-nav-list></welcome-nav-list> -->

    <div class="welcome">
      <div class="container-fluid">
        <div class="row justify-content-sm-center ">
          <div class="col-10">

            <div class="row ">
              <div class="block-full-height col-lg-12 m-auto text-center  d-flex flex-column justify-content-around align-items-center">
                <div class="content">
                  <h3 class="font--bold welcome__title pl-4 pr-4">It's time to ditch bad habits!</h3>
                  <p class="font--medium content__sub-title">There shouldn't be any chance for you to lose your work! FoxedFolio offers online storage on-the-go. <br><span class="content__helper">-FoxedFolio Dev. Team</span></p>
                  <div>
                    <!-- <button class="btn form__button--passive-dark">Discover</button> -->
                    <a href="#discover">
                      <button class="btn form__button--positive-dark mt-3">Discover
                      <span class="font--bold">Foxed</span>
                      <span class="font--light">Folio</span>
                    </button>
                      </a>
                  </div>
                </div>
                <div class="p-4 " mt-auto>
                  <a href="#register">

                  <p class="btn form__button--register" id="discover">Register Now</p>
                  </a>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>
    <div class="landing--info pt-5 pb-5" >
      <div class="container-fluid">
        <div class="row justify-content-sm-center">
          <div class="col-10">
            <div class="row mb-2 pb-2">
              <div class="col-lg-12 text-center">
                <h2 class="text-center font--semi-bold content m-auto forum__title">What's in it for you when you register?</h2>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 d-flex justify-content-around align-items-center cen pt-5 pb-5">
                <div class="column--first d-flex flex-column">
                  <div class="about--default d-flex section-block">
                    <img :src="imagePath + 'assets/CODE-EDITOR.png'" alt="">
                    <span class="d-flex flex-column">
                      <h4 class="mb-1">Code Editor!</h4>
                      <p class="content__helper">A realtime online editor that outputs your code in just milliseconds! </p>
                    </span>
                  </div>
                  <div class="about--default d-flex section-block">
                    <img :src="imagePath + 'assets/DEDICATED.png'" alt="">
                    <span class="d-flex flex-column">
                      <h4 class="mb-1">Hands-On!</h4>
                      <p class="content__helper">Write discussions to help your co-developers to improve not only <br/> their skill, but their knowledge!</p>
                    </span>
                  </div>
                </div>


                <div class="column--second d-flex flex-column">
                  <div class="about--default d-flex section-block">
                    <img :src="imagePath + 'assets/EXPERT-PROFESSIONAL.png'" alt="">
                    <span class="d-flex flex-column ">
                      <h4 class="mb-1">Professional Environment!</h4>
                      <p class="content__helper">We promote and empower individuals to be professioal<br/>around the community we're building!</p>
                    </span>
                  </div>
                  <div class="about--default d-flex section-block">
                    <img :src="imagePath + 'assets/USER-FRIENDLY.png'" alt="">
                    <span class="d-flex flex-column  pr-5">
                      <h4 class="mb-1">Real-time!</h4>
                      <p class="content__helper">We know how badly you hate refreshing pages..</p>
                    </span>
                  </div>
                </div>
              </div>
                <p class="hover-pointer text-center content__helper m-auto" id="register"><u>And a lot more!</u></p>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="registration pt-5 pb-5" >
      <div class="container-fluid">
        <div class="row justify-content-sm-center">
          <div class="col-10">
            <div class="row">
              <div class="col-lg-12 block-full-height d-flex flex-column justify-content-around align-items-center">
                <div class="content text-center">
                  <h2 class="text-center font--bold pl-4 pr-4">We'll help you learn and collaborate!</h2>
                  <p class="content__sub-title font--medium">With other developers in the community. Come join along!</p>
                </div>
                <div class="content text-center">
                  <register></register>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  // import welcomeNavigation from '../components/welcome-navigation.vue'

  import Register from '../components/authentication/Register.vue';
  export default {
    date() {
      imagePath: ''
    },
    created() {
      this.getImagePath()
    },
    methods: {
      getImagePath() {
        this.imagePath = `${location.protocol}//${location.hostname}/images/`
        if (location.port)
          this.imagePath = `${location.protocol}//${location.hostname}:${location.port}/images/`
      }
    },
    components: {
      // 'welcome-nav-list': welcomeNavigation
      'register': Register
    },

  sockets: {
        connection() {
            console.log('socket connected')
            console.log('socket connected')
            console.log('socket connected')
            console.log('socket connected')
            console.log('socket connected')
        }
    },
  }

</script>

<style lang="scss" scoped>
  form input {
    width: 100%;
  }

  .about--default {
    margin: 8px;
    padding: 5px; // background: rgb(255, 255, 255);
    border-radius: 3px;
    span {
      justify-content: center;
      padding-left: 12px;
    }
    img {
      width: 200px;
      height: 150px;
      margin-right: 5px;
      transform: scale(0.8)
    }
    h4 {
      font-size: 15px;
      font-weight: 900;
    }
    p {
      font-size: 13px;
    }
  }

  @media (max-width: 766px) {
    .cen {
      flex-direction: column;
    }
  }

</style>
