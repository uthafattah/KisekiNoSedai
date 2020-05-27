<template>
	<v-card outlined>
		<v-card-text class="font-weight-black">
			{{order.updated_at}}
		</v-card-text>
		<v-divider class="mx-4" />
		<v-card flat>
			<v-list-item three-line>
				<v-row>
					<v-col cols="6">
						<v-row>
							<v-col cols="12" v-for="(item, index) in order_merchandise" :key="index" link :to="item.action">
								<v-row>
									<v-col cols="2" class="mt-n2">
										<v-list-item-avatar tile size="80">
											<v-img :src="getImage(item.photo)"></v-img>
										</v-list-item-avatar>
									</v-col>
									<v-col cols="10">
										<v-list-item-content>
											<v-list-item-subtitle>
												<span class="success--text font-weight-bold mr-2">{{item.store_name}}</span> <span class="text-uppercase">({{order.invoice_number}})</span>
											</v-list-item-subtitle>
											<v-list-item-title class="title font-weight-bold">{{item.merchandise_name}}</v-list-item-title>
											<v-list-item-subtitle>
												<span class="warning--text mr-4">{{item.price | currency}}</span> <span class="grey--text">{{item.quantity}} Produk</span>
												<v-btn small outlined :color="theme ? 'white' : 'secondary'" style="margin-left:5em" :to="toMerchandise(item.merchandise_id)">Merchandise Details</v-btn>
											</v-list-item-subtitle>
										</v-list-item-content>
									</v-col>
								</v-row>
								<v-divider v-if="index != order_merchandise.length-1"></v-divider>
							</v-col>
						</v-row>
					</v-col>
					<v-divider class="mx-4 my-2" inset vertical></v-divider>
					<v-col cols="2">
						<v-list-item-content>
							<v-list-item-subtitle class="grey--text">Status</v-list-item-subtitle>
							<v-list-item-title class="subtitle-1 font-weight-bold success--text">{{order.status_order}}</v-list-item-title>
						</v-list-item-content>
					</v-col>
					<v-divider class="mx-4 my-2" inset vertical></v-divider>
					<v-col cols="2">
						<v-list-item-content>
							<v-list-item-subtitle class="grey--text">Total Harga Produk</v-list-item-subtitle>
							<v-list-item-title class="subtitle-1 font-weight-bold warning--text">{{totalPrice | currency}}</v-list-item-title>
						</v-list-item-content>
					</v-col>
				</v-row>
			</v-list-item>

			<v-card-actions v-if="isCostumer">
				<v-spacer />
				<v-btn small outlined :color="theme ? 'white' : 'secondary'" to="/checkout">
					<v-icon small left>mdi-eye</v-icon>See Order Details
				</v-btn>
				<v-btn small outlined :color="theme ? 'white' : 'secondary'" to="/messages">
					<v-icon small left>mdi-email</v-icon>Message Store
				</v-btn>
				<v-btn small color="light-blue darken-1" class="white--text" to="/carts">
					<v-icon small left>mdi-cart</v-icon>Buy Again
				</v-btn>
			</v-card-actions>
			<v-card-actions v-if="isStore">
				<v-row class="mt-n4 mb-n6">
					<v-col cols="9">
					</v-col>
					<v-col cols="3">
						<v-select dense outlined :items="status_order" label="Change Order Status to" color="primary" append-icon="mdi-content-save-move" @click:append="moveOrder(status)" v-model='status'/>
					</v-col>
				</v-row>
			</v-card-actions>
		</v-card>
	</v-card>
</template>

<script>
	import { mapActions } from 'vuex'
	export default {
		name: 'OrderItem',
		props: ['order'],
		data: () => ({
			loading: false,
			order_merchandise: [],
			status: '',
			status_order: ['Requested', 'Waiting', 'On Process', 'Shipped', 'Arrived', 'Success', 'Canceled'],
		}),
		created(){
			if(this.$route.path === '/orders') {
				this.axios.get('http://localhost:8000/api/order_merchandise/user_order_merchandise/' + this.order.id)
				.then((res) => {
					this.order_merchandise = res.data.order_merchandise
				})
				.catch((err) => {
					if(err.response.status == 401) {
						localStorage.removeItem('token');
						this.$router.push('/');
					}
					console.log(err.response)
				})
			} else if (this.$route.path === '/my-store/orders') {
				this.axios.get('http://localhost:8000/api/order_merchandise/user_order_merchandise/' + this.order.id)
				.then((res) => {
					this.order_merchandise = res.data.order_merchandise
				})
				.catch((err) => {
					if(err.response.status == 401) {
						localStorage.removeItem('token');
						this.$router.push('/');
					}
					console.log(err.response)
				})
			}
		},
		methods : {
			...mapActions({
				setAlert: 'alert/set',
			}),
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
			moveOrder(status) {
				this.setAlert({status: true, color: 'success', text: 'Order Status Change to ' + status + '!'})
				this.status = ''
			},
			toMerchandise(id) {
				return "/merchandise/" + id
			},
		},
		computed: {
			totalPrice() {
				var total = 0;
				for(var i = 0; i < this.order_merchandise.length; i++) {
					total += this.order_merchandise[i].price * this.order_merchandise[i].quantity
				}
				return total
			},
			isCostumer () {
				return (this.$route.path === '/orders')
			},
			isStore () {
				return (this.$route.path === '/my-store/orders')
			},
			theme() {
				return (this.$vuetify.theme.dark)
			}
		}
	}
</script>