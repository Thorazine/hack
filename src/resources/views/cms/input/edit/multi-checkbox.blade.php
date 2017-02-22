@section((@$type['position']) ? $type['position'] : 'main')

	<div class="form-group">
		<label class="col-sm-3 control-label">
			{{ $type['label'] }}
		</label>
		<div class="col-sm-9 multi-checkbox">

			<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-{{ $key }}">{{ $type['label'] }}</button>

			<div class="multi-checkbox-list" style="padding-top: 7px; padding-bottom: 7px;">
				@foreach(Builder::getArrayValue($model, $type, $type['values'], $data, $key) as $index => $label)
					@if(in_array($index, $data[$key]))
						<p data-id="{{ $index }}">{{ $label }}</p>
					@endif
				@endforeach
			</div>			

			<div class="modal fade" id="modal-{{ $key }}" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">{{ $type['label'] }}</h4>
						</div>
						<div class="modal-body grid space-10 vspace-10">
							@foreach(Builder::getArrayValue($model, $type, $type['values'], $data, $key) as $index => $label)
								<div class="grid-{{ (array_key_exists('grid', $type)) ? $type['grid'] : 2 }}">	
									<label class="font-normal">
										{!! Form::checkbox(
											$key.'[]', 
											$index, 
											in_array($index, $data[$key]),
											[
												'class' => 'multi-checkbox-input', 
											]
										) !!}
										<span>{{ $label }}</span>
									</label>
								</div>
							@endforeach
							
						</div>
						<div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					    </div>
					</div>
				</div>
			</div>


			
			{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
		</div>
	</div>

	@parent
@stop