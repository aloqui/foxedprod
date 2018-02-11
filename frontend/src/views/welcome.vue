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
    <div class="landing--info pt-3 pb-5">
      <div class="container-fluid">
        <div class="row justify-content-sm-center">
          <div class="col-10">
            <div class="row mb-2 pb-2">
              <div class="col-lg-12 text-center">
                      <h2 class="text-center font--bold pl-4 pr-4"> Register now and try our services!</h2>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 d-flex justify-content-around align-items-center cen">
                <div class="column--first d-flex flex-column">
                    <div class="about--default d-flex">
                    <img :src="imagePath + 'assets/code-editor.png'" alt="">
                    <span class="d-flex flex-column">
                      <h4>Code Editor</h4>
                      <p>A realtime online editor that outputs your code in just milliseconds! </p>
                    </span>
                  </div>
                  <div class="about--default d-flex">
                    <img :src="imagePath + 'assets/dedicated.png'" alt="">
                    <span class="d-flex flex-column">
                      <h4>Dedicated</h4>
                      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. </p>
                    </span>
                  </div>
                </div>
                

                <div class="column--second d-flex flex-column">
                  <div class="about--default d-flex">
                    <img :src="imagePath + 'assets/expert-professional.png'" alt="">
                    <span class="d-flex flex-column">
                      <h4>Expert Professional</h4>
                      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. </p>
                    </span>
                  </div>
                  <div class="about--default d-flex">
                    <img :src="imagePath + 'assets/responsive.png'" alt="">
                    <span class="d-flex flex-column">
                      <h4>Responsive</h4>
                      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. </p>
                    </span>
                  </div>
                </div>
              </div> 
            </div>
            <div class="row">
              <div class="col-lg-12 d-flex align-items-center justify-content-center">
                  <div class="about--default d-flex align-items-center justify-content-center">
                    <img :src="imagePath + 'assets/user-friendly.png'" alt="">
                    <span class="d-flex flex-column pr-5"> 
                      <h4>User Friendly</h4>
                      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. </p>
                    </span>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="registration pt-3 pb-3">
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
    date (){
      imagePath:''
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
    

  }

</script>

<style lang="scss" scoped>
  form input {
    width: 100%;
  }
.about--default{
  margin: 8px;
  padding: 5px;  
  background: rgb(255, 255, 255);
  border-radius: 3px;
  span{
    justify-content: center;
    padding-left:12px;
  }
  img{
    width: 200px;
    height: 150px;
    margin-right: 5px;
    transform: scale(0.8)
  }
  h4{
    font-size:15px;
    font-weight: 900;
  }
  p{
    font-size: 13px;
  } 
}

@media (max-width: 766px) {
    .cen{
      flex-direction: column;
    }
 }
</style>
