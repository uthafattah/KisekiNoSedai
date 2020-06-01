<template>
	<v-row>
		<v-col cols="8" sm="8">
			<v-card class="mt-3" outlined>
				<v-card-text class="font-weight-black">
					Checkout
				</v-card-text>
				<v-divider class="mx-4" />
				<v-card outlined class="mx-4 my-4">
					<v-list-item three-line>
						<v-list-item-content>
							<div class="mb-4 ml-n4 spacer" no-gutters>
								<v-btn text dark>
									<v-avatar tile size="24">
										<v-icon color="grey">mdi-map-marker</v-icon>
									</v-avatar>
									<div style="margin-left:0.5em" class="grey--text"><strong>Shipping Address</strong></div>
								</v-btn> 
							</div>
							<v-list-item-title class="subtitle-1 mb-1"><span class="font-weight-black">{{user.name}}</span> (Home)</v-list-item-title>
							<v-row class="mt-n2">
								<v-col cols="8">
									<v-list-item-subtitle>{{user.phone}}</v-list-item-subtitle>
									<v-list-item-subtitle>
										{{user.address}}
									</v-list-item-subtitle>
								</v-col>
								<v-col cols="4">
									<v-btn outlined color="grey" block to="/settings">
										<v-icon dark left>mdi-square-edit-outline</v-icon>Change Address
									</v-btn>
								</v-col>
							</v-row>
						</v-list-item-content>
					</v-list-item>
				</v-card>
				<v-card outlined class="mx-4 my-4">
					<v-list-item three-line>
						<v-list-item-content>
							<div class="mb-4 ml-n4 spacer" no-gutters>
								<v-btn text dark>
									<v-avatar tile size="24">
										<v-icon color="grey">mdi-truck</v-icon>
									</v-avatar>
									<div style="margin-left:0.5em" class="grey--text"><strong>Shipping Courier</strong></div>
								</v-btn> 
							</div>
							<v-row class="mt-n2" v-for="(order, index) in checked" :key="index" link>
								<v-col cols="2" class="mt-n2">
									<v-list-item-avatar tile size="80">
										<v-img :src="getImage(order.photo)"></v-img>
									</v-list-item-avatar>
								</v-col>
								<v-col cols="10" class="ml-n4">
									<v-list-item-content>
										<v-list-item-subtitle>
											<span class="success--text font-weight-bold mr-2">{{order.store_name}}</span>
										</v-list-item-subtitle>
											<v-list-item-title class="title font-weight-bold">{{order.merchandise_name}}</v-list-item-title>
										<v-list-item class="ml-n4">
											<span class="caption grey--text">Harga</span>
											<span class="caption font-weight-bold warning--text" style="margin-left:0.5em">{{order.price | currency}}</span>
											<v-divider class="mx-4 my-3" inset vertical />
											<span class="caption grey--text">Berat</span>
											<span class="caption font-weight-bold primary--text" style="margin-left:0.5em">1200 gr</span>
											<v-divider class="mx-4 my-3" inset vertical />
											<span class="caption grey--text">Jumlah</span>
											<span class="caption font-weight-bold primary--text" style="margin-left:0.5em">{{order.quantity}}</span>
										</v-list-item>
									</v-list-item-content>
								</v-col>
								<!--v-col cols="3">
									<v-select outlined dense :items="sorting" label="Courier"></v-select>
								</v-col-->
								<v-divider class="mb-2 mt-n2 mx-4" v-if="index != checked.length-1"/>
							</v-row>
						</v-list-item-content>
					</v-list-item>
				</v-card>
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
						<!--v-col cols="6" sm="6">
							Total Ongkos Kirim
						</v-col>
						<v-col cols="6" sm="6" class="text-right font-weight-black">
							{{ongkir | currency}}
						</v-col-->
					</v-row>
					<div class="caption grey--text">Dengan ini, saya menyetujui <span class="font-weight-black">syarat dan ketentuan yang berlaku</span></div>
				</v-card-text>
				<!--v-divider class="mx-4" />
				<v-card-text>
					<v-row>
						<v-col cols="6" sm="6">
							Total Harga
						</v-col>
						<v-col cols="6" sm="6" class="text-right font-weight-black">
							{{payment | currency}}
						</v-col>
					</v-row>
				</v-card-text-->
				<v-card-actions class="mt-n4 mx-1">
					<v-btn color="light-blue darken-1" block class="title white--text" @click="process" >Pay</v-btn>
				</v-card-actions>
				<v-divider class="mx-4 my-4" />
				<v-text-field type="text" class="shrink justify-center mx-4" v-model="code" label="Promo Code"/>
				<v-card-actions class="mx-1">
					<v-btn outlined color="light-blue darken-1" block class="title white--text" @click="checkCode">
						<v-icon dark left>mdi-ticket-percent</v-icon>Use Promo
					</v-btn>
				</v-card-actions>
			</v-card>
			<v-card class="mt-3" outlined v-if="promo.promo_code">
				<v-card-text class="font-weight-black">
					<v-row class="my-n2">
						<v-col cols="10">
							<span>Promo Digunakan</span>
						</v-col>
						<v-col cols="2">
							<v-btn icon small @click="clearPromo" class="mr-1 text-right"><v-icon large>mdi-close-circle-outline</v-icon></v-btn>
						</v-col>
					</v-row>
				</v-card-text>
				<v-divider class="mx-4" />
				<v-card-text>
					<v-row>
						<v-col cols="6" sm="6">
							Total Potensi Promo
						</v-col>
						<v-col cols="6" sm="6" class="text-right font-weight-black">
							{{ongkir | currency}}
						</v-col>
						<v-col cols="12" sm="12">
							<b>{{promo.name}}</b>
							{{promo.description}}
						</v-col>
					</v-row>
				</v-card-text>
			</v-card>
		</v-col>
	</v-row>
</template>
<script>
	import { mapActions, mapGetters } from 'vuex'
	export default {
		data: () => ({
			cart: [],
			code: '',
			promo: {},
			//ongkir: 10000
			//sorting: ['Larashop Courier', 'JNE', 'Tiki', 'Si Cepat', 'GoJek', 'Grab'],
		}),
		components: {

		},
		created() {
			console.log(this.checked)
		},
		methods : {
			...mapActions({
				setAlert: 'alert/set',
			}),
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
			checkCode() {
				if(this.code) {
					this.axios.get('http://localhost:8000/api/promo/check_promo/' + this.code)
					.then((res) => {
						this.promo = res.data.promo
						this.setAlert({status: true, color: 'success', text: 'Promo Code is valid!'})
					})
					.catch((err) => {
						console.log(err)
						this.setAlert({status: true, color: 'error', text: 'Promo Code is invalid!'})
						this.promo = {}
					})
				}
				else this.$router.push('/promos');
			},
			clearPromo () {
				this.promo = {}
				this.code = ''
			},
			process() {
				this.axios.post('http://localhost:8000/api/order', { total_price: this.total, checked: this.checked })
				.then((res) => {
					console.log(res.data.order)
					console.log(res.data.order_merchandise)
					this.setAlert({status: true, color: 'success', text: 'Success Ordering Item!'})
					this.$router.push('/orders');
				})
				.catch((err) => {
					console.log(err)
					this.setAlert({status: true, color: 'error', text: 'Failed Processing Order!'})
				})
			}
		},
		computed: {
			...mapGetters({
				user: 'auth/getData',
				checked: 'cart/getChecked',
				total: 'cart/getCheckedTotal',
			}),
			/*payment() {
				return this.total + this.ongkir
			}*/
		}
	}
</script>
<style scoped></style>