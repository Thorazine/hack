<template>
	<div class="hackfooter">
		<div class="hackfooter-navigation">
			<slot></slot>
		</div>
		<div class="hackfooter-information">
			<slot name="footer"></slot>
		</div>
	</div>
</template>

<script>
	export default {
		data: function() {
			return {

			};
		},
		methods: {

    	},
	    mounted: function() {

	    }
    }

</script>
