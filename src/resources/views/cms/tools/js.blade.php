<script>

	function asset(relativeUrl) {
		return '{{ asset('/') }}'+relativeUrl;
	}


	// all module functions
	function dateStartModule(id, config, returnData) {
		$(id).datetimepicker({
	        format: 'YYYY-MM-DD'
	    });
	}


	// all module functions
	function timeStartModule(id, config, returnData) {
		$(id).datetimepicker({
	        format: 'HH:mm:00'
	    });
	}


	// all module functions
	function timestampStartModule(id, config, returnData) {
		$(id).datetimepicker({
	        format: 'YYYY-MM-DD HH:mm:00'
	    });
	}


	// all module functions
	function wysiwygStartModule(id, config, returnData) {
		tinymce.init(wysiwygConfig(id, config));
	}


	function wysiwygConfig(id, configType) {
		if(configType == 'full') {
			return {
				selector: id,
				branding: false,
				plugins: [
				    "advlist lists link image print preview hr anchor",
				    "searchreplace visualblocks visualchars code fullscreen",
				    "media nonbreaking contextmenu directionality",
				    "emoticons template paste textcolor colorpicker textpattern imagetools"
				],
				menubar: "insert edit view format tools",
				toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
				toolbar2: "print preview media | forecolor backcolor emoticons",
				// image_advtab: true,
				media_live_embeds: true,
				media_dimensions: false,
				media_poster: false,
				media_alt_source: false,
				style_formats: [
					{ title: "H1", inline: "h1" },
					{ title: "H2", inline: "h2" },
					{ title: "copy 2", inline: "p", classes: "copy-02" },
					{ title: "Normal", inline: "p" },
				    // { title: "Bold text", inline: "strong" },
				    // { title: "Red text", inline: "span", styles: { color: "#ff0000" } },
				    // { title: "Red header", block: "h1", styles: { color: "#ff0000" } },
				    // { title: "Badge", inline: "span", styles: { display: "inline-block", border: "1px solid #2276d2", "border-radius": "5px", padding: "2px 5px", margin: "0 2px", color: "#2276d2" } },
				    // { title: "Table row 1", selector: "tr", classes: "tablerow1" }
				],
				toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
				// formats: {
				//     alignleft: { selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img", classes: "left" },
				//     aligncenter: { selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img", classes: "center" },
				//     alignright: { selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img", classes: "right" },
				//     alignfull: { selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img", classes: "full" },
				//     bold: { inline: "span", "classes": "bold" },
				//     italic: { inline: "span", "classes": "italic" },
				//     underline: { inline: "span", "classes": "underline", exact: true },
				//     strikethrough: { inline: "del" },
				//     customformat: { inline: "span", styles: { color: "#00ff00", fontSize: "20px" }, attributes: { title: "My custom format" }, classes: "example1" },
				// },
				content_css: [
					"https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300",
				]
			};
		}
		else {
			return {
				selector: id,
				branding: false,
				plugins: "",
				menubar: "",
				toolbar: "",
				style_formats: [
					{ title: "Normal", inline: "p" },
				],
				toolbar1: "insertfile undo redo",
				content_css: [
					"https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300",
				]
			}
		}
	}

	function trans(key)
	{
		var language = {
			confirm_delete: "{{ trans('cms.confirm_delete') }}",
		};

		if(typeof language.confirm_delete === 'undefined') {
			return key;
		}

		return language.confirm_delete;

	}
</script>

@if(env('APP_DEBUG'))
	<script type="text/javascript">
		document.write('<script src="//localhost:35729/livereload.js?snipver=1" type="text/javascript"><\/script>')
	</script> 
@endif
