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
	import { mapActions, mapGetters } from 'vuex'
	export default {
		name: 'App',
		data: () => ({

		}),
		components: {
			Navbar: () => import( /* webpackChunkName: "navbar" */ '@/components/Navbar.vue'),
			Alert: () => import( /* webpackChunkName: "alert" */ '@/components/Alert.vue'),
		},
		created() {
			if(this.id == null && localStorage.getItem('token')) this.getLoggedUser()
		},
		methods: {
			...mapActions({
				setAuth: 'auth/set',
				setStore: 'store/set',
				setCart: 'cart/set',
			}),
			getLoggedUser() {
				this.axios.get('http://localhost:8000/api/logged_user')
				.then((res) => {
					this.setAuth(res.data.user)
					this.setStore(res.data.store)
					this.getUserCart(res.data.user.id)
				})
				.catch((err) => {
					console.log(err.response)
				})
			},
			getUserCart(id) {
				this.axios.get('http://localhost:8000/api/cart/user_cart/' + id)
				.then((res) => {
					this.setCart(res.data.cart)
				})
				.catch((err) => {
					console.log(err.response)
				})
			},
			getUserMessage() {

			}
		},
		computed: {
			...mapGetters({

			}),
		}
	};
</script>