<template>
	<transition name="fade">
		<div class="alert alert-dismissible fade show" :class="'alert-'+type" v-if="messages.length">
			<button type="button" class="close" v-on:click="close()"><span aria-hidden="true">&times;</span></button>
			<ul>
				<li v-for="message in messages">
					{{ message }}
				</li>
			</ul>
		</div>
	</transition>
</template>

<script>
	export default {
		data: function() {
			return {
				messages: [],
			};
		},
    	props: [
    		'alerts',
    		'type'
    	],
    	methods: {
    		close: function() {
    	    	this.messages = [];
    	    }
    	},
    	watch: {
    		alerts: function(value) {
    			this.messages = value;
    	    	// setTimeout(() => {
    	    	// 	this.messages = [];
    	    	// }, 3000);
    	    }
    	}
    }

</script>
