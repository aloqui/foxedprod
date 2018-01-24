<template>
  <div class="home">
    <nav-list></nav-list>
    <div class="container-fluid">
      <div class="row d-flex justify-content-sm-center">
        <div class="col-xl-8 col-md-10">
          <div class="row">
            <div class="col-12 d-flex justify-content-center ">
              <img class="picture m-5" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" alt="">
asd <code-works></code-works>
            </div>
            <div class="col-12 d-flex justify-content-center mb-5">
              <i class="fa fa-print" aria-hidden="true"></i>
              <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
              <img src="https://news.siteintelgroup.com/blog/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="">
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
              <img src="https://news.siteintelgroup.com/blog/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="">
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
              <img src="https://news.siteintelgroup.com/blog/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="">
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
              <img src="https://news.siteintelgroup.com/blog/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="">
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
              <img src="https://news.siteintelgroup.com/blog/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="">
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
              <img src="https://news.siteintelgroup.com/blog/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="">
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
              <img src="https://news.siteintelgroup.com/blog/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="">
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
              <img src="https://news.siteintelgroup.com/blog/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="">
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
              <img src="https://news.siteintelgroup.com/blog/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="">
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
              <img src="https://news.siteintelgroup.com/blog/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="">
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
              <img src="https://news.siteintelgroup.com/blog/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="">
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
              <img src="https://news.siteintelgroup.com/blog/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="">
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</template>

<script>
  import Navigation from '../components/navigation.vue';
  import Works from '../components/editor/Codeworks.vue';
  export default {
    data() {
      return {
        items: [{
            title: 'AN401'
          },
          {
            title: 'ANIMPORT'
          },
          {
            title: 'WEBFOLIO'
          }
        ]
      }
    },
    components: {
      'nav-list': Navigation,
      'code-works': Works
    }
  }
</script>

<style scoped lang="scss">
  form input {
    width: 100%;
  }

  .green {
    background-color: green;
  }

  img {
    width: 100%;
  }

  .picture {
    background-color: #efefef;
    width: 200px;
    height: 200px;
    border-radius: 50%;
  }
  i {
    margin: 0 10px;
    font-size: 24px;
    color: #a2a2a2;
  }
  ul {
    list-style: none;
    padding: 0;
    li {
      margin: 0;
    }
  }
</style>