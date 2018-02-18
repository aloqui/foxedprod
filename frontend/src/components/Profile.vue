<template>
  <div class="home pt-4" id="printx">
    <div class="container">
      <div class="row section-block">
        <div class="col">
          <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-start">
              <avatarForm :user="user" :userInfo="userInfo"></avatarForm>
            </div>
            <div class="">
              <div class="mb-2 d-flex flex-column" v-if="user.id === userMe.id">
                <p class="content__helper">Actions</p>
                <div class="d-flex justify-content-start align-items-center">
                  <router-link class="btn content__button--passive content__helper mr-1" :to="'/editor'">New Foxed Code</router-link>
                  <!-- <router-link class="btn btn-default" :to="'/settings'">settings</router-link> -->
                  <button type="button" class="btn content__button--passive content__helper ml-1" data-toggle="modal" data-target="#imageport">
                    Upload Image
                  </button>
                </div>
                <!-- <i class="fa fa-print" aria-hidden="true"></i>
            <i class="fa fa-file-pdf-o" aria-hidden="true"></i> -->
              </div>
            </div>
          </div>
          <div class="col">
            <code-works :userMe="userMe"></code-works>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="imageport" tabindex="-1" role="dialog" aria-labelledby="imageportLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content section-block">
          <div class="modal-header">
            <h5 class="modal-title font--semi-bold" id="imageportLabel">Upload Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <img :src="image" />
            <div class="d-flex flex-column justify-content-center align-items-center">
            </div>
            <div class="d-flex flex-column justify-content-center mt-2">
              <input v-model="imageport.title" type="text" class="mb-2 section-block" placeholder="Image Title">
            </div>
            <p class="content__helper mt-2">Choose image</p>
            <input type="file" accept="image/*" class="form-control section-block content__helper file__remove mt-2 " @change="imageChanged">

            <button @click="submitImage" class="btn content__button--passive content__helper mt-2 ">Upload Image</button>
          </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="onChange">Save changes</button>
          </div> -->
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  import Works from '../components/editor/Codeworks.vue';
  import avatarForm from './community/avatarForm.vue';

  export default {
    components: {
      'code-works': Works,
      'avatarForm': avatarForm
    },
    data() {
      return {
        // profile: {},
        user: {},
        imageport: {},
        image: "",
        userMe: '',
        userInfo: {}
      }
    },
    computed: {
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
      }
    },
    mounted() {
      this.fetch()
      this.fetchDetails()
    },
    methods: {
      fetch() {
        this.$http.get(`api/${this.$route.params.user}/user`)
          .then(this.refresh);
      },
      fetchDetails() {
        this.$http.get(`api/${this.$route.params.user}/profile/info`)
          .then(this.refreshDetails)
      },
      refreshDetails(data) {
        this.userInfo = data.body
      },

      PDFAct() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        // source can be HTML-formatted string, or a reference
        // to an actual DOM element from which the text will be scraped.
        var source = $('#toPDFS')[0];

        // we support special element handlers. Register them with jQuery-style 
        // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
        // There is no support for any other type of selectors 
        // (class, of compound) at this time.
        var specialElementHandlers = {
          // element with id of "bypass" - jQuery style selector
          '#bypassme': function (element, renderer) {
            // true = "handled elsewhere, bypass text extraction"
            return true
          }
        };
        var margins = {
          top: 80,
          bottom: 60,
          left: 40,
          width: 522
        };
        // all coords and widths are in jsPDF instance's declared units
        // 'inches' in this case
        pdf.fromHTML(
          source, // HTML string or DOM elem ref.
          margins.left, // x coord
          margins.top, { // y coord
            'width': margins.width, // max width of content on PDF
            'elementHandlers': specialElementHandlers
          },

          function (dispose) {
            // dispose: object with X, Y of the last line add to the PDF 
            //          this allow the insertion of new lines after html
            pdf.save('Test.pdf');
          }, margins);
      },
      topdf() {
        html2canvas(document.body).then(function (canvas) {

          var img = canvas.toDataURL("image/png");
          var doc = new jsPDF()
          doc.addImage(img, 'JPEG', 20, 20);

          doc.save('resume.pdf');

        });

        // var print = document.querySelector('#forPdf').innerHTML;
        // var orig = document.body.innerHTML;

        //  var html="<html>";
        //   html+= print;
        //   html+="</html>";

        //  var mywindow = window.open('', 'Print', 'height=600,width=800');
        //  var divContents = $("#forPdf").html() +
        //             "<script>" +
        //             "window.onload = function() {" +
        //             "     window.print();" +
        //             "};" +
        //             "<" + "/script>" + `<script src="https://cdn.jsdelivr.net/npm/vue">` +
        //             "<" + "/script>";

        //   mywindow.document.write(divContents);
        //   mywindow.document.close();

        // document.body.innerHTML = orig;
        // window.print()
      },
      refresh(data) {
        // this.authenticatedUser = this.$auth.getAuthenticatedUser();
        this.user = data.body;
        console.log(data.body.id)

        this.$http.get(`api/user`)
          .then(mes => this.userMe = mes.body)
          .catch()

      },
      imageChanged(e) {
        console.log(e.target.files[0].size);
        if (e.target.files[0].size <= 10485760) {
          var fileReader = new FileReader();

          fileReader.readAsDataURL(e.target.files[0]);

          fileReader.onload = e => {
            this.image = e.target.result;
            this.imageport.image = e.target.result;
          }

        } else {
          swal("File image exceeds 10mb", {
            icon: "warning",
          }).then((value) => {
            location.reload()
          });


        }
        console.log(this.activity);
      },
      submitImage() {
        this.$http.post('api/imageport/', this.imageport)
          .then(response => {
            console.log(response)
            swal("Succesfully submitted!", {
              icon: "success",
            }).then((value) => {
              location.reload()
            });
          })
      }

    },
    
  }

</script>

<style lang="scss">
  form input {
    width: 100%;
  }

  .green {
    background-color: green;
  }

  img {
    width: 100%;
    /* min-width:700px;
    max-width: 700px; */
  }



  i {
    margin: 0 10px;
    font-size: 24px;
    color: #a2a2a2;
  }

  ul {
    list-style: none;
    padding: 0;
  }

  li {
    margin: 0;
  }

</style>
