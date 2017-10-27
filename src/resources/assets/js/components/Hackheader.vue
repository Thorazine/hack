<template>
	<div class="header">
		<slot></slot>
	</div>
</template>

<script>
	export default {
		data: function() {
			return {

			};
		},
    	props: [

    	],
    	mounted: function() {
    		axios.get('https://www.kro-ncrv.nl/voorwiesteekjijeenkaarsjeop/candlescount').then(() => {
    			alert('okido');
    		}).catch((error) => {
    			alert('nope');
    		});
	    }
    }
</script>
