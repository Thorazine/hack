var valueLabel = {

	instances: {},

	init: function(id) {
		valueLabel.instances[id] = $(id);

		$(valueLabel.instances[id]).find('.input-add').click(function(event) {
			valueLabel.add(id);
		});

		valueLabel.bind(id);
	},

	add: function(id) {
		var html = '<div class="row">'
						+'<div class="col-sm-6">'
							+'<input type="text" class="form-control input-value" value="" placeholder="Value">'
						+'</div>'
						+'<div class="col-sm-6">'
							+'<div class="input-group">'
								+'<input type="text" class="form-control input-label" value="" placeholder="Label">'
								+'<span class="input-group-btn">'
									+'<button class="btn btn-danger input-delete" type="button">'
										+'<i class="fa fa-times"></i>'
									+'</button>'
								+'</span>'
							+'</div>'
						+'</div>'
					+'</div>';


		$(valueLabel.instances[id]).find('.input-block').append(html);

		valueLabel.bind(id);
	},

	bind: function(id) {
		$(valueLabel.instances[id]).find('.input-delete').unbind('click').click(function(event) {
			$(this).closest('.row').remove();
			valueLabel.updateValue(id);
		});

		$(valueLabel.instances[id]).find('.input-value').unbind('blur').blur(function(event) {
			valueLabel.updateValue(id);
		});

		$(valueLabel.instances[id]).find('.input-label').unbind('blur').blur(function(event) {
			valueLabel.updateValue(id);
		});
	},

	updateValue: function(id) {
		var values = {};
		$(valueLabel.instances[id]).find('.row').each(function() {
			var value = $(this).find('.input-value').val();
			var label = $(this).find('.input-label').val();

			values[value] = label;
		});

		$(valueLabel.instances[id]).find('.input').val(JSON.stringify(values));
	},

};

