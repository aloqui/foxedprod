<template>
<div>


<section class="editor__page">
	
	
  <div id="wrap">

  <section id="code_editors" class="cm-s-twilight" >
    <div id="html" class="code_box ">
      <h3>HTML</h3>
      <textarea  name="html" ></textarea>
    </div>
    <div id="css" class="code_box">
      <h3>CSS</h3>
      <textarea name="css"></textarea>
    </div>
    <div id="js" class="code_box">
      <h3>JavaScript</h3>
      <textarea name="js"></textarea>
    </div>
  </section>
  
  <section id="output">
    <iframe></iframe>
		
  </section>
	
</div>
  <div class="editor__footer">
		<h1>{{codes.title}}</h1>
		<div v-show="user.id == id">
			<!-- <div> -->
				<input type="text" v-model="codes.title">
				<button class="btn" @click="update">Save</button>
				<button class="btn btn--red" @click="deleteCodes">Thrash</button>
				<span v-show="eval">
						<button @click="getScore" class="btn"  data-toggle="modal" data-target="#exampleModal">Evaluation</button>
				</span>
				<!-- <div v-show="act_id && evaluated">
					<button>resubmit</button>
			</div> -->
			</div>
				<div v-show="user.prof && act_id && !eval">
					<!-- <input v-model="score.body" type="number" placeholder="Score">
					<button class="btn" @click="submitScore">save</button> -->
					<button class="btn"  data-toggle="modal" data-target="#exampleModal">Rubrics</button>
			</div> 
			<span v-show="eval && user.prof">
				<button @click="getScore" class="btn"  data-toggle="modal" data-target="#exampleModal">Evaluation</button>
			</span>	
			
  
  </div>

    <!-- <router-link class="nav-item" to="/evaluation"> <a class="nav-link" href="">Save and Submit</a> </router-link> -->
	
	<!-- <input type="text" v-model="codes.html"> -->
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{codes.title}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-fit">
                        <thead>
                            <tr>
                            <th> </th>
                            <th>4</th>
                            <th>3</th>
                            <th>2</th>
                            <th>1</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row">Delivery</th>
                            <td>Completed between 90-100% of the requirements. Delivered on time, and in correct format</td>
                            <td>Completed between 80-90% of the requirements. Delivered on time, and in correct format</td>
                            <td>Completed between 70-80% of the requirements. Delivered on time, and in correct format </td>
                            <td>Completed less than 70% of the requirements and not delivered on time or not in correct format</td>
                            <td v-show="!eval"><input v-model="score.first" type="number" min="0" max="4"></td>
							<td><h3>{{evaluatedScores.first}}</h3></td>
                            </tr>
                            <tr>
                            <tr>
                            <th scope="row">Coding Standards</th>
                            <td>Excellent use of white space. Creatively organized work. Excellent  use of variables (no global variables, unambiguous naming).</td>
                            <td>Good use of white space. Organized work. Good  use of variables (no global variables, unambiguous naming)</td>
                            <td>White space makes program fairly easy to read. Organized work. Good  use of variables (few global variables, unambiguous naming).</td>
                            <td>Poor use of white space (indentation, blank lines). Disorganized and messy, Poor use of variables (many global variables, ambiguous naming).</td>
                            <td v-show="!eval"><input v-model="score.second" type="number" min="0" max="4"></td>
							<td><h3>{{evaluatedScores.second}}</h3></td>
                            </tr>
                            <tr>
                            <th scope="row">Runtime</th>
                            <td>Executes without errors excellent user prompts, good use of symbols, spacing in output. Thorough and organized testing has been completed and output from test cases is included.</td>
                            <td>Executes without errors. User prompts are understandable, minimum use of symbols or spacing in output. Thorough testing has been completed</td>
                            <td>Executes without errors. Some testing has been completed.</td>
                            <td>Does not execute due to errors. User prompts are misleading or non-existent. No testing has been completed.</td>
                            <td v-show="!eval"><input v-model="score.third" type="number" min="0" max="4"></td>
							<td><h3>{{evaluatedScores.third}}</h3></td>
                            </tr>
                            <tr>
                            <th scope="row">Efficiency</th>
                            <td>Solution is efficient, easy to understand, and maintain.</td>
                            <td>Solution is efficient and easy to follow (i.e. no confusing tricks). </td>
                            <td>A logical solution that is easy to follow but it is not the most efficient.</td>
                            <td>A difficult and inefficient solution.</td>
                            <td v-show="!eval"><input v-model="score.fourth" type="number" min="0" max="4"></td>
							<td><h3>{{evaluatedScores.fourth}}</h3></td>
                            </tr>
                        </tbody>
                        </table>

                        
						
                    </div>
                    <div class="modal-footer">
						<div v-if="eval" class="d-flex justify-content-center align-items-center pr-5">
                            <h5>Score: {{evaluatedScores.body}}</h5>
                        </div>
                        <div v-if="!eval" class="d-flex justify-content-center align-items-end pr-5">
                            <button class="btn content__button--passive content__helper" @click="submitScore">Submit</button>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
</div>
</template>

<script>
import Split from 'split.js'
		var x = {};
export default {
	data () {
		return {
			codes: {
				title:"",
				html:"",
				css:"",
				js: ""
			},
		id:"",
		act_id:"",
		eval:"",
		score:{
			body:"",
			act_id:"",
			user_id:"",
			first:"",
            second:"",
            third:"",
            fourth:"",
		},
		evaluation:{
			evaluated:true,
            score_id:''
			},
		user:{},
		evaluatedScores:{},
		evaluatedId:""
		}
	},
    created (){
		// this.getCode();
		// this.submitCodes();

    },
  
  methods: {
		submitScore() {
			function getTotal(num, per){
                    return num / 4 * per;
                };
				this.score.body = getTotal(this.score.first,25) + getTotal(this.score.second,25) + getTotal(this.score.third,25) + getTotal(this.score.fourth,25);
        	    this.$http.post("api/submitScore", this.score).then(response => {
						console.log(response);
						this.evaluation.score_id = response.body.id;
								this.$http.put("api/eval/codescore/" + this.$route.params.id, this.evaluation).then(response => {
								console.log(response);
									swal("Succesfully created!", {
										icon: "success"
									});
									location.reload()
							});
          });
      },
		update () {
			this.codes.html = x.html
			this.codes.css = x.css
			this.codes.js = x.js
          this.$http.put('api/codes/' + this.$route.params.id, this.codes)
          .then(response => {
              console.log(response)
                    swal("Succesfully Updated!", {
                icon: "success",
                });
          })
      },
        deleteCodes () {
            swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                this.$http.delete('api/codes/' + this.$route.params.id)
                .then(response => {
                    swal("CodePlay deleted!", {
                icon: "success",
                });
                })
                
            } else {
                swal("CodePlay not deleted");
            }
            });
            
        },
		getScore () {
			this.$http.get(`api/submitScore/`+this.evaluatedId)
        .then(response => this.evaluatedScores = response.body)
        .catch()
		}
  },
    computed: {
        authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
        }
    },
  mounted: function() {
    	this.$http.get(`api/user`)
        .then(me => this.user = me.body)
        .catch()

		Split(['#html', '#css','#js'], {
    sizes: [33.3, 33.3,33.4],
    minSize: 30
});
Split(['#code_editors','#output'], {
    direction: 'vertical',
		    elementStyle: function (dimension, size, gutterSize) {
        return { 'flex-basis': 'calc(' + size + '% - ' + gutterSize + 'px)' }
    },
    gutterStyle: function (dimension, gutterSize) {
        return { 'flex-basis':  gutterSize + 'px' }
    }
});
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
	
	var prepareSource = function() {
		var html = html_editor.getValue(),
				css = css_editor.getValue(),
				js = js_editor.getValue(),
				src = '';
				x = {html,css,js};
				
		src = base_tpl.replace('</body>', html + '</body>');
		
		css = '<style>' + css + '</style>';
		src = src.replace('</head>', css + '</head>');
		
		js = '<script>' + js + '<\/script>';
		src = src.replace('</body>', js + '</body>');
		
		return src;
	};
	

	var render = function() {
		var source = prepareSource();
		
		var iframe = document.querySelector('#output iframe'),
				iframe_doc = iframe.contentDocument;
		
		iframe_doc.open();
		iframe_doc.write(source);
		iframe_doc.close();
	};

	
	var cm_opt = {
		mode: 'text/html',
		gutter: true,
		lineNumbers: true,
		theme:"twilight",
		extraKeys:{"Ctrl-Space":"autocomplete"},
		autoCloseTags:true,
		matchBrackets: true,
		autoCloseBrackets: true,
		
		onChange: function () {
			console.log('1')
			render();
		}
	};
	
	var html_box = document.querySelector('#html textarea');
	var html_editor = CodeMirror.fromTextArea(html_box, cm_opt);
	html_editor.on("change", function(html_editor, change) {
	  // console.log("something changed! (" + change.origin + ")");
	  render();
	});

	
	cm_opt.mode = 'css';
	var css_box = document.querySelector('#css textarea');
	var css_editor = CodeMirror.fromTextArea(css_box, cm_opt);
	css_editor.on("change", function(css_editor, change) {
	  // console.log("something changed! (" + change.origin + ")");
	  render();
	});
	
	cm_opt.mode = 'javascript';
	var js_box = document.querySelector('#js textarea');
	var js_editor = CodeMirror.fromTextArea(js_box, cm_opt);
	js_editor.on("change", function(js_editor, change) {
	  // console.log("something changed! (" + change.origin + ")");
	  render();
	});
	
	
    // css_editor.setValue('body { color: red; }');

    this.$http.get('api/'+this.$route.params.user+'/codes/'+ this.$route.params.id)
          .then(response => {
			  			console.log(response)
						console.log(JSON.stringify(response.body.title) + '  THISSSSS')
						//   this.codes = response.body[10]
					// this.codes=response.body[1];
							response.body[0].html ? html_editor.setValue(response.body[0].html):html_editor.setValue("");
							response.body[0].css ? css_editor.setValue(response.body[0].css):css_editor.setValue("");
							response.body[0].js ? js_editor.setValue(response.body[0].js):js_editor.setValue("");

              // html_editor.setValue(response.body[0].html);
							// css_editor.setValue(response.body[0].css);
							// js_editor.setValue(response.body[0].js);
							
							this.codes.title = response.body[0].title;
							this.id = response.body[0].user_id;
							if(response.body[0].activity_id){
								this.act_id = response.body[0].user_id;
								this.score.act_id = response.body[0].activity_id;
								if(response.body[0].user_id){
									this.score.user_id = response.body[0].user_id;
								}
								if(response.body[0].evaluated){
									this.eval = response.body[0].evaluated;
								}
								if(response.body[0].score_id){
									this.evaluatedId = response.body[0].score_id;
								}
							}
          })



	var cms = document.querySelectorAll('.CodeMirror');
	for (var i = 0; i < cms.length; i++) {
		cms[i].style.height = '100%';
	}
	cms = document.querySelectorAll('.CodeMirror-scroll');
	for (i = 0; i < cms.length; i++) {
		cms[i].style.height = '100%';
	}
			
}

}
</script>
<style lang="scss"> 
.editor__page{
	.editor__footer{
		// max-height: 80px;
		display: flex;

		height: 35px;
		width: 100%;
		background: rgb(22, 22, 22);
		position: fixed;
		bottom: 0;
		left: 0;
		z-index: 1;
		justify-content: space-between;
		align-items: center;
		padding: 0 7px 0 7px;
		h1{
			font-size:18px;
			font-weight: 900;
			color: #ffffff;
		}
		button{
			padding: 0 5px 0 5px;
			font-size: 10px;
			margin: 0 4px 0 4px;
			background: #555;
			color: #ffffff;
			
			
		}
		.btn--red{
					
			}
		input{
			font-size: 12px;
			color: #555;
			padding: 0px 5px 0px 5px;
			border-radius: 5px;
			box-shadow: none;
		}
	}
}
#wrap {
    display: flex;
    flex-direction: column;
    width: 100%;
		height: 100vh;
		justify-content: flex-start;
}

#code_editors {
    width: 100%;
		display: flex;
		height: 100%;
		align-items: stretch;
		justify-content: flex-start;

		.code_box{
			padding-top: 12px;
			width: 100%;
			overflow: hidden;
			background: #000;
			display: flex;
			flex-direction: column;
			justify-content: flex-start;

			
		}
}
.gutter {
    background-color: #555;
		
    background-repeat: no-repeat;
    background-position: 50%;
}
.gutter.gutter-vertical {
    background-image:  url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAFAQMAAABo7865AAAABlBMVEVHcEzMzMzyAv2sAAAAAXRSTlMAQObYZgAAABBJREFUeF5jOAMEEAIEEFwAn3kMwcB6I2AAAAAASUVORK5CYII=');
		cursor: ns-resize;
}

.gutter.gutter-horizontal {
    background-image:  url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAeCAYAAADkftS9AAAAIklEQVQoU2M4c+bMfxAGAgYYmwGrIIiDjrELjpo5aiZeMwF+yNnOs5KSvgAAAABJRU5ErkJggg==');
		cursor: ew-resize;
}

// #code_editors .code_box {
//     width: 100%;
//     overflow: hidden;
// 		background: #000;
// 		display: flex;
// 		flex-direction: column;
// 		justify-content: flex-start;
// }
.code_box h3 {
	font-size: 15px;
	height: 30px;
	padding: 5px 10px; margin: 0;
	background: linear-gradient(#707070, #555);
	color: white;
	border-top: 1px solid #8F8F8F;
	border-bottom: 1px solid #202020;
	font-weight:600;
}
.code_box textarea {
	resize: none; 
	border: 0;
	padding: 15px;
	font-family: monospace;
	overflow-wrap: break-word!important;
}
.code_box textarea:focus {
	outline: none;
	background: #EFEFEF;
}

#output {
	// border: 5px solid #444;
	border-left-width: 10px;
	overflow: hidden;
	padding-bottom: 35px;
}

#output iframe {
	width: 100%; height: 100%;
	border: 0;
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
  width: 100vw;
  height: 100%;
  padding: 0;
}
.modal-content {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0; 
  border-radius: 0;
  box-shadow: none;
  width: 100vw;
}
.modal-header {
	padding: 8px;
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
  line-height: 30px;
}
.modal-body {
  position: absolute;
  top: 50px;
  bottom: 60px;
  width: 100%;
  font-weight: 300;
  overflow: auto;
	  th{
		  text-align: center;
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
