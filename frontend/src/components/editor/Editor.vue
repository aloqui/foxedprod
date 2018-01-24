<template>
<section>
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
    <router-link class="nav-item" to="/evaluation"> <a class="nav-link" href="">Save and Submit</a> </router-link>
	<input type="text" v-model="codes.title">
	<button class="btn btn-info" @click="submitCodes">save</button>
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
				js: "",
				submitted:false
			}
		}
	},
    created (){
		// this.getCode();
		// this.submitCodes();

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
                        });   swal("Succesfully created!", {
                        icon: "success",
                        });
                })
		},
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
