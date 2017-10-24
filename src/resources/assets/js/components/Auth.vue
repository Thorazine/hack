<template>
	<div class="auth">
		<transition name="fadebottom">
			<div class="auth-location" v-if="tab == 0">
				<div class="card border-dark mb-3">
					<div class="card-header">
						<h4 class="card-title">{{ trans('auth.header.wait') }}</h4>
					</div>
					<div class="card-body text-dark">
						<p class="card-text">
							Please wait while we retrieve your location.
						</p>
					</div>
				</div>
			</div>
		</transition>
		<transition name="fadebottom">
			<div class="auth-location" v-if="tab == 1">
				<div class="card border-dark mb-3">
					<div class="card-header">
						<h4 class="card-title">{{ trans('auth.header.hello') }}</h4>
					</div>
					<div class="card-body text-dark">
						<p class="card-text">
							We have determined that this is your first time here.
							So to continue we need to get a fix on your location first.
							Please press "next" and give us permission to get your location.
						</p>
						<button type="button" :class="{'disabled btn-busy':busy}" class="btn btn-dark" v-on:click="getLocation">Next</button>
					</div>
				</div>
			</div>
		</transition>
		<transition name="fadebottom">
			<div class="auth-location" v-if="tab == 2">
				<div class="card border-dark mb-3">
					<div class="card-header">
						<h4 class="card-title">{{ trans('auth.header.location') }}</h4>
					</div>
					<div class="card-body text-dark">
						<p class="card-text">
							An exact location could not be found. Please manually select your location.
						</p>
						<div class="auth-map" id="auth-map"></div>
						<div class="input-group auth-search">
							<input type="text" class="form-control" v-model="address">
							<button type="button" class="input-group-addon btn btn-primary" v-on:click="searchLocation">Zoek</button>
							<button type="button" class="input-group-addon btn btn-primary" v-on:click="selectLocation">Next</button>
						</div>
					</div>
				</div>
			</div>
		</transition>
		<transition name="fadebottom">
			<div class="auth-login" v-if="tab == 3">
				<div class="card border-dark mb-3">
					<div class="card-header">
						<h4 class="card-title">{{ trans('auth.header.login') }}</h4>
					</div>
					<div class="card-body text-dark">
						<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						<form action="">
							<Alert :alerts="alerts" :type="alertType"></Alert>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">{{ trans('auth.input.email') }}</label>
								<div class="col-sm-9">
									<input type="email" class="form-control" :class="{'is-invalid':username.error}" :placeholder="trans('auth.input.email')" v-model="username.value">
									<div class="invalid-feedback">
								        {{ username.error }}
								    </div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">{{ trans('auth.input.password') }}</label>
								<div class="col-sm-9">
									<input type="password" class="form-control" :class="{'is-invalid':password.error}" :placeholder="trans('auth.input.password')" v-model="password.value">
									<div class="invalid-feedback">
								        {{ password.error }}
								    </div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-12">
									<button type="button" :class="{'disabled btn-busy':busy}" class="btn btn-dark pull-right" v-on:click="authenticate">
										{{ trans('auth.input.submit') }}
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</transition>
	</div>
</template>

<script>
	import Cookie from 'js-cookie';
	import Alert from './Alert';

	export default {
		data: function() {
			return {
				alerts: [],
				alertType: 'danger',
				tab: -1,
				busy: false,
				map: null,
				marker: null,
				address: null,
				username: {
					name: 'Username',
					value: '',
					error: '',
				},
				password: {
					name: 'Password',
					value: '',
					error: '',
				},
				latitude: {
					name: 'Latitude',
					value: '',
					error: '',
				},
				longitude: {
					name: 'Longitude',
					value: '',
					error: '',
				},
				location: {
					name: 'Location',
					value: '',
					error: '',
				},
			};
		},
		components: {
			Alert
		},
    	methods: {
    		getLocation() {
    			this.busy = true;
    			if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition((position) => {
						this.latitude.value = position.coords.latitude;
						this.longitude.value = position.coords.longitude;
						this.busy = false;
						this.changeTab(3);
						Cookie.set('hack-geo', true, { expires: 365 });
					},
					(error) => {
						this.getLocationByIp()
					});
				}
				else {
					this.getLocationByIp()
				}
    		},
    		getLocationByIp() {
    			axios.get('http://ipinfo.io').then((response) => {
    				if(response.data.loc) {
    					let location = response.data.loc.split(',');
    					this.latitude.value = parseFloat(location[0]);
    					this.longitude.value = parseFloat(location[1]);
    					this.changeTab(2);
    					this.createMap();
    				}
    				else {
    					// found nothing. Put them in Geocenter of NL
    					this.latitude.value = 52.0981094;
    					this.longitude.value = 5.6418097;
    					this.changeTab(2);
    					this.createMap();
    				}
    				this.busy = false;
    			}).catch((error) => {
    				// found nothing. Put them in Geocenter of NL
    				this.latitude.value = 52.0981094;
    				this.longitude.value = 5.6418097;
    				this.changeTab(2);
    				this.createMap();
    				this.busy = false;
    			});
    		},
    		selectLocation() {
    			this.changeTab(3);
    		},
    		changeTab(nr) {
    			this.tab = nr;
    		},
    		createMap() {
    			// Load the map options
			    let mapOptions = {
			        scrollwheel: true,
			        zoomControl: true,
			        mapTypeControl: false,
			        scaleControl: true,
			        disableDefaultUI: true,
			        disableDoubleClickZoom: true,
			        draggable: true,
			        styles: this.mapTheme(),
			        center: {lat: this.latitude.value, lng: this.longitude.value},
                    zoom: 9
			    };

			    // id is not instantly found. So timeout to get it
			    setTimeout(() => {
					this.map = new google.maps.Map(document.getElementById('auth-map'), mapOptions);

					google.maps.event.addListener(this.map, 'click', (event) => {
						this.latitude.value = event.latLng.lat();
						this.longitude.value = event.latLng.lng();
				    	this.setMarker();
					});

					this.setMarker();
				}, 1);
    		},
    		setMarker() {
    			// remove old marker if any
    			if(this.marker) {
			        this.marker.setMap(null);
			    }

			    // create new marker
    			this.marker = new google.maps.Marker({
                    position: new google.maps.LatLng(this.latitude.value,this.longitude.value),
                    map: this.map,
                });

    			// set new marker
                this.marker.setMap(this.map);
    		},
    		searchLocation() {
			    let geocoder = new google.maps.Geocoder();
			    geocoder.geocode({
			        'address': this.address
			    },
			    (results, status) => {
			        if(status == google.maps.GeocoderStatus.OK) {
			            let centerLatLng = [results[0].geometry.location.lat(), results[0].geometry.location.lng()];
			            let addressLatLng = new google.maps.LatLng(centerLatLng[0], centerLatLng[1]);

			            $('#latitude').val(centerLatLng[0]);
						$('#longitude').val(centerLatLng[1]);

			            this.map.setCenter(addressLatLng);

			            this.map.setZoom(Math.round(19-Math.log(100)/Math.LN2));
			            this.latitude.value = centerLatLng[0];
						this.longitude.value = centerLatLng[1];
			            this.setMarker();

			        } else {
			            alert(trans('auth.errors.not_found'));
			        }
			    });

			    google.maps.event.trigger(this.map,'resize');
    		},
    		mapTheme() {
    			return [{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"labels.text","stylers":[{"visibility":"off"}]}];
    		},
    		authenticate() {
    			if(!this.busy) {
    				this.busy = true;
	    			axios.post(BASE_URL+'/hack/api/authenticate', {}).then((response) => {

	    				this.busy = false;
	    			})
	    			.catch((error) => {
	    				this.busy = false;
	    				if(error.response.status == 422) {
							$.each(error.response.data.errors, (index, values) => {
								this[index].error = values[0];
							});
							this.alerts = [error.response.data.message];
							if(error.response.data.errors.latitude) {
								this.alerts.push(error.response.data.errors.latitude[0]);
							}
							if(error.response.data.errors.longitude) {
								this.alerts.push(error.response.data.errors.longitude[0]);
							}
						}
	    			});
	    		}
    		}
    	},
	    mounted: function() {
	    	if(Cookie.get('hack-geo')) {
	    		this.changeTab(0);
	    		this.getLocation();
	    	}
	    	else {
	    		this.changeTab(1);
	    	}
	    }
    }

</script>
