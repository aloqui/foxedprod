<template>
  <div>
    <p class="content__helper text-uppercase">Activities</p>
    <hr>
    <div v-if="hasAct">
    <activity v-for="activity in orederedDate" @delete-activity="deleteActivity(activity)" @cons="conss(activity)" :authenticatedUser="authenticatedUser"
      :activity="activity" :user="user" :classOwner="classOwner"></activity>
    </div>
    <div v-else>
      <p class="text-uppercase content__helper">0 Activities Found.</p>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title center" id="exampleModalLabel">{{modal.title}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span v-if="modal.image != 'none'">
                            <img :src="imagePath + modal.image">
                        </span>
                        <div>
                            <h5>Instruction: </h5>
                            <p> &nbsp; {{modal.body}}</p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Submit to this activity</label>
                            <input  type="file" accept="image/*" class="form-control content__helper" @change="imageChanged">
                            
                        </div>
                        <div class="collapse" id="collapseExample">
                        <table class="table table-fit">
                        <thead>
                            <tr>
															<th>{{rubric.title}}</th>
                            	<th v-for="question in totalCol">{{question.col_num}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr  v-for="criteria in rubric.row">
                            <th scope="row">{{criteria.criteria}} ({{criteria.percent}}%)</th>
                            <td v-for="quest in criteria.col">
                                      <p>{{quest.description}}</p> 
                                    </td>
							<td><h3> </h3></td>
                            </tr> 
                        </tbody>
                        </table>

                        </div>
                    </div>
                    <div class="modal-footer">
                      <button @click="getRubric" class="btn content__button--passive content__helper" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            show rubric
                        </button>
                        
                                
                                <input v-model="imageport.title" type="text" placeholder="title" class="input--default">
                                <button class="btn content__button--passive content__helper" @click="submitImage">save</button>
                            
                    </div>
                    </div>
                </div>
                </div> 
  </div>
</template>

<script>
  import Activity from './Activity.vue'
  import swal from 'sweetalert'

  export default {
    data() {
      return {
        activities: [],
        modal: {},
        imageport: {},
        imagePath: '',
        rubric:{},
        totalCol:{},
        classOwner: {},
        hasAct: false
      }
    },

    props: [
      'user'
    ],
    computed: {
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
      },
      closeCol(){
                $('.collapse').collapse('hide');
          },
      datea() {
        var date = new Date();
        return console.log(date)

      },
      orederedDate: function () {
        return _.orderBy(this.activities, 'created_at', ['desc'])
      }
    },
    components: {
      'activity': Activity
    },
    mounted() {
      this.getImagePath()
      this.$http.get(`api/activities/${this.$route.params.id}`)
        .then(response => {
          this.activities = response.body.class_posts
          this.classOwner = response.body.owner
          if(this.activities.length > 0 ) 
            this.hasAct = true
          // console.log(response.body[0].due)
        })
    },
    methods: {
      getRubric(){
			this.$http.get(`api/rubrics/certain/`+ this.modal.rubric_set_id)
				.then(response => {
					this.rubric = response.body.rubric;
					this.totalCol = response.body.rubric.row[0].col
					console.log(response.body)
				})
				;
		},
      getImagePath() {
        this.imagePath = `${location.protocol}//${location.hostname}/images/`
        if (location.port)
          this.imagePath = `${location.protocol}//${location.hostname}:${location.port}/images/`
      },
      deleteActivity(activities) {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              this.$http.delete('api/activity/' + activities.id)
                .then(response => {
                  let index = this.activities.indexOf(activities)
                  this.activities.splice(index, 1)
                  swal("Poof! Your imaginary file has been deleted!", {
                    icon: "success",
                  });
                })

            } else {
              swal("Your imaginary file is safe!");
            }
          });
      },
      imageChanged(e) {
        console.log(e.target.files[0].size);
        if (e.target.files[0].size <= 10485760) {
          var fileReader = new FileReader();

          fileReader.readAsDataURL(e.target.files[0]);

          fileReader.onload = e => {
            this.imageport.image = e.target.result;
          }

        } else {
          swal("File image exceeds 10mb", {
            icon: "warning",
          }).then((value) => {
            location.reload()
          });


        }
      },
      conss(a) {
        console.log(a)
        $('.collapse').collapse('hide');
        this.modal = a;
      },
      submitImage() {
        this.imageport.submitted = true;
        this.imageport.activity_id = this.modal.id;
        this.imageport.rubric_set_id = this.modal.rubric_set_id;
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
    }
  }

</script>
<style lang="scss" scoped>
  img {
    width: 100%;
  }

  .modal-body {
      .collapse{
    width: 100%;
    height: 100%;
    background: #fff;
    z-index: 1;
  }
  }

</style>
