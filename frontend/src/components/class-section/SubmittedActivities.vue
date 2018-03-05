<template>
  <div class="modal--wrap">
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
                            {{momentize(act.created_at)}}
                        </td>
                        <td>
                            <span v-if="act.score">
                                    {{act.score.totalScore}}
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
                                    {{act.score.totalScore}}
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
                            <tr>
								<th>{{rubric.title}}</th>
                            	<th v-for="question in totalCol">{{question.col_num}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr  v-for="(criteria, index) in rubric.row" :key="criteria">

                            <th class="titleArea" scope="row">{{criteria.criteria}} ({{criteria.percent}}%)</th>
                            <td v-for="quest in criteria.col">
                                <p>{{quest.description}}</p> 
                            </td>
                            <td v-show="!modal.evaluated">
								<input @change="checkMax(criteria.raw, index)" v-model="criteria.raw" type="number" min="0">
								
							</td>
                            <td class="scoreArea d-flex flex-column justify-content-center align-items-center" v-if="modal.evaluated">
								<h6 class="text-dark">{{evaluatedScores.raw[index].raw}}</h6>  ({{evaluatedScores.raw[index].computed}})
							</td>

                            </tr>  
                        </tbody>
                        </table>
                            <div  class="d-flex justify-content-center align-items-center">
                            <h3 v-if="modal.evaluated">  Total Score:  {{evaluatedScores.totalScore}} </h3>
                            <button v-show="!modal.evaluated" class="btn content__button--passive content__helper" @click="scoreThis">save</button>
                            
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
            rubric:{},
            totalCol:{},
            submitted: [],
            modal:{},
            score:{
                body:"",
                act_id:"",
                user_id:"",
                
    },
		rawScore:{
			scores:[],
			totalScore:''
		},
    imagePath: '',
		evaluation:{
			evaluated:true,
            score_id:''
			},
        evaluatedScores:{},
        user:"",
        used:{
            used:true
        }
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
        checkMax(val,index){
            if(this.rubric.row[0].col.length+1 <= val){
                swal("Must be a valid score", {
                        icon: "warning"
                    }).then(response => {
                        this.rubric.row[index].raw = "0"
                    })
            }
        },
        getTotal(rawScore, totalCriteria, percent){
                    return rawScore / totalCriteria * percent;
                },
        scoreThis(){
            this.rawScore.act_id = this.modal.id;
            this.rawScore.user_id = this.modal.user_id;
            var arrayLength = this.rubric.row.length ;
            this.rawScore.scores=[];
            var computedScore = 0;
            var num = 0;
            for(var i=0; i<arrayLength; i++){
					
						computedScore = this.getTotal(this.rubric.row[i].raw, this.rubric.row[i].col.length, this.rubric.row[i].percent).toFixed(2)
						console.log(computedScore)
						this.rawScore.scores.push({criteria_num : i+1 , computed : JSON.parse(computedScore), raw : JSON.parse(this.rubric.row[i].raw)})
						
                    }
            for(var i=0; i<this.rawScore.scores.length; i++){
                        num += this.rawScore.scores[i].computed;
                    }
            this.rawScore.totalScore = num;
            this.$http.post("api/submitScore", this.rawScore).then(response => {
						console.log(response);
						this.evaluation.score_id = response.body.id;
								this.$http.put("api/eval/imagecore/" + this.modal.id, this.evaluation).then(response => {
								console.log(response);
									swal("Succesfully Evaluated!", {
										icon: "success"
									}).then(response => {
                                        if(this.rubric.used === 0){
                                            this.$http.put('api/rubrics/row/used/' + this.rubric.id, this.used)
                                                .then(response => {
                                                console.log(response)
                                                location.reload();
                                            })
                                        }
                                        else{
                                            location.reload();
                                        }
                                    });
							});
        });

        },
        getRubric(){
			this.$http.get(`api/rubrics/certain/`+ this.modal.rubric_set_id)
				.then(response => {
					this.rubric = response.body.rubric;
					this.totalCol = response.body.rubric.row[0].col
                    console.log(response.body)
                    
                    var arrayLength = response.body.rubric.row.length -1;
					
						for(var i=0; i<=arrayLength; i++){

							this.$set(this.rubric.row[i], 'raw', 0)
						}
				});
		},
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
                this.getRubric()
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
                                    })
                                    // location.reload()
							});
        });
        },
          getScore () {
			this.$http.get(`api/submitScore/`+this.modal.score.id)
        .then(response => {this.evaluatedScores = response.body})
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
  .modal--wrap{

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
  
    .scoreArea{
      width: 150px;
    }
    .titleArea{
      min-width: 150px;
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
  }
</style>
