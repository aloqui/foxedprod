<template>
      <div>
        <activity v-for="activity in activities" @delete-activity="deleteActivity(activity)" @cons="conss(activity)"  :authenticatedUser="authenticatedUser" :activity="activity" :user="user"></activity>
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
                            <img :src="'http://localhost:3000/images/' + modal.image">
                        </span>
                        <div>
                            <h5>Instruction: </h5>
                            <p> &nbsp; {{modal.body}}</p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Submit to this activity</label>
                            <input  type="file" accept="image/*" class="form-control content__helper" @change="imageChanged">
                            <div v-show="authenticatedUser.prof && act_id && !eval" class="d-flex justify-content-end align-items-center pt-2">
                                
                                <input v-model="imageport.title" type="text" placeholder="title" class="input-sm">
                                <button class="btn content__button--passive content__helper" @click="submitImage">save</button>
                            </div>
                        </div>
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
        data () {
            return {
                activities:[],
                modal:{},
                imageport:{},
            }
        },
        
        props: [
            'user'
        ],
        computed: {
            authenticatedUser () {
                return this.$auth.getAuthenticatedUser()
            },
            datea(){
                var date = new Date();
                return console.log(date)

            }
        },
        components: {
            'activity' : Activity
        },
        created () {
            this.$http.get(`api/activities/${this.$route.params.id}`)
            .then(response => {
                this.activities = response.body
                // console.log(response.body[0].due)
            })
        },
        methods: {
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
                            this.activities.splice(index,1)
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
                    console.log(e.target.files[0]);
                    var fileReader = new FileReader();

                    fileReader.readAsDataURL(e.target.files[0]);

                    fileReader.onload = e => {
                    this.imageport.image = e.target.result;
                    };
                },
            conss(a){
                    console.log(a)
                    this.modal = a;
                },
            submitImage(){
                    this.imageport.submitted = true;
                    this.imageport.activity_id = this.modal.id;
                    this.$http.post('api/imageport/', this.imageport)
                .then(response => {
                    console.log(response)
                            swal("Succesfully submitted!", {
                        icon: "success",
                        });  
                })
                }
        }
    }
</script>
<style lang="scss" scoped>
img{
    width:100%;
}

.modal-body{

}
</style>
