<template>
	<v-card outlined>
		<v-card-text class="font-weight-black">
			18 Mar 2020
		</v-card-text>
		<v-divider class="mx-4" />
		<v-card flat>
			<v-list-item three-line>
				<v-list-item-avatar tile size="80">
					<v-img src="https://cdn.vuetifyjs.com/images/cards/foster.jpg"></v-img>
					<!--v-icon>mdi-store</v-icon-->
				</v-list-item-avatar>
				<v-list-item-content>
					<v-row>
						<v-col cols="6">
							<v-list-item-subtitle>
								<span class="success--text font-weight-bold mr-2">Jannah Gate</span> <span>(INV/20200318/XX/III/504846623)</span>
							</v-list-item-subtitle>
							<v-list-item-title class="title font-weight-bold">Bundle Package WD Green SSD 240GB</v-list-item-title>
							<v-list-item-subtitle>
								<span class="warning--text mr-4">Rp. 1.600.000</span> <span class="grey--text">1 Produk</span>
							</v-list-item-subtitle>
						</v-col>
						<v-divider class="mx-4" inset vertical></v-divider>
						<v-col cols="2">
							<v-list-item-subtitle class="grey--text">Status</v-list-item-subtitle>
							<v-list-item-title class="subtitle-1 font-weight-bold success--text">Pesanan Selesai</v-list-item-title>
						</v-col>
						<v-divider class="mx-4" inset vertical></v-divider>
						<v-col cols="2">
							<v-list-item-subtitle class="grey--text">Total Harga Produk</v-list-item-subtitle>
							<v-list-item-title class="subtitle-1 font-weight-bold warning--text">Rp. 1.600.000</v-list-item-title>
						</v-col>
					</v-row>
				</v-list-item-content>
			</v-list-item>

			<v-card-actions>
				<v-spacer />
				<v-btn small outlined color="secondary" to="/checkout">
					<v-icon small left>mdi-eye</v-icon>See Order Details</v-btn>
				<v-btn small outlined color="secondary" to="/messages">
					<v-icon small left>mdi-email</v-icon>Message Store</v-btn>
				<v-btn small color="light-blue darken-1" class="white--text" to="/carts">
					<v-icon small left>mdi-cart</v-icon>Buy Again</v-btn>
			</v-card-actions>
		</v-card>
	</v-card>
</template>

<script>
	export default {
		name: 'OrderItem',
		props: ['order'],
		data: () => ({
			loading: false,
		}),
		methods : {
			getImage(image) {
				return "http://localhost:8000/storage/" + image;
			},
		}
	}
</script>