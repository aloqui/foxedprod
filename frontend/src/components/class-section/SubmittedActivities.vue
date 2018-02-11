<template>
  <div>
    <div class="container">


      <div class="row pt-5 mb-2">



        <div class="col-7 img__act">
          <span v-if="submitted.class.image != 'none'">
           
            <img :src="imagePath + submitted.class.image"> 
            </span>
          <span v-else>
            <img class="img-fluid rounded mb-3 mb-md-0" src="http://placehold.it/700x300" alt=""> </span>
        </div>
        <div class="col-5">
          <h3>{{submitted.class.title}}</h3>
          <p>{{submitted.class.body}}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
           <table class="table mt-2 pt-3 table__activities">
                <thead>
                    <tr>
                    <th>Title</th>
                    <th>Submitted By</th>
                    <th>Time submitted</th>
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
                            <span v-if="act.score">
                                    {{act.score.body}}
                            </span> 
                            <span v-else>
                                    Not scored
                            </span>
                        </td>
                    </tr>

                    <tr v-for="act in submitted.userImage" @click="cons(act)"  data-toggle="modal" data-target="#exampleModal">
                        <td>{{act.title}}</td>
                        <td>
                            <a > {{act.user.name}} </a>
                        </td>
                        <td>
                            {{momentize(act.created_at)}}
                        </td>
                        <td>
                            <span v-if="act.score">
                                    {{act.score.body}}
                            </span> 
                            <span v-else>
                                    Not scored
                            </span> 
                        </td>
                    </tr>
                </tbody> 
            </table>
        </div>
      </div>
    </div>
    <!-- <h1>
            Activity : {{act}} <br>
            Name : {{submitted.class.title}} <br>
            About : {{submitted.class.body}}
        </h1> --> 
           
            
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
                        <div class="art-preview">
                            <span class="image__preview" v-if="modal.image != 'none'">
                                <img :src="imagePath + modal.image">
                            </span>
                        
                            </div>
                        <div class="collapse" id="collapseExample">
                        <table class="table table-fit">
                        <thead>
                            <tr class="text-center">
                            <th> </th>
                            <th>5</th>
                            <th>4</th>
                            <th>3</th>
                            <th>2</th>
                            <th>1</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row">Elements of design:</th>
                            <td>Planned carefully, made several sketches, and showed an awareness of the elements and principles of design; chose color scheme carefully, used space effectively.</td>
                            <td>The artwork shows that the student applied the principles of design while using one or more elements effectively; showed an awareness of filling the space adequately</td>
                            <td>@The student did the assignment adequately, yet it shows lack of planning and little evidence that an overall composition was planned.</td>
                            <td>The student did the assignment adequately, yet it shows lack of planning and little evidence that an overall composition was planned.</td>
                            <td>The assignment was completed and turned in, but showed little evidence of any understanding of the elements and principles of art; no evidence of planning.</td>
                            <td v-show="!modal.evaluated"><input v-model="score.first" type="number"  min="0" max="5"></td>
                            <td><h3>{{evaluatedScores.first}}</h3></td>
                            </tr>
                            <tr>
                            <tr>
                            <th scope="row">Creativity/Originality</th>
                            <td>The student explored several choices before selecting one; generating many ideas; tried unusual combinations or changes on several ideas; made connections to previous knowledge; demonstrated understanding problem solving skills.</td>
                            <td>The student tried a few ideas for selecting one; or based his or her work on someone else's idea; made decisions after referring to one source; solve the problem in logical way.</td>
                            <td>The student tried in idea, and help out adequately, but it lacked originality; substituted "symbols" for personal observation; might have copied work.</td>
                            <td>The student fulfill the assignment, but gave no evidence of trying anything unusual.</td>
                            <td>The student showed no evidence of original thought</td>
                            <td v-show="!modal.evaluated"><input v-model="score.second" type="number" min="0" max="5"></td>
                            <td><h3>{{evaluatedScores.second}}</h3></td>
                            </tr>
                            <tr>
                            <th scope="row">Effort/Perseverance</th>
                            <td>The project was continued until it was complete as the student could make it; gave it effort far beyond that required; to pride in going well beyond the requirement.</td>
                            <td>The student work hard and completed the project, but with a loom or effort it might have been outstanding.</td>
                            <td>The student finished the project, but it could have been improved with more effort; adequate interpretation of the assignment, but lacking finish; chose an easy project and did it indifferently.</td>
                            <td>The project was completed with minimum effort.</td>
                            <td>The student did not finished the work adequately.</td>
                            <td v-show="!modal.evaluated"><input v-model="score.third" type="number" min="0" max="5"></td>
                            <td><h3>{{evaluatedScores.third}}</h3></td>
                            </tr>
                            <tr>
                            <th scope="row">Craftsmanship/Skill/Consistency</th>
                            <td>The artwork was beautiful and patiently done; it was as good as hard work could make it.</td>
                            <td>With a little more effort, the work could have been outstanding; lacks the finishing touches.</td>
                            <td>The student showed average craftsmanship; adequate, but not as good as it could have been, a bit careless.</td>
                            <td>The student showed below average craftsmanship, lack of pride in finished work.</td>
                            <td>The student showed poor craftsmanship; evidence of lazy this or lack of understanding.</td>
                            <td v-show="!modal.evaluated"><input v-model="score.fourth" type="number" min="0" max="5"></td>
							<td><h3>{{evaluatedScores.fourth}}</h3></td>
                            </tr>
                        </tbody>
                        </table>
                            <div  class="d-flex justify-content-center align-items-center">
                            <h3 v-if="modal.evaluated">  Total Score:  {{evaluatedScores.body}} </h3>
                            <button v-show="!modal.evaluated" class="btn content__button--passive content__helper" @click="submitscore">save</button>
                        </div>
                        </div>

                        
                    </div>
                    <div class="modal-footer">
                        <button v-if="!modal.evaluated && user.prof" class="btn content__button--passive content__helper" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            rubrics
                        </button>
                        <button v-else-if="modal.evaluated && user.id == modal.user_id || user.prof" class="btn content__button--passive content__helper" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" @click="getScore">
                            Evaluation
                        </button>
                    </div>
                    </div>
                </div>
                </div>
        </div>  
</template>
<script>
import moment from 'moment'
export default {
    data (){
        return {
            act: JSON.parse(this.$route.params.id),
            submitted: [],
            modal:{},
            score:{
                body:"",
                act_id:"",
                user_id:"",
                first:"",
                second:"",
                third:"",
                fourth:"",
                
    },
    imagePath: '',
		evaluation:{
			evaluated:true,
            score_id:''
			},
        evaluatedScores:{},
        user:""
        }
      
    },
    mounted() {
        this.$http.get(`api/activities/${this.$route.params.id}/eval`)
            .then( data => {
                console.log("HERE -> "+data.body.score)
                this.submitted = data.body;
            });
            this.$http.get(`api/user`)
        .then(me => this.user = me.body)
        .catch();
        this.getImagePath()
      },
      methods: {
          momentize(date){
           return moment(date).calendar()
        }, 
      getImagePath() {
        this.imagePath = `${location.protocol}//${location.hostname}/images/`
        if (location.port)
          this.imagePath = `${location.protocol}//${location.hostname}:${location.port}/images/`
      },
          cons(ac){
              this.evaluatedScores= {};
                this.modal = ac;
                $('.collapse').collapse('hide');
          },
          submitscore(){
              this.score.act_id = this.act;
                this.score.user_id = this.modal.user.id;
                // JSON.parse(this.score)
                function getTotal(num, per){
                    return num / 5 * per;
                }
                this.score.body = getTotal(this.score.first,25) + getTotal(this.score.second,25) + getTotal(this.score.third,25) + getTotal(this.score.fourth,25);
              
              this.$http.post("api/submitScore", this.score).then(response => {
                                    console.log(response);
                                    this.evaluation.score_id = response.body.id;
								this.$http.put("api/eval/imagecore/" + this.modal.id, this.evaluation).then(response => {
								console.log(response);
									swal("Succesfully created!", {
										icon: "success"
                                    });
                                    // location.reload()
							});
          });
          },
          getScore () {
			this.$http.get(`api/submitScore/`+this.modal.score.id)
        .then(response => this.evaluatedScores = response.body)
        .catch()
		}
      }
    }
  

</script>
<style lang="scss" scoped>
.art-preview{
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    .image__preview{
        width: 50%;
        img{
          padding-top: 10px;
          width: 100%;
          height: 100%;
        }
    }
}
.img__act{
    img{
        width: 100%;
    }
}
.table__activities{
  background: #fff;
  border-radius: 1%;
}
// .table-fit {
//     width: 100%;
// }
h1{
    padding-top: 100px;
  }

.modal {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  overflow: hidden;
}
.modal-dialog {
  position: fixed;
  margin: 0;
  width: 100%;
  height: 100%;
  padding: 0;
}
.modal-content {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  border: 2px solid #3c7dcf;
  border-radius: 0;
  box-shadow: none;
  width: 100vw;
}
.modal-header {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  height: 50px;
  padding: 10px;
  border: 0;
}
.modal-title {
  font-weight: 300;
  font-size: 2em;
  color: rgb(68, 68, 68);
  line-height: 30px;
}
.modal-body {
  position: absolute;
  top: 50px;
  bottom: 60px;
  width: 100%;
  font-weight: 300;
  overflow: auto;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center; 
  .collapse{
    width: 100%;
    height: 100%;
    background: #fff;
    z-index: 1;
  }
}
.modal-footer {
  position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  height: 60px;
  padding: 10px;
  background: #f1f3f5;
}
</style>
