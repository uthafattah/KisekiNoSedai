<template>
	<v-card outlined>
		<v-list-item>
			<v-row>
				<v-col cols="4">
					<v-carousel cycle height="400" max-width="500" hide-delimiter-background show-arrows-on-hover>
						<v-carousel-item v-for="(slide, i) in slides" :key="i">
							<v-sheet :color="colors[i]" height="100%">
								<v-row class="fill-height" align="center" justify="center">
									<div class="title">{{ slide }} Slide</div>
								</v-row>
							</v-sheet>
						</v-carousel-item>
					</v-carousel>
				</v-col>
				<v-col cols="8">
					<v-card flat>
						<v-list-item three-line>
							<v-list-item-content>
								<div class="mb-4 ml-n4 spacer" no-gutters>
									<v-btn text dark>
										<v-avatar tile size="24">
											<v-icon color="grey">mdi-sticker-check</v-icon>
										</v-avatar>
										<div style="margin-left:0.5em" class="grey--text"><strong>Official Store</strong></div>
									</v-btn> 
								</div>
								<v-list-item-title class="title mb-1 font-weight-black">Bundle Package WD Green SSD 240GB + WD Blue PC 1TB HDD/ Hardisk/ Hard</v-list-item-title>
								<v-list-item-subtitle>
									<strong>Terjual 1 Produk</strong> (100%)
									<v-divider class="mx-4" inset vertical />
									<strong>680x</strong> Dilihat
								</v-list-item-subtitle>
								<v-divider class="my-4" />
								<v-list-item class="ml-n4">
									<span class="title mb-1 font-weight-black grey--text">Harga</span>
									<span class="headline font-weight-bold warning--text" style="margin-left:1em">Rp. 1.600.000</span>
								</v-list-item>
								<v-divider class="my-4" />
								<v-list-item class="ml-n4">
									<span class="title mb-1 font-weight-black grey--text">Stock</span>
									<v-btn icon color="grey" @click="subtractQty" style="margin-left:1em">
										<v-icon>mdi-do-not-disturb</v-icon>
									</v-btn>
									<v-text-field class="shrink justify-center" label="Qty" v-model="qty" style="width: 40px;" />
									<v-btn icon color="green" @click="addQty">
										<v-icon>mdi-plus-circle</v-icon>
									</v-btn>
									<span class="caption font-weight-bold error--text" style="margin-left:1em">Tersisa {{stock}}, beli segera!</span>
									<v-spacer />
									<v-btn color="primary" @click="subtractQty" style="margin-left:1em">
										<v-icon left>mdi-cart</v-icon> Add to Cart
									</v-btn>
								</v-list-item>
								<v-divider class="my-4" />
								<v-list-item class="ml-n4">
									<span class="title mb-1 font-weight-black grey--text" style="margin-right:1em">Info produk</span>
									<span class="subtitle">Berat</span>
									<span class="subtitle font-weight-bold primary--text" style="margin-left:0.3em">1200 gr</span>
									<v-divider class="mx-4 my-2" inset vertical />
									<span class="subtitle">Kondisi</span>
									<span class="subtitle font-weight-bold primary--text" style="margin-left:0.3em">Baru</span>
									<v-divider class="mx-4 my-2" inset vertical />
									<span class="subtitle">Ansuransi</span>
									<span class="subtitle font-weight-bold primary--text" style="margin-left:0.3em">Ya</span>
								</v-list-item>
							</v-list-item-content>
						</v-list-item>
					</v-card>
				</v-col>
			</v-row>
		</v-list-item>

		<v-divider class="mx-4" />
		<v-tabs grow v-model="tab" background-color="white" icons-and-text>
			<v-progress-linear :active="loading" :indeterminate="loading" absolute top color="white accent-4"></v-progress-linear>
			<v-tabs-slider></v-tabs-slider>
			<v-tab v-for="(item, index) in tab_header" :key="index" :href="`#tab-${index}`">
				{{item.text}}
				<v-icon>{{item.icon}}</v-icon>
			</v-tab>
		</v-tabs>
		<v-tabs-items v-model="tab">
			<v-tab-item v-for="(item, index) in tab_header" :key="index" :value="`tab-${index}`">
				<v-row class="mx-2">
					<v-col cols="12">
						<v-card flat>
							<v-card-text>
								Deskripsi Bundle Package WD Green SSD 240GB + WD Blue PC 1TB HDD/ Hardisk/ Hard
								<br><br>
								Bundle Package] WD Green SSD 120GB + WD Blue PC 1TB HDD/ HD/ Hardisk/ Harddisk Internal 3.5"
								<br><br>
								WD Green Garansi 3 Tahun
								<br><br>
								Form Factor: 2.5Inch<br>
								Interface: SATA III 6Gb/s<br>
								Ketebalan: 7mm<br>
								Kapasitas: 240GB<br>
								Read Speed: Up to 540Mb/s<br>
								Write Speed: Up to 465MB/s<br>
								<br><br>
								WD Blue HDD Garansi 2 Tahun
								<br><br>
								Interface: SATA 6 GB/s<br>
								Form Factor: 3.5Inch<br>
								Kapasitas: 1TB<br>
								Speed: 7200 RPM<br>
								Cache: 64MB<br>
							</v-card-text>
						</v-card>
					</v-col>
				</v-row>
			</v-tab-item>
		</v-tabs-items>
	</v-card>
</template>
<script>
	export default {
		data: () => ({
			loading: false,
			tab: null,
			qty: 1,
			stock: 5,
			colors: [
				'indigo',
				'warning',
				'pink darken-2',
			],
			slides: [
				'First',
				'Second',
				'Third',
			],
			tab_header: [
				{
					icon: 'mdi-card-text',
					text: 'Description',
				},
				{
					icon: 'mdi-comment-multiple',
					text: 'Review',
				},
			],
		}),
		created(){
			this.axios.get('http://localhost:8000/api/user/' + localStorage.getItem('id'))
			.then((res) => {
				this.profile = res.data.user[0]
			})
			.catch((err) => {
				if(err.response.status == 401) {
					localStorage.removeItem('token');
					localStorage.removeItem('role');
					localStorage.removeItem('id');
					this.$router.push('/');
				}
				console.log(err)
			})
		},
		computed: {
		},
		methods: {
			getImage(image) {
				return "http://localhost:8000/storage/" + image;
			},
			submit() {

			},
			addQty() {
				if(this.qty < this.stock) this.qty++
			},
			subtractQty() {
				if(this.qty > 1) this.qty--
			},
		},
	}
</script>
<style scoped>
</style>