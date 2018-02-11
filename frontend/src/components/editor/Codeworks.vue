<template>
  <div>

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
        <!-- <div class="col-12 d-flex justify-content-center align-items-center">
        <section class="gallery"> 
            <div v-for="code in codes.images" :class="'item h0 v1'">
          <img :src="imagePath + code.image" @click="pass(code)" data-toggle="modal" data-target="#preview">
        </div>
            <div id="forPdf" v-for="code in codes.images"  :class="'item h0 v1'" style="display:none;">
              <img :src="imagePath + code.image" @click="pass(code)" data-toggle="modal" data-target="#preview">
            </div> 
        </section>
        </div>  -->
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
                  <input v-model="modal.title" class="input--default" type="text" placeholder="title">
                  <button @click="update" class="btn content__button--passive content__helper">Update</button>
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
  <!-- class="col-lg-4 col-sm-6 p-0 " -->
  <div class="row mt-3">
    <div class="col-12 width--gallery">
     <div class="flexbox">
      <div class="item" v-for="code in codes.images">
        <span class="">
            <img  class=" " @click="pass(code)" :src="imagePath + code.image" data-toggle="modal" data-target="#preview">
            <p class="title">{{code.title}}</p>
        </span>
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
        oldImage: '',
        imagePath:''
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
      tryPrint(){
        html2canvas(document.querySelector('#forPdf'),{
          onrendered: function (canvas) {

            var img = canvas.toDataURL("image/png");
            var doc = new jsPDF()
            doc.addImage(img,'JPEG',20,20);

              doc.save('resume.pdf');
          }
        });
      },
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
            }).then((value) => {
                        location.reload()
                      });
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
  .width--gallery{
    width: 50vw;
    overflow-x: scroll;
  }
  .flexbox{
  display: -webkit-flex;
  display: flex;
  -webkit-flex-direction: column;
  flex-direction: column;
  -webkit-flex-wrap: wrap;
  flex-wrap: wrap;
  width: 100%;
  height: 100vh;
  
  &:hover{
    img {
      opacity:0.28;
    }
  }

  // Each flex item
  .item{
    position: relative;
    width: 33.33%;  // 3 column 
    img{
      width: 100%;
      display: block;
      transition:all .8s;
    }
    .title{
      position:absolute;
      top:48%;
      left:0;
      width:100%;
      padding:0 3%;
      font-size:30px;
      text-shadow:0 0 8px rgba(0,0,0,0.42);
      color:rgb(221, 221, 221);
    }
    &:hover{
      img{
        opacity:1;
        
      }
    }
  }
}

// Mediaqueries
@media ( max-width : 860px ){
  // set to 2 column
  .flexbox{
    height:220vw;
    .item{
      width:50%;
    }
  }
}
@media ( max-width : 667px ){
  // set to 1 column
  .flexbox{
    height:auto;
    .item{
      width:100%;
    }
  }
}

</style>
