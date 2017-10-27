<template>
	<div class="footer">
		<slot class="footer-navigation">

		</slot>
		<div class="footer-information">
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
