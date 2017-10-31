<template>
	<div class="hackmenu">
		<slot name="hackmenu-header"></slot>

		<ul class="hackmenu-items">
			<li class="hackmenu-item" v-for="(item, index) in menuItems" :class="{active:item.active}" v-on:click="toggleHackMenu(index)">
				<a v-if="item.route" :href="item.route"><i class="fa" :class="item.icon"></i> {{ item.label }}</a>
				<span v-else><i class="fa" :class="item.icon"></i> {{ item.label }}</span>
				<transition name="slidefade">
					<ul class="hackmenu-children" v-if="(item.children && hackmenuOpen.indexOf(index) >= 0) || (item.children && item.active)">
						<li class="hackmenu-child" :class="{active:child.active}" v-for="child in item.children">
							<a :href="child.route">{{ child.label }}</a>
						</li>
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
				menuItems: [],
			};
		},
		props: [
			'items',
		],
		methods: {
			toggleHackMenu(value) {
				if(this.hackmenuOpen.indexOf(value) >= 0) {
					var index = this.hackmenuOpen.indexOf(value);
					this.hackmenuOpen.splice(index, 1);
				}
				else {
					this.hackmenuOpen.push(value);
				}
				console.log(this.hackmenuOpen);
			}
    	},
	    mounted: function() {
	    	this.menuItems = JSON.parse(this.items);

	    	// see which one is active and
	    }
    }

</script>
