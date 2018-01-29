<template>
<section>
	
	<h1>{{codes.title}}</h1>
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
	
  <div v-show="authenticatedUser.id == id">
		<input type="text" v-model="codes.title">
		<button class="btn btn-info" @click="update">save</button>
		<button class="btn btn-danger" @click="deleteCodes">thrash</button>
		<!-- <div v-show="act_id && evaluated">
			<button>resubmit</button>
	</div> -->
	</div>
		<div v-show="authenticatedUser.prof && act_id && !eval">
			<input v-model="score.body" type="number" placeholder="Score">
			<button @click="submitScore">save</button>
	</div>
</div>
    <!-- <router-link class="nav-item" to="/evaluation"> <a class="nav-link" href="">Save and Submit</a> </router-link> -->
	
	<!-- <input type="text" v-model="codes.html"> -->
</section>
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
			user_id:""
		},
		evaluation:{
			evaluated:true
			}
		}
	},
    created (){
		// this.getCode();
		// this.submitCodes();

    },
  
  methods: {
		submitScore() {
          this.$http.post("api/submitScore", this.score).then(response => {
						console.log(response);

								this.$http.put("api/eval/codescore/" + this.$route.params.id, this.evaluation).then(response => {
								console.log(response);
									swal("Succesfully created!", {
										icon: "success"
									});
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
            
        }
  },
    computed: {
        authenticatedUser() {
        return this.$auth.getAuthenticatedUser()
        }
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
			padding-top: 25px;
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
	font-size: 13px;
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
	border: 5px solid #444;
	border-left-width: 10px;
	overflow: hidden;
}

#output iframe {
	width: 100%; height: 100%;
	border: 0;
}

</style>
