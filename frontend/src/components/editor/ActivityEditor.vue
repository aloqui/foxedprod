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
    <!-- <router-link class="nav-item" to="/evaluation"> <a class="nav-link" href="">Save and Submit</a> </router-link> -->
	<div class="editor__footer">

	<input type="text" v-model="codes.title">
	<button class="btn btn-info" @click="submitCodes">Submit</button>
	<button class="btn"  data-toggle="modal" data-target="#exampleModal" @click="getRubric">Rubrics</button>
	</div>
	<!-- <input type="text" v-model="codes.html"> -->
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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
                    <div class="modal-footer">
                        <div class="d-flex justify-content-center align-items-end pr-5">
                            	
                        </div>
                    </div>
                    </div>
                </div>
                </div>
</div>
</template>

<script>
		var x = {};
		import Split from 'split.js'
export default {
	data () {
		return {
			codes: {
				title:"",
				html:"",
				css:"",
				js: "",
				activity_id: JSON.parse(this.$route.params.id),
				submitted: true,
				rubric_set_id:""
			},
			rubric:{},
			totalCol:{}
		}
	},
  methods: {
      getCode (){
          this.$http.get('api/forums/')
          .then(response => {
            //   this.codes = response.body[0]
            //   console.log(response.body[0])
          })
	  },
		submitCodes () {
				// this.codes = x;
					this.codes.html = x.html
					this.codes.css = x.css
					this.codes.js = x.js
					
				  this.$http.post('api/codes/', this.codes)
                .then(response => {
                    console.log(response)
                            swal("Succesfully created!", {
                        icon: "success",
                        });
												this.$router.push(`/${response.body[1]}/codes/${response.body[0].id}`)
                })
		},
		getRubric(){
			this.$http.get(`api/activities/rubric/`+this.$route.params.id)
				.then(response => {
					this.rubric = response.body;
					this.totalCol = response.body.row[0].col
					this.codes.rubric_set_id = response.body.id
					console.log(response.body)
				})
				;
		}
  },
	created(){
      this.getRubric()
 },
  mounted: function() {
		

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
		html_editor.setValue("");
		css_editor.setValue("");
		js_editor.setValue("");




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

* {
}

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
		justify-content: flex-end;
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
}
.code_box textarea {
	resize: none; 
	border: 0;
	padding: 15px;
	font-family: monospace;
	
}
.code_box textarea:focus {
	outline: none;
	background: #EFEFEF;
}

#output {
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
