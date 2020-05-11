<template>
	<v-card outlined>
		<v-list-item>
			<v-row>
				<v-col cols="4">
					<v-carousel cycle height="400" max-width="500" hide-delimiter-background show-arrows-on-hover>
						<v-carousel-item v-for="(slide, i) in [merchandise.photo]" :key="i">
							<v-sheet color="grey lighten-3" height="100%">
								<v-row class="fill-height" align="center" justify="center">
									<v-img :src="getImage(slide)" aspect-ratio="1"/>
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
											<v-icon color="grey" v-if="merchandise.status_store == 'Official Store'">mdi-sticker-check</v-icon>
											<v-icon color="grey" v-else-if="merchandise.status_store == 'Starred Store'">mdi-star-circle</v-icon>
											<v-icon color="grey" v-else-if="merchandise.status_store == 'Verified Store'">mdi-shield-check</v-icon>
											<v-icon color="grey" v-else>mdi-storefront</v-icon>
										</v-avatar>
										<div style="margin-left:0.5em" class="grey--text"><strong>{{merchandise.status_store}}</strong></div>
									</v-btn> 
								</div>
								<v-list-item-title class="title mb-1 font-weight-black">{{merchandise.name}}</v-list-item-title>
								<v-list-item-subtitle>
									<strong>Sold 1 Product</strong> (100%)
									<v-divider class="mx-4" inset vertical />
									<strong>{{merchandise.view_count}}x</strong> Viewed
								</v-list-item-subtitle>
								<v-divider class="my-4" />
								<v-list-item class="ml-n4">
									<span class="title mb-1 font-weight-black grey--text">Harga</span>
									<span class="headline font-weight-bold warning--text" style="margin-left:1em">{{merchandise.price | currency}}</span>
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
									<span class="caption font-weight-bold error--text" style="margin-left:1em">Tersisa {{merchandise.stock}}, beli segera!</span>
									<v-spacer />
									<v-btn color="primary" @click="addCart" style="margin-left:1em">
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
								{{merchandise.description}}
							</v-card-text>
						</v-card>
					</v-col>
				</v-row>
			</v-tab-item>
		</v-tabs-items>
	</v-card>
</template>
<script>
	import { mapActions } from 'vuex'
	export default {
		data: () => ({
			loading: false,
			tab: null,
			qty: 1,
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
			merchandise: {}
		}),
		created(){
			this.axios.get('http://localhost:8000/api/merchandise/search/' + this.$route.params.id)
			.then((res) => {
				this.merchandise = res.data.merchandise
			})
			.catch((err) => {
				console.log(err)
			})
		},
		methods: {
			...mapActions({
				insertCart: 'cart/insert',
				setAlert: 'alert/set'
			}),
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
			addCart() {
				this.axios.post('http://localhost:8000/api/cart', { id: this.$route.params.id, quantity: this.qty })
				.then((res) => {
					this.insertCart(res.data.cart)
					this.setAlert({status: true, color: 'success', text: 'Success Adding Item to Cart!'})
				})
				.catch((err) => {
					console.log(err)
					this.setAlert({status: true, color: 'error', text: 'Failed Add Item to Cart!'})
				})
			},
			addQty() {
				if(this.qty < this.merchandise.stock) this.qty++
			},
			subtractQty() {
				if(this.qty > 1) this.qty--
			},
		},
	}
</script>
<style scoped>
</style>