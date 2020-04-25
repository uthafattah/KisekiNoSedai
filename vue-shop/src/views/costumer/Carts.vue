<template>
	<v-row>
		<v-col cols="8" sm="8">
			<v-card class="mt-3">
				<v-card-text class="font-weight-black">
					Ringkasan Belanja
				</v-card-text>
				<v-divider class="mx-4" />
				<v-card flat>
					<v-list-item three-line>
						<v-list-item-avatar tile size="80">
								<v-img src="https://cdn.vuetifyjs.com/images/cards/foster.jpg"></v-img>
								<!--v-icon>mdi-store</v-icon-->
						</v-list-item-avatar>
						<v-list-item-content>
							<v-list-item-title class="title font-weight-bold">Bundle Package WD Green SSD 240GB</v-list-item-title>
							<v-list-item-subtitle class="subtitle-1 font-weight-black warning--text">{{price | currency}}</v-list-item-subtitle>
						</v-list-item-content>
					</v-list-item>

					<v-card-actions class="mt-n12">
						<v-spacer />
						<v-btn icon :color="wishlist_color" @click="wishlist"><v-icon>mdi-heart</v-icon></v-btn>
						<v-btn icon color="grey"><v-icon>mdi-delete</v-icon></v-btn>
						<v-btn icon color="grey" @click="subtractQty"><v-icon>mdi-do-not-disturb</v-icon></v-btn>
						<v-text-field class="shrink justify-center" label="Qty" v-model="qty" style="width: 40px;" />
						<v-btn icon color="green" @click="addQty"><v-icon>mdi-plus-circle</v-icon></v-btn>
					</v-card-actions>
					<v-divider class="mt-4 mx-4" />
				</v-card>
			</v-card>
		</v-col>
		<v-col cols="4" sm="4">
			<v-card class="mt-3">
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
	export default {
		data: () => ({
			drawer: null,
			loading: false,
			wishlist_color: 'pink lighten-5',
			qty: 1,
			price: 1600000,
			total: 0
		}),
        created() {
            this.total = this.price
        },
		methods : {
			addQty() {
				this.qty++
				this.total += this.price
			},
			subtractQty() {
				if(this.qty > 1) {
					this.qty--
					this.total -= this.price
				}
			},
			getImage(image) {
				return "http://localhost:8000/storage/" + image;
			},
			wishlist() {
				if(this.wishlist_color === 'pink lighten-5') {
					this.wishlist_color = 'pink'
				} else if (this.wishlist_color === 'pink') {
					this.wishlist_color = 'pink lighten-5'
				}
			},
		}
	}
</script>
<style scoped></style>