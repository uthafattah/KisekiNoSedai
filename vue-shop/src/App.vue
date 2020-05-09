<template>
	<v-app class="grey lighten-4">
		<Navbar />
		<Alert />
		<v-content>
			<v-container>
				<router-view></router-view>
			</v-container>
		</v-content>
		<v-footer color="light-blue darken-1" app>
			<span class="white--text">Kiseki no Sedai &copy; 2020</span>
		</v-footer>
	</v-app>
</template>

<script>
	export default {
		name: 'App',
		data: () => ({

		}),
		components: {
			Navbar: () => import( /* webpackChunkName: "navbar" */ '@/components/Navbar.vue'),
			Alert: () => import( /* webpackChunkName: "alert" */ '@/components/Alert.vue'),
		},
	};
</script>