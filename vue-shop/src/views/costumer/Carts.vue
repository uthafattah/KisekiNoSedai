<template>
	<v-row>
		<v-col cols="8" sm="8">
			<v-card class="mt-3">
				<v-card-text class="font-weight-black">
					Ringkasan Belanja
				</v-card-text>
				<v-divider class="mx-4" />
				<v-card-actions>

				</v-card-actions>
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
							Rp. 10.000.000
						</v-col>
					</v-row>
				</v-card-text>
				<v-card-actions class="mt-n4 mx-1">
					<v-btn color="light-blue darken-1" block class="title white--text" to="/checkout">Order</v-btn>
				</v-card-actions>
				<v-card-actions class="mx-1">
					<v-btn outlined color="light-blue darken-1" block class="title white--text" to="/promos">Use Promo</v-btn>
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
		}),
	}
</script>
<style scoped></style>