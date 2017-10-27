<template>
	<div class="auth">
		<transition name="fadebottom">
			<div class="auth-location" v-if="tab == 1">
				<div class="card border-dark mb-3">
					<div class="card-header">
						<h4 class="card-title">{{ trans('auth.persistence.title') }}</h4>
					</div>
					<div class="card-body text-dark">
						<p class="card-text" v-html="trans('auth.persistence.introduction')"></p>
						<button type="button" class="btn btn-dark pull-right" v-on:click="resendValidation">{{ trans('auth.persistence.resend') }}</button>
					</div>
				</div>
			</div>
		</transition>
		<transition name="fadebottom">
			<div class="auth-location" v-if="tab == 2">
				<div class="card border-dark mb-3">
					<div class="card-header">
						<h4 class="card-title">{{ trans('auth.persistence.title') }}</h4>
					</div>
					<div class="card-body text-dark">
						<p class="card-text" v-html="trans('auth.persistence.sent')"></p>
					</div>
				</div>
			</div>
		</transition>
	</div>
</template>

<script>
	import Alert from './Alert';

	export default {
		data: function() {
			return {
				tab: 1,
				alerts: [],
				busy: false,
			};
		},
		components: {
			Alert,
		},
    	methods: {
    		nextTab(nr) {
    			this.tab = nr;
    		},
    		resendValidation() {
    			this.busy = true;
    			axios.post(BASE_URL+'/hack/api/authenticate/validate/resend', {}).then((response) => {
    				this.busy = false;
    				if(response.data.url) {
    					window.location.href = response.data.url;
    				}
    				else {
    					this.nextTab(2);
    				}
    			}).catch((error) => {
    				this.busy = false;
    				if(error.response.status == 422) {
						$.each(error.response.data.errors, (index, values) => {
							this[index].error = values[0];
						});
						this.alerts = [error.response.data.message];

						if(error.response.data.errors) {
							if(error.response.data.errors.domain) {
								this.nextTab(1);
							}
						}
					}
    			});
    		}
    	},
	    mounted: function() {

	    }
    }

</script>
