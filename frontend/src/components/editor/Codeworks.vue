<template>
  <div class="row">
    <div class="col-lg-4 col-sm-6 code--holder" v-for="code in codes.codes">
      <div class="card h-100">
        <div class="holder">
          <section :id="'output'+code.id" class="spaceWrap">
            <iframe class="viewPort" @load="show(code)"></iframe>
            <div class="iframeBlocker"></div>
          </section>
        </div>

        <div class="card-body">
          <h4 class="card-title">
            <a href="#">{{ code.title }}</a>
          </h4>
          <p v-if="code.user_id == userMe.id">
            <!-- <a class="btn btn-danger" role="button" @click="$emit('delete-code')"> delete </a> -->
            <router-link class="btn" :to="'codes/' + code.id">edit</router-link>
          </p>
          <p v-else>
            <router-link class="btn" :to="'codes/' + code.id">view</router-link>
          </p>
        </div>
      </div>
    </div>

    <br>

    <!-- <div class="col-12">
          <div class="card" v-for="code in codes.images">
            <span v-if="code.image != 'none'">
                  <img :src="'http://localhost:3000/images/' + code.image"  @click="pass(code)" data-toggle="modal" data-target="#preview">
              </span>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">{{ code.title }}</a>
              </h4>
            </div>
          </div>
        </div> -->

    <div class="col-12 d-flex justify-content-center align-items-center">
      <section class="gallery">
        <div v-for="code in codes.images" :class="'item h0 v1'">
          <img :src="imagePath + code.image" @click="pass(code)" data-toggle="modal" data-target="#preview">
        </div>
      </section>
    </div>

    <div class="col-12">

      <div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{modal.title}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <span v-if="modal.image != 'none'">
                <img :src="imagePath + modal.image">
              </span>

            </div>
            <div class="modal-footer d-flex justify-content-center align-items-center">
              <div v-if="modal.user_id == userMe.id">
                <input type="file" accept="image/*" class="form-control  content__helper" @change="imageChanged">
                <div class="d-flex justify-content-center align-items-center">
                  <input v-model="modal.title" type="text" placeholder="title">
                  <button @click="update" class="btn content__button--passive content__helper">update</button>
                  <button @click="deleteimg" class="btn content__button--passive content__helper">Delete</button>
                </div>
              </div>
              <div v-else>
                <h1>{{modal.title}}</h1>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        codes: {},
        modal: {},
        newImage: '',
        oldImage: ''
      }
    },
    props: [
      'userMe'
    ],

    mounted() {
      this.fetch();
      this.getImagePath()

    },
    methods: {
      getImagePath() {
        this.imagePath = `${location.protocol}//${location.hostname}/images/`
        if (location.port)
          this.imagePath = `${location.protocol}//${location.hostname}:${location.port}/images/`
      },
      rand() {
        return Math.random();
      },
      show(c) {
        var base_tpl =
          "<!doctype html>\n" +
          "<html>\n\t" +
          "<head>\n\t\t" +
          "<meta charset=\"utf-8\">\n\t\t" +
          "<title>Test</title>\n\n\t\t\n\t" +
          "</head>\n\t" +
          "<body>\n\t\n\t" +
          "</body>\n" +
          "</html>";

        var prepareSource = function () {
          var src = '',
            js = '',
            css = '';

          src = base_tpl.replace('</body>', c.html + '</body>');

          css = '<style>' + c.css + '</style>';
          src = src.replace('</head>', css + '</head>');

          js = '<script>' + c.js + '<\/script>';
          src = src.replace('</body>', js + '</body>');

          return src;
        };

        var render = function () {
          var source = prepareSource();

          var iframe = document.querySelector(`#output${c.id} iframe`),
            iframe_doc = iframe.contentDocument;

          iframe_doc.open();
          iframe_doc.write(source);
          iframe_doc.close();
        };

        render();

      },
      fetch() {
        this.$http.get(`api/${this.$route.params.user}/codes`)
          .then(this.refresh)
      },
      refresh(data) {
        this.codes = data.body
      },
      pass(a) {
        this.modal = a;
        this.modal.oldImage = this.modal.image;

      },

      imageChanged(e) {
        console.log(e.target.files[0]);
        var fileReader = new FileReader();

        fileReader.readAsDataURL(e.target.files[0]);
        console.log(e.target.files[0])

        fileReader.onload = e => {
          this.modal.newImage = e.target.result;
        };

      },
      update() {
        if (!this.modal.activity_id) {
          this.modal.evaluated = false;
        }
        this.$http.put('api/imageport/update/' + this.modal.id, this.modal)
          .then(response => {
            console.log(response)
            swal("Succesfully Updated!", {
              icon: "success",
            });
            //   this.$router.push('/feed')
            location.reload()
          })
      },
      deleteimg() {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              this.$http.delete('api/imageport/' + this.modal.id)
                .then(response => {

                  swal("Poof! Your imaginary file has been deleted!", {
                    icon: "success",

                  });
                  location.reload()
                })

            } else {
              swal("Your imaginary file is safe!");
            }
          });
      },
    },
    computed: {
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
      }
    },
  }

</script>

<style lang="scss" scoped>
  .gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, 90px);
    grid-auto-rows: 100px;
    grid-auto-flow: dense;
    grid-gap: 5px;
  }

  .item {
    overflow: hidden;
    display: grid;
    grid-template-columns: 1;
    grid-template-rows: 1;
  }

  .item img {
    grid-column: 1 / -1;
    grid-row: 1 / -1;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .item.v0 {
    grid-row: span 3;
  }

  .item.v1 {
    grid-row: span 2;
  }

  .item.h0 {
    grid-column: span 3;
  }

  .item.h1 {
    grid-column: span 4;
  }


  .code-card {
    width: 100%;
    display: flex;

    .code-container {
      display: flex;
      width: 100%;
      justify-content: space-around;
    }
  }

  .code--holder {
    margin-top: 10px;
  }

  .card {
    flex: 1;
    width: 100%;
    img {
      max-width: 500px;
      max-height: 300px;
    }
    .card-body {
      padding: 5px 10px 0 10px;
      width: 100%;
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
      a {
        text-decoration: none;
        color: rgb(48, 48, 48);
        font-size: 14px;
        font-weight: bolder;
        text-transform: uppercase;
      }
      .btn {
        background: none;
        font-size: 10px;
      }
    }
  }

  img {
    width: 100%;
  }

  .holder {
    max-height: 300px;
    max-width: 500px;
  }

  .spaceWrap {
    width: 100%;
    height: 200px;
    padding: 0;
    overflow: hidden;
    position: relative; // display: flex;
    // flex-direction: column;
    // justify-content: center;
    // align-items: stretch;
    .iframeBlocker {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      transition: all .2s ease-out;
    }
    &:hover {
      .iframeBlocker {
        background-color: rgba(0, 0, 0, 0.535);
        border-bottom: solid 4px rgb(240, 201, 74)
      }
    }
    .viewPort {
      width: 1900px;
      height: 900px;
      border: 1px solid black;
      -webkit-transform: scale(0.25);
      -webkit-transform-origin: 0 0;
    }
  }

</style>
