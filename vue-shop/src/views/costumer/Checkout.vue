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
							<v-list-item-title class="subtitle-1 mb-1">Penjual <span class="font-weight-black">Jannah Gate</span></v-list-item-title>
							<v-row class="mt-n2">
								<v-col cols="2">
									<v-list-item-avatar tile size="100">
										<v-img src="https://cdn.vuetifyjs.com/images/cards/foster.jpg"></v-img>
									</v-list-item-avatar>
								</v-col>
								<v-col cols="6">
									<v-list-item>
										<v-list-item-content>
											<v-list-item-title class="mb-1 font-weight-black">Bundle Package WD Green SSD 240GB + WD Blue PC 1TB HDD/ Hardisk/ Hard</v-list-item-title>
											<v-list-item-subtitle class="title font-weight-bold warning--text">Rp. 1.600.000</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
									<v-list-item>
										<span class="caption grey--text">Berat</span>
										<span class="caption font-weight-bold primary--text" style="margin-left:0.3em">1200 gr</span>
										<v-divider class="mx-4 my-2" inset vertical />
										<span class="caption grey--text">Jumlah</span>
										<span class="caption font-weight-bold primary--text" style="margin-left:0.3em">2</span>
									</v-list-item>
								</v-col>
								<v-col cols="4">
									<v-select outlined dense :items="sorting" label="Courier"></v-select>
								</v-col>
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
						<v-col cols="6" sm="6">
							Total Ongkos Kirim
						</v-col>
						<v-col cols="6" sm="6" class="text-right font-weight-black">
							{{total | currency}}
						</v-col>
					</v-row>
					<div class="caption grey--text">Dengan ini, saya menyetujui <span class="font-weight-black">syarat dan ketentuan yang berlaku</span></div>
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
					<v-btn color="light-blue darken-1" block class="title white--text">Pay</v-btn>
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
	import { mapActions, mapGetters } from 'vuex'
	export default {
		data: () => ({
			qty: 1,
			total: 0,
			cart: [],
			sorting: ['Larashop Courier', 'JNE', 'Tiki', 'Si Cepat', 'GoJek', 'Grab'],
		}),
		components: {

		},
		created() {
			
		},
		methods : {
			...mapActions({

			}),
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
		},
		computed: {
			...mapGetters({
				user: 'auth/getData',
			}),
		}
	}
</script>
<style scoped></style>