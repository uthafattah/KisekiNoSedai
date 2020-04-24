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
	import Navbar from '@/components/Navbar'
	import Alert from '@/components/Alert'
	export default {
		name: 'App',
		data: () => ({

		}),
		components: {
			Navbar,
			Alert
		},
	};
</script>