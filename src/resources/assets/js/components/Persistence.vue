<template>
	<div class="auth">
		<transition name="fadebottom">
			<div class="auth-location">
				<div class="card border-dark mb-3">
					<div class="card-header">
						<h4 class="card-title">{{ trans('auth.persistence.title') }}</h4>
					</div>
					<div class="card-body text-dark">
						<p class="card-text" v-html="trans('auth.persistence.introduction')"></p>
						<a href="" class="btn btn-dark pull-right">{{ trans('auth.persistence.resend') }}</a>
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

	    }
    }

</script>
