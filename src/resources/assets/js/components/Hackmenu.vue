<template>
	<div class="hackmenu">
		<slot name="hackmenu-header"></slot>

		<ul class="hackmenu-items">
			<li class="hackmenu-item" v-for="(item, index) in items" v-on:click="toggleHackMenu()">
				{{ item.title }}
				<transition name="slidefade">
					<ul class="hackmenu-subitems" v-if="true">
						<li class="hackmenu-subitem"></li>
					</ul>
				</transition>
			</li>
		</ul>

		<slot name="hackmenu-footer"></slot>
	</div>
</template>

<script>
	export default {
		data: function() {
			return {
				hackmenuOpen: [],
			};
		},
		props: [
			'items',
		],
		methods: {
			toggleHackMenu(index) {
				hackmenuOpen.push(index);
			}
    	},
	    mounted: function() {
	    	console.dir(this.items)
	    	this.items = JSON.parse(this.items);
	    	console.dir(this.items)
	    }
    }

</script>
