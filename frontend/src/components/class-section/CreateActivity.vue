<template>
  <div class="create--activity mb-3">
    <div class="p-0">
      <div class="">
        <div class="">
          <div class="row">
            <div class="col-12 d-flex justify-content-center align-items-center">
              <div class="w-50 ">

              <button  @click="getRubrics()"  type="button" class="btn content__button--passive content__helper" data-toggle="modal" data-target="#imageport">
                  Manage Rubrics
                </button>
              <img :src="image" class="" />
              <form @submit.prevent="create">
                <div class="form-group">
                  <label class="content__helper">Title</label>
                  <input name="title" type="text" class="form-control" v-model="activity.title" v-validate="'required'">
                  <div class="help-block alert alert-danger" v-show="errors.has('title')">
                    {{errors.first('title')}}
                  </div>
                </div>
                <div class="form-group">
                  <label class="content__helper">Instructions</label>
                  <textarea name="question" type="text" class="form-control" v-model="activity.body" v-validate="'required'"></textarea>
                  <div class="help-block alert alert-danger" v-show="errors.has('question')">
                    {{errors.first('question')}}
                  </div>
                </div>
                <div class="form-group m-auto row no-gutters">
                  <div class="col-12 d-flex flex-column justify-content-center">
                    <label class="content__helper">Type</label>
                    <select class="section-block hover-pointer" @click="getRubrics()" v-model="activity.type">
                      <option value="code" default>Code</option>
                      <option value="image">Image</option>
                    </select>
                    <span >
                  <label class="content__helper">Rubric</label>
                  <br>
                  <select class="section-block hover-pointer" @change="setRubricId($event.target.value)">
                        <option v-for="title in choices" :value="title.id">{{title.title}}</option>
                  </select>
                </span>
                  </div>
                  <div class="col-12 mt-2 d-flex flex-column justify-content-center">
                    <label class="content__helper">Header Image</label>
                    <label for="files" class="section-block hover-pointer ">
                      <div class="d-flex">
                      <i class="far fa-image" aria-hidden="true"></i>
                      <p class="content__helper ml-2">Select an Image</p>
                      </div>
                    </label>
                    <input id="files" type="file" accept="image/*" class="form-control  content__helper pull-right" @change="imageChanged" style="visibility:hidden;">
                  </div>
                  <div class="col-12">
                    <label class="content__helper">Deadline for submission</label>
                    <input class="form-control section-block" type="datetime-local" v-model="tomorrow" id="datePicker" :min="limit">
                  </div>
                  <div class="col-12 mt-2">
                    <input type="submit" class="btn content__button--passive content__helper pull-right m-0"  data-toggle="modal" data-target="#createActivity"  value="Post Activity">
                  </div>
                </div>

              </form>
            </div>
              </div>
          </div>

            <div class="row  modal--cover">
              <div class="col-12">
                <div class="modal fade" id="imageport" tabindex="-1" role="dialog" aria-labelledby="imageportLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header text-center">
                        <!-- <h5 class="modal-title" id="imageportLabel">Create Rubrics</h5> -->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="container">

                            <div class="row">
                              <div class="col-12 container--flex">
                                <div v-if="newss" class="image__logo--title">
                                <img class="img" :src="imagePath + 'assets/foxedlogo.png'">
                                </div>
                                  <h1 class=" content__title">FoxedFolio Rubric</h1>
                                  <div v-if="newss" class="rubric--header w-25 d-flex">
                                    <div class="d-flex flex-column text-left w-75">
                                      <label class=" font-weight-bold">Name *</label>
                                      <input v-model="all.title" name="title" type="text" class="form-control " placeholder="Rubric Name">
                                    </div>

                                    <div class="d-flex flex-column mt-4 text-left w-75">
                                      <label class=" font-weight-bold">How many descriptors?</label>
                                      
                                        <input placeholder="total descriptors"  class="form-control" type="number" min="0" v-model="columnNum">
                                        <button class="btn content__button--passive content__helper w-50 pull-left mt-2" @click="addTextArea(columnNum)">ok</button>
                                      
                                    </div>
                                  <!-- <div class="d-flex flex-column">
                                      <label>For</label>
                                    <select v-model="all.for" class="form-control">
                                      <option value="code" default>Code</option>
                                      <option value="image">Image</option>
                                    </select>
                                  </div> -->
                                    
                                    
                                    
                                  </div>
                                </div>
                                
                                <!-- <button @click="createRubrics"> submit</button> -->
                                
                                
                                  <div class="col-12"> 
                                  
                                  <div class="form-group">
                                  <div v-if="!currentR.row">
                                    <span v-if="all.col[0]"  class="d-flex flex-column criteria__small">
                                          <label>Criteria 1</label>
                                            <!-- <p v-if="all.col[0]" class=" content__helper font--semi-bold font-italic">Maximum percentage varies on users intended total percentage</p> -->
                                          <span class="row">
                                          <input class="form-control col-8" v-model="all.criteria"  name="title" type="text" > 
                                          <input class="form-control col-3" v-model="all.percent" type="number" name="number" max="100" min="0" placeholder="%">
                                          </span>
                                    </span>
                                      <span class="d-flex">
                                          <textarea v-for="textareaCol in all.col" type="text" class="form-control" v-model="textareaCol.description" :placeholder="textareaCol.col_num"></textarea>
                                      </span>
                                      <p v-if="all.col[0]" class=" content__helper font--semi-bold font-italic">the order of these descriptors are ( 1 - nth ) which is 1 being the lowest </p>
                                    
                                  </div>
                                  <div v-else>
                                  <span class="d-flex flex-column criteria__small">
                                    <label>Criteria</label>
                                    <span class="row">
                                      <input class="form-control col-8" v-model="currentC.criteria"  name="title" type="text" > 
                                      <input class="form-control col-3" v-model="currentC.percent" type="number" name="number" max="100" min="0" placeholder="%">
                                    </span>
                                  </span>
                                  <span class="d-flex ">
                                    <textarea v-for="textareaCol in currentC.col" type="text" class="form-control" v-model="textareaCol.description" :placeholder="textareaCol.col_num"></textarea>
                                  </span>
                                  </div>
                                </div>
                                <button class="btn content__button--passive content__helper pull-right mb-3" v-if="currentR.row" @click="addRow()">add new criteria</button>
                                <button class="btn content__button--passive content__helper pull-right mb-3" v-if="all.col[0] && !currentR.row" @click="submitAll()">save</button>
                                </div> 
                                
                                <div class="col-12">
                                      <table class="table rubric--table">
                                      <thead>
                                        <tr>
                                          <th v-if="currentR.title">
                                            {{currentR.title}}
                                            <p class=" font-weight-light">total percentage ({{totalPercent}}%)</p>
                                          </th>

                                          <!-- <th v-if="currentC.col" v-for="textareaCol in all.col">{{textareaCol.col_num}}</th> -->
                                          <th v-for="textareaCol in currentC.col">{{textareaCol.col_num}}</th>
                                        </tr>
                                      </thead>
                                      <tbody  id="my-table">
                                        <tr  v-for="criteria in currentR.row">
                                          <th scope="row" class="update--criteria">
                                            <input class="form-control" type="text" v-model="criteria.criteria">
                                            <input class="form-control" type="number" min="0" v-model="criteria.percent">
                                            <span>
                                                <button class="btn content__button--passive content__helper" @click="editRow(criteria.id,criteria.percent,criteria.criteria)">update</button>
                                                <button class="btn content__button--passive content__helper" @click="deleteRow(criteria.id,currentR.id)">delete</button>
                                            </span>

                                          </th>
                                          <td v-for="quest in criteria.col" class="update--question">
                                            <textarea v-model="quest.description" id="scroll" class="form-control"></textarea>
                                            <span>
                                                <button class="btn content__button--passive content__helper" @click="editColumn(quest.id,quest.description)">update</button>
                                            </span>
                                          </td>
                                        </tr> 
                                      </tbody>
                                    </table> 
                                </div>  
                              </div> 
                          </div> 
                      </div>
                      <div class="modal-footer pb-3 ">
                              <label for="">Your Rubrics</label>
                              <select class="hover-pointer" v-model="chooseRubric"  @change="rubricsView($event.target.value)">
                                  <option class="content__helper" v-for="title in choices" :value="title.id">{{title.title}}</option>
                            </select>
                            <button class="btn content__button--passive content__helper" @click="newRubric()">
                                New
                              </button>
                      </div>
                    </div>
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
  import swal from "sweetalert";
  import moment from 'moment';
  export default {
    data() {
      return {
        all:{
          col:{}
        },
        columnNum:'',
        displayRubric:{},
        chooseRubric:{},
        choices:{},
        column:{
          col:{}
        },
        row:{},
        currentC:{},
        currentR:{},
        userMe:{},
        activity: {
          title: "",
          body: "",
          image: "",
          classroom_id: JSON.parse(this.$route.params.id),
          type: "code",
          due: ""
        },
        
        tomorrow:'',
        limit:'',
        image:'',
        rubrics:{},
        rubricsDet:{
          col_num:'1',
          
        },
        columnEdit:{},
        rowEdit:{},
        deleteU:{},
        newss:true,
        totalPercent:'',
        imagePath: '',
      };
    }, 
    props:[
  'user'
    ],
    methods: {
      deleteRow(id,rub){
                swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this criteria again!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                this.$http.delete('api/rubrics/' + id)
                .then(response => {
                      swal(" Deleted!", {
                  icon: "success",
                  }).then(value => this.rubricsView(rub));
                })
                .catch(response => {
             swal("Error Updating", {
                  icon: "error",
                  text: 'You already used this rubric to evaluate a student.',
                })
              })
                
            } else {
                swal("not deleted");
            }
            });
      },
      newRubric(){
        this.newss = true;
        this.currentC = []
        this.currentR = []
        this.chooseRubric ='';
        this.all[0] = [];
        
        this.addTextArea(0)
        this.columnNum='';
      },
      editRow(id,per,cri){
        this.rowEdit.criteria = cri;
        this.rowEdit.percent = per;
        this.$http.put("api/rubrics/row/update/" +id, this.rowEdit).then(response => {
            console.log(response); 
            swal("Succesfully Edited!", {
              icon: "success",
            }).then(response => this.getTotalPercentage());
          })
          .catch(response => {
             swal("Error Updating", {
              icon: "error",
              text: 'You already used this rubric to evaluate a student.',
            })
          })
      },
      editColumn(id,q){
        this.columnEdit.description = q;
        this.$http.put("api/rubrics/column/" +id, this.columnEdit).then(response => {
            console.log(response); 
            swal("Succesfully Edited!", {
              icon: "success"
            });
          })
          .catch(response => {
            console.log(response)
          })
      },
      editPart(){
        this.column.rubric_id = this.currentR.rowId;
        this.$http.post("api/rubrics/column/" + this.currentR.id, this.column).then(response => {
          this.getTotalPercentage()
            console.log(response); 
          })
          .catch(response => {
            console.log(response)
          })
      },
      submitAll(){
        this.$http.post("api/rubrics", this.all).then(response => {
          this.currentR = response.body
            console.log(response);
            swal("Succesfully created!", {
              icon: "success"
            });

            var colArray = []; 
            for(var i=1; i<=response.body.row[0].col.length; i++){
              colArray.push({col_num : i , description : ""})
            }
            this.currentC.col = colArray;
            swal("Succesfully created!", {
              icon: "success"
            }).then(response => this.rubricsView(this.currentR.id));
            
          })
          .catch(response => {
            swal("Please check your inputs", {
              icon: "warning",
            })
          })
      },
      getTotalPercentage(){
        this.totalPercent = 0;
        JSON.parse(this.totalPercent)
        var totalPercentCount = 0;
        for(var i=0; i<=this.currentR.row.length-1; i++){
              totalPercentCount += JSON.parse(this.currentR.row[i].percent);
              console.log(this.currentR.row[i].percent)
            }
            this.totalPercent = JSON.parse(totalPercentCount);
      },
        getImagePath() {
        this.imagePath = `${location.protocol}//${location.hostname}/images/`
        if (location.port)
        this.imagePath = `${location.protocol}//${location.hostname}:${location.port}/images/`
    },
      rubricsView(a){
        this.$http.get("api/rubrics/certain/" +  a ).then(response => {
            console.log(response); 
            // this.displayRubric = response.body.rubric;
            this.currentR = response.body.rubric;
            
            var colArray = []; 
            for(var i=1; i<=response.body.rubric.row[0].col.length; i++){
              colArray.push({col_num : i , description : ""})
            }
            this.getTotalPercentage();
            
            
            this.currentC.percent = '';
            this.currentC.criteria = '';
            this.currentC.col = colArray;
            this.newss = false;
          })
          .catch(response => {
            console.log(response)
          })
      },
      getRubrics(){
          if(this.choices.length != {}){
            this.$http.get("api/rubrics/show/"+  this.user.username ).then(response => {
            console.log(response); 
            this.choices = response.body.rubric;
            this.activity.rubric_set_id = response.body.rubric[0].id;
          })
          .catch(response => {
            console.log(response)
          })
          }
          
      },
      addRow(){
        this.currentC.rubric_set_id = this.currentR.id;
        // this.currentC.col = [];
         
        this.$http.post("api/rubrics/row/" + this.currentR.id, this.currentC).then(response => {
            console.log(response); 
            this.currentR = response.body;
            swal("Succesfully created!", {
              icon: "success"
            });
            var colArray = [];
            // this.currentC.col = colArray;

            for(var i=1; i<= this.currentR.row[0].col.length; i++){
              colArray.push({col_num : i , description : ""})
            }
            this.currentC.col = colArray;
            this.currentC.percent = '';
            this.currentC.criteria = '';
            this.currentC.rubric_set_id = this.currentR.id;
            
            
          }).catch(response => {
            
            this.rubricsView(this.currentR.id)
            console.log(response)
          })
          

      },
      
      addColumn(){
        this.column.rubric_id = this.currentR.rowId;
        this.$http.post("api/rubrics/column/" + this.currentR.id, this.column).then(response => {
            console.log(response); 
          })
          .catch(response => {
            console.log(response)
          })
      },
      createRubrics(){
        this.$http.post("api/rubrics", this.rubrics).then(response => {
          this.currentR = response.body
            console.log(response);
            swal("Succesfully created!", {
              icon: "success"
            });
          })
          .catch(response => {
            console.log(response)
          })
      },
      addTextArea(a){
            var colArray = [];
            for(var i=1; i<=a; i++){ 
              colArray.push({col_num : i , description : ""})
            }
            this.all.col = colArray;
            
            // div.innerHTML += "\n<br />";
        }, 
      imageChanged(e) {
        console.log(e.target.files[0]);
        var fileReader = new FileReader();

        fileReader.readAsDataURL(e.target.files[0]);

        fileReader.onload = e => {
          this.activity.image = e.target.result;
          this.image = e.target.result;
        };
        console.log(this.activity);
      },
      setRubricId(id){
        this.activity.rubric_set_id = id;
      },
      create() {
        var time = new Date();
        var checkTime = moment(time).format("YYYY-MM-DD HH:mm:ss");

        this.activity.due = moment(this.tomorrow).format("YYYY-MM-DD HH:mm:ss");

        if (this.activity.due >= checkTime) {
          this.$http.post("api/activity", this.activity).then(response => {
              console.log(response);
              swal("Succesfully created!", {
                icon: "success"
              });
              this.$router.push("/activity/" + response.body.id);
            })
            .catch(response => {
              console.log(response)
            })
        } else {
          swal("Invalid Date", {
            icon: "error"
          });
        }
      },
      authenticatedUser() {
        return this.$auth.getAuthenticatedUser();
      },

    },
    mounted(){
      var tom = new Date();
       this.limit = moment(tom).format("YYYY-MM-DDTHH:mm")
       this.getImagePath()
      //  this.getRubrics()
       
        

       
    },
    created() {
      // this.$http.get(`api/user`).then(mes => {
      //     this.userMe = mes.body; 
      //     })

          // this.getRubrics()
        
          },
  };

</script>
<style lang="scss">
  .create--activity {}

  img {
    width: 100%;
  }

  .form {
    width: 100%;

    input {
      width: 100%;
    }
    .btn {}
  }
.modal--cover{
background-color: #eeeeee;
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
  height: 20px;
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
  justify-content: stretch;
  align-items: center; 
    .image__logo--title{
      width: 200px;
      height: 150px;
  }
  .criteria__small{
    width: 20%;
    margin-bottom: 10px;
  }
  .rubric--header{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 300px;
    background-color: #fcc5a1;
    padding: 5px 0 5px 0;
      border-radius: 2px;
    }
    .container--flex {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color: none !important;
  
}
.update--criteria{
  span{
    display: none;
  }
  &:hover{
    span{
      display: block;
    }
    
  }
}
.update--question{

  #scroll::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}

#scroll::-webkit-scrollbar
{
	width: 10px;
	background-color: #F5F5F5;
}

#scroll::-webkit-scrollbar-thumb
{
	background-color: #525151;
	border: 2px solid #555555;
}
  
  textarea{
    overflow-x: hidden;
    min-height: 120px;
    &:focus{
      height: 160px;
    }
  }
  span{
    display: none;
  }
  &:hover{
    span {
        display: block;
      }
  }
}

.row{
    .rubric--table{
      overflow-x: scroll;
      background: #fff;
    }
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
