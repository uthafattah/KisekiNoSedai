<template>
	<v-card outlined>
		<v-card-title>
			<v-btn text dark large>
				<v-avatar tile size="36">
					<v-icon large class="black--text">mdi-ticket-percent</v-icon>
				</v-avatar>
				<div style="margin-left:0.5em" class="black--text headline"><strong>PROMO LARASHOP</strong></div>
			</v-btn>
		</v-card-title>
		<v-divider class="mx-4" />
		<v-row class="mx-1">
			<v-col cols="12" md="6">
				<v-card shaped>
					<v-img src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg" height="200px"></v-img>
					<v-card-title>
						Promo ABCD
					</v-card-title>
					<v-card-subtitle>
						Potongan harga spesial untuk anda blablabla
					</v-card-subtitle>

					<v-card-actions>
						<v-spacer />
						<v-btn text rounded small color="light-blue darken-1">
							<v-icon small left>mdi-content-copy</v-icon> Copy Code
						</v-btn>
					</v-card-actions>
				</v-card>
			</v-col>
			<v-col cols="12" md="6">
			</v-col>
		</v-row>
	</v-card>
</template>
<script>
	export default {
		data: () => ({
			loading: false,
			tab: null,
		}),
		computed: {
		},
		methods: {
			getImage(image) {
				return "http://localhost:8000/storage/" + image;
			},
			clearSearch () {
				this.search = ''
			},
		},
		created(){
		},
	}
</script>
<style scoped>
	.btnCustom:hover {
		background-color: #FF5252 !important;
	}
</style>