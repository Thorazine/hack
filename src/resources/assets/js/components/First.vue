<template>
	<div class="first">
		<Step :steps="steps" :step="1"></Step>

		<transition name="fadebottom">
			<div class="auth-location" v-if="tab == 1">
				<div class="card border-dark mb-3">
					<div class="card-header">
						<h4 class="card-title">{{ trans('first.tab.1.title') }}</h4>
					</div>
					<div class="card-body text-dark">
						<p class="card-text" v-html="trans('first.tab.1.introduction')"></p>
						<button class="btn btn-dark pull-right" v-on:click="nextTab(2)">{{ trans('first.tab.1.next') }}</button>
					</div>
				</div>
			</div>
		</transition>
		<transition name="fadebottom">
			<div class="auth-location" v-if="tab == 2">
				<div class="card border-dark mb-3">
					<div class="card-header">
						<h4 class="card-title">{{ trans('first.tab.2.title') }}</h4>
					</div>
					<div class="card-body text-dark">
						<p class="card-text" v-html="trans('first.tab.2.introduction')"></p>

						<div class="form-group row">
							<div class="col-sm-12">
								<select class="form-control" :class="{'is-invalid':language.error}" v-model="language.value">
									<option :value="iso" v-for="(lang, iso) in trans('first.tab.2.languages')">{{ lang }}</option>
								</select>
								<div class="invalid-feedback">
							        {{ language.error }}
							    </div>
							</div>
						</div>
						<button class="btn btn-dark" v-on:click="nextTab(1)">{{ trans('first.tab.2.previous') }}</button>
						<button class="btn btn-dark pull-right" v-on:click="nextTab(3)">{{ trans('first.tab.2.next') }}</button>
					</div>
				</div>
			</div>
		</transition>
		<transition name="fadebottom">
			<div class="auth-location" v-if="tab == 3">
				<div class="card border-dark mb-3">
					<div class="card-header">
						<h4 class="card-title">{{ trans('first.tab.3.title') }}</h4>
					</div>
					<div class="card-body text-dark">
						<p class="card-text" v-html="trans('first.tab.3.introduction')"></p>

						<div class="form-group row">
							<div class="col-sm-4">
								<select class="form-control" :class="{'is-invalid':protocol.error}" v-model="protocol.value">
									<option value="https://">https://</option>
									<option value="http://">http://</option>
								</select>
								<div class="invalid-feedback">
							        {{ protocol.error }}
							    </div>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" :class="{'is-invalid':domain.error}" v-model="domain.value">
								<div class="invalid-feedback">
							        {{ domain.error }}
							    </div>
							</div>
						</div>

						<button type="button" class="btn btn-dark" v-on:click="nextTab(2)">{{ trans('first.tab.3.previous') }}</button>
						<button type="button" class="btn btn-dark pull-right" v-on:click="nextTab(4)">{{ trans('first.tab.3.next') }}</button>
					</div>
				</div>
			</div>
		</transition>
		<transition name="fadebottom">
			<div class="auth-location" v-if="tab == 4">
				<div class="card border-dark mb-3">
					<div class="card-header">
						<h4 class="card-title">{{ trans('first.tab.4.title') }}</h4>
					</div>
					<div class="card-body text-dark">
						<p class="card-text" v-html="trans('first.tab.4.introduction')"></p>

						<Alert :alerts="alerts" :type="'danger'" :timeout="false"></Alert>

						<form v-on:submit.prevent>
							<div class="form-group row">
								<div class="col-sm-12">
									<input type="email" class="form-control" :class="{'is-invalid':email.error}" :placeholder="trans('first.tab.4.email')" v-model="email.value">
									<div class="invalid-feedback">
								        {{ email.error }}
								    </div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-12">
									<input type="password" class="form-control" :class="{'is-invalid':password.error}" :placeholder="trans('first.tab.4.password')" v-model="password.value">
									<div class="invalid-feedback">
								        {{ password.error }}
								    </div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-12">
									<input type="password" class="form-control" :class="{'is-invalid':password_confirmation.error}" :placeholder="trans('first.tab.4.password_confirmation')" v-model="password_confirmation.value">
									<div class="invalid-feedback">
								        {{ password_confirmation.error }}
								    </div>
								</div>
							</div>

							<button class="btn btn-dark" v-on:click="nextTab(3)">{{ trans('first.tab.4.previous') }}</button>
							<button class="btn btn-dark pull-right" :class="{'disabled btn-busy':busy}" v-on:click="createFirstUser()">{{ trans('first.tab.4.next') }}</button>
						</form>
					</div>
				</div>
			</div>
		</transition>
		<transition name="fadebottom">
			<div class="auth-location" v-if="tab == 5">
				<div class="card border-dark mb-3">
					<div class="card-header">
						<h4 class="card-title">{{ trans('first.tab.5.title') }}</h4>
					</div>
					<div class="card-body text-dark">
						<p class="card-text" v-html="trans('first.tab.5.introduction')"></p>
						<a :href="cmsUrl" class="btn btn-dark pull-right">{{ trans('first.tab.5.next') }}</a>
					</div>
				</div>
			</div>
		</transition>
	</div>
</template>

<script>
	import Cookie from 'js-cookie';
	import Alert from './Alert';
	import Step from './Step';

	export default {
		data: function() {
			return {
				tab: 1,
				alerts: [],
				busy: false,
				cmsUrl: '',
				language: {
					value: 'en',
					error: '',
				},
				protocol: {
					value: window.location.protocol+'//',
					error: '',
				},
				domain: {
					value: '',
					error: '',
				},
				email: {
					value: '',
					error: '',
				},
				password: {
					value: '',
					error: '',
				},
				password_confirmation: {
					value: '',
					error: '',
				},
				steps: [
					{
						title: trans('first.welcome'),
					},
					{
						title: trans('first.language'),
					},
					{
						title: trans('first.domain'),
					},
					{
						title: trans('first.user'),
					},
					{
						title: trans('first.done'),
					},
				],
				step: 0,
			};
		},
		components: {
			Alert,
			Step,
		},
    	methods: {
    		nextTab(nr) {
    			this.alerts = [];
    			this.tab = nr;
    			$('title').html('Hack - '+trans('first.tab.'+nr+'.title'));
    		},
    		createFirstUser() {
    			this.busy = true;
    			axios.post(BASE_URL+'/hack/api/first', {
    				language: this.language.value,
    				protocol: this.protocol.value,
    				domain: this.domain.value,
    				email: this.email.value,
    				password: this.password.value,
    				password_confirmation: this.password_confirmation.value,
    			}).then((response) => {
    				this.busy = false;
    				this.nextTab(5);
    				this.cmsUrl = response.data.url;
    			}).catch((error) => {
    				this.busy = false;
    				if(error.response.status == 422) {
						$.each(error.response.data.errors, (index, values) => {
							this[index].error = values[0];
						});
						this.alerts = [error.response.data.message];

						if(error.response.data.errors) {
							if(error.response.data.errors.domain) {
								this.nextTab(3);
							}
						}
					}
    			});
    		}
    	},
	    mounted: function() {
	    	let url = window.location.href.split('#')[0];
	    	url = url.split('?')[0];
	    	url = url.replace('https://', '');
	    	url = url.replace('http://', '');
	    	if(url.indexOf('/public/hack') !== false) {
	    		url = url.split('/public/hack')[0]+'/public';
	    	}
	    	this.domain.value = url;
	    }
    }

</script>
