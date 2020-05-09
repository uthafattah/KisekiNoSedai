<template>
	<v-row>
		<v-col cols="8" sm="8">
			<v-card class="mt-3" outlined>
				<v-card-text class="font-weight-black">
					Ringkasan Belanja
				</v-card-text>
				<v-divider class="mx-4" />
				<v-row>
					<v-col cols="12" v-for="(cart) in cart" :key="cart.id" link :to="cart.action">
						<CartItem :cart="cart" />
					</v-col>
				</v-row>
				<v-divider class="mt-4 mx-4" />
			</v-card>
		</v-col>
		<v-col cols="4" sm="4">
			<v-card class="mt-3" outlined>
				<v-card-text class="font-weight-black">
					Ringkasan Belanja
				</v-card-text>
				<v-divider class="mx-4" />
				<v-card-text>
					<v-row>
						<v-col cols="6" sm="6">
							Total Harga
						</v-col>
						<v-col cols="6" sm="6" class="text-right font-weight-black">
							{{total | currency}}
						</v-col>
					</v-row>
				</v-card-text>
				<v-card-actions class="mt-n4 mx-1">
					<v-btn color="light-blue darken-1" block class="title white--text" to="/checkout">Order ({{qty}})</v-btn>
				</v-card-actions>
				<v-card-actions class="mx-1">
					<v-btn outlined color="light-blue darken-1" block class="title white--text" to="/promos">
						<v-icon dark left>mdi-ticket-percent</v-icon>Use Promo
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-col>
	</v-row>
</template>
<script>
	import { mapGetters, mapActions } from 'vuex'
	export default {
		data: () => ({

		}),
		components: {
			CartItem: () => import(/* webpackChunkName: "merchandise-item" */ '@/components/CartItem.vue')
		},
		created() {
			this.axios.get('http://localhost:8000/api/cart/user_cart/' + this.userId)
			.then((res) => {
				this.setCart(res.data.cart)
			})
			.catch((err) => {
				if(err.response.status == 401) {
					localStorage.removeItem('token');
					this.$router.push('/');
				}
				console.log(err.response)
			})
		},
		computed: {
			...mapGetters({
				userId: 'auth/getId',
				cart: 'cart/getCart',
				total: 'cart/getTotal',
				qty: 'cart/getQuantity'
			}),
		},
		methods: {
			...mapActions({
				setCart: 'cart/set'
			}),
		}
	}
</script>
<style scoped></style>