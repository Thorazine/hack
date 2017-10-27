<template>
	<div class="footer">
		<div class="footer-navigation">
			<slot></slot>
		</div>
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
