<template>
    <div>
        <div class="container">


  <div class="row pt-5">
      
            

            <div class="col-md-5">
            <span v-if="submitted.class.image != 'none'"> <img  :src="'http://localhost:3000/images/' + submitted.class.image"> </span>
            <span v-else> <img class="img-fluid rounded mb-3 mb-md-0" src="http://placehold.it/700x300" alt=""> </span>
        </div>
        <div class="col-md-7">
          <h3>{{submitted.class.title}}</h3>
            <p>{{submitted.class.body}}</p>
        </div>
  </div>
  </div>
        <!-- <h1>
            Activity : {{act}} <br>
            Name : {{submitted.class.title}} <br>
            About : {{submitted.class.body}}
        </h1> -->
        <div>
            <table class="table">
                <thead>
                    <tr>
                    <th>Title</th>
                    <th>Submitted By</th>
                    <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="act in submitted.userAct">
                        <td>{{act.title}}</td>
                        <td>
                            <router-link  :to="'/'+act.user.username +'/codes/' + act.id"><span>{{act.user.name}}</span></router-link>
                        </td>
                        <td>
                            <span v-for="sco in submitted.score">
                                            <span v-if="sco.user_id == act.user_id">
                                                {{sco.body}}
                                            </span> 
                                        </span> 
                        </td>
                    </tr>

                    <tr v-for="act in submitted.userImage">
                        <td>{{act.title}}</td>
                        <td>
                            <a @click="cons(act)"  data-toggle="modal" data-target="#exampleModal"> {{act.user.name}} </a>
                        </td>
                        <td>
                            <span v-for="sco in submitted.score">
                                    <span v-if="sco.user_id == act.user_id">
                                        {{sco.body}}
                                    </span> 
                            </span> 
                        </td>
                    </tr>
                </tbody> 
            </table>
            
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <img :src="'http://localhost:3000/images/' + modal.image">
                        </span>
                            
                        <div  class="d-flex justify-content-center align-items-center">
                            <input v-model="score.body" type="number" placeholder="score">
                            <button @click="submitscore">save</button>
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
    data (){
        return {
            act: JSON.parse(this.$route.params.id),
            submitted: [],
            modal:{},
            score:{
                body:"",
                act_id:"",
                user_id:""
		},
		evaluation:{
			evaluated:true
			}
        }
    },
    mounted() {
        this.$http.get(`api/activities/${this.$route.params.id}/eval`)
            .then( data => {
                console.log("HERE -> "+data.body.score)
                this.submitted = data.body;
            });
      },
      methods: {
          cons(ac){
                this.modal = ac;
          },
          submitscore(){
              this.score.act_id = this.act;
                this.score.user_id = this.modal.user.id;
              this.$http.post("api/submitScore", this.score).then(response => {
								this.$http.put("api/eval/imagecore/" + this.modal.id, this.evaluation).then(response => {
								console.log(response);
									swal("Succesfully created!", {
										icon: "success"
                                    });
                                    location.reload()
							});
          });
          }
      }
}
</script>
<style lang="scss" scoped>
h1{
    padding-top: 100px;
}
img{
    width: 100%;
}
</style>

