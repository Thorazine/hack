

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
		<?php
			if(@$data['url']) {
				$baseUrl = $data['url'];
			}
			else {
				$baseUrl = Hack::site('domain');
			}
		?>
		if(configType == 'full') {
			return {
				selector: id,
				branding: false,
				relative_urls : false,
				remove_script_host : true,
				document_base_url : "{{ $baseUrl }}",
				image_class_list: [
					{title: 'Left', value: 'left'},
					{title: 'Full', value: 'full'},
					{title: 'Right', value: 'right'}
				],
				plugins: [
				    "advlist lists link image print hr anchor",
				    "searchreplace visualblocks visualchars code fullscreen",
				    "media nonbreaking contextmenu directionality",
				    "paste textcolor colorpicker textpattern imagetools noneditable"
				],
				menubar: "insert edit tools",
				toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
				toolbar2: "link image media | forecolor backcolor | fullscreen",
				media_live_embeds: true,
				media_dimensions: false,
				media_poster: false,
				media_alt_source: false,
				media_url_resolver: function (data, resolve/*, reject*/) {
				    if (youtube_parser(data.url)) {
						var embedHtml = '<div class="iframe youtube"><iframe src="https://www.youtube.com/embed/' + youtube_parser(data.url) +
						'" width="1200"></iframe></div>';
						resolve({html: embedHtml});
				    } else {
						resolve({html: ''});
				    }
				},
				style_formats: [
					{ title: "H1", block: "h1" },
					{ title: "H2", block: "h2" },
					{ title: "Normal", block: "p" },
				],
				content_css: [
					"{{ asset('assets/cms/css/wysiwyg.css') }}",
				]
			};
		}
		else {
			return {
				selector: id,
				branding: false,
				relative_urls : false,
				remove_script_host : true,
				document_base_url : "{{ $baseUrl }}",
				plugins: "fullscreen",
				menubar: "",
				toolbar: "",
				style_formats: [
					{ title: "Normal", inline: "p" },
				],
				toolbar1: "insertfile undo redo | fullscreen",
				content_css: [
					"{{ asset('assets/cms/css/wysiwyg.css') }}",
				]
			}
		}
	}

	function trans(key)
	{
		var language = {
			confirm_delete: "{{ trans('hack::cms.confirm_delete') }}",
		};

		if(typeof language.confirm_delete === 'undefined') {
			return key;
		}

		return language[key];
	}

	function youtube_parser(url)
	{
	    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
	    var match = url.match(regExp);
	    return (match&&match[7].length==11)? match[7] : false;
	}

</script>

@if(env('APP_DEBUG'))
	<script src="//localhost:35729/livereload.js?snipver=1" type="text/javascript"></script>
@endif


{{--
Example wysiwyg fully stacked with examples

return {
	selector: id,
	branding: false,
	relative_urls : false,
	remove_script_host : true,
	document_base_url : "{{ $baseUrl }}",
	plugins: [
	    "advlist lists link image print preview hr anchor",
	    "searchreplace visualblocks visualchars code fullscreen",
	    "media nonbreaking contextmenu directionality",
	    "emoticons template paste textcolor colorpicker textpattern imagetools"
	],
	menubar: "insert edit tools",
	toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
	toolbar2: "link image media | forecolor backcolor",
	// image_advtab: true,
	media_live_embeds: true,
	media_dimensions: false,
	media_poster: false,
	media_alt_source: false,
	style_formats: [
		{ title: "H1", block: "h1" },
		{ title: "H2", block: "h2" },
		// { title: "copy 2", inline: "p", classes: "copy-02" },
		{ title: "Normal", block: "p" },
	    // { title: "Bold text", inline: "strong" },
	    // { title: "Red text", inline: "span", styles: { color: "#ff0000" } },
	    // { title: "Red header", block: "h1", styles: { color: "#ff0000" } },
	    // { title: "Badge", inline: "span", styles: { display: "inline-block", border: "1px solid #2276d2", "border-radius": "5px", padding: "2px 5px", margin: "0 2px", color: "#2276d2" } },
	    // { title: "Table row 1", selector: "tr", classes: "tablerow1" }
	],
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
		"{{ asset('assets/cms/css/wysiwyg.scss') }}",
	]
};
--}}
