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
                  <h3 class="font--bold welcome__title pl-4 pr-4">It's time to ditch local storage!</h3>
                  <p class="font--medium content__sub-title">There shouldn't be a chance to lose your work! Foxed Folio offers online storage on-the-go.</p>
                  <div>
                    <!-- <button class="btn form__button--passive-dark">Discover</button> -->
                    <button class="btn form__button--positive-dark">Discover
                      <span class="font--bold">Foxed</span>
                      <span class="font--light">Folio</span>
                    </button>
                  </div>
                </div>
                <div class="p-4 " mt-auto>
                  <p class="btn form__button--register">Register Now</p>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>
    <div class="registration">
      <div class="container-fluid">
        <div class="row justify-content-sm-center">
          <div class="col-10">
            <div class="row">
              <div class="col-lg-12 block-full-height d-flex flex-column justify-content-around align-items-center">
                <div class="content text-center">
                  <h2 class="text-center font--bold pl-4 pr-4">We help you learn and collaborate!</h2>
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
    components: {
      // 'welcome-nav-list': welcomeNavigation
      'register': Register
    }

  }

</script>

<style scoped>
  form input {
    width: 100%;
  }

</style>
