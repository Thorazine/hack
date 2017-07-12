var commaSeperated = {

	instances: {},

	init: function(id) {
		commaSeperated.instances[id] = $(id);

		$(commaSeperated.instances[id]).find('.input-add').click(function(event) {
			commaSeperated.add(id);
		});

		commaSeperated.bind(id);
	},

	add: function(id) {
		var html = '<div class="input-group">'
					+'<input type="text" class="form-control input-value" value="" placeholder="">'
					+'<span class="input-group-btn">'
						+'<button class="btn btn-danger input-delete" type="button">'
							+'<i class="fa fa-times"></i>'
						+'</button>'
					+'</span>'
				+'</div>';

		$(commaSeperated.instances[id]).find('.input-block').append(html);

		commaSeperated.bind(id);
	},

	bind: function(id) {
		$(commaSeperated.instances[id]).find('.input-delete').unbind('click').click(function(event) {
			$(this).closest('.input-group').remove();
			commaSeperated.updateValue(id);
		});

		$(commaSeperated.instances[id]).find('.input-value').unbind('blur').blur(function(event) {
			commaSeperated.updateValue(id);
		});
	},

	updateValue: function(id) {
		var values = [];
		$(commaSeperated.instances[id]).find('.input-value').each(function() {
			if($(this).val()) {
				values.push($(this).val());
			}
		});

		$(commaSeperated.instances[id]).find('.input').val(values.join());
	},

};

