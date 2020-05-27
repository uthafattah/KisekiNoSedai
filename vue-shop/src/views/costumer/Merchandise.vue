<template>
	<v-card outlined>
		<v-list-item>
			<v-row>
				<v-col cols="4">
					<v-carousel cycle height="400" max-width="500" hide-delimiter-background show-arrows-on-hover>
						<v-carousel-item v-for="(slide, i) in [merchandise.photo]" :key="i">
							<v-sheet :color="theme? 'transparant' : 'white'" height="100%">
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
								<v-list-item class="ml-n4">
									<span class="grey--text">Rating</span>
									<v-rating :value="rating(merchandise.rating)" color="amber" dense half-increments readonly size="20" style="margin-left:1em"/>
									<span class="ml-2">({{merchandise.rating}})</span>
									<v-divider class="mx-4 my-3" inset vertical />
									<span class="grey--text">Sold</span>
									<span class="font-weight-bold primary--text" style="margin-left:0.5em">1</span>
									<span class="grey--text" style="margin-left:0.5em">Product</span>
									<v-divider class="mx-4 my-3" inset vertical />
									<span class="grey--text">Viewed</span>
									<span class="font-weight-bold primary--text" style="margin-left:0.5em">{{merchandise.view_count}} x</span>
								</v-list-item>
								<v-divider class="my-4" />
								<v-list-item class="ml-n4">
									<span class="title mb-1 font-weight-black grey--text">Price</span>
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
									<span class="caption font-weight-bold error--text" style="margin-left:1em">{{merchandise.stock}} items left, buy this item immediately!</span>
									<v-spacer />
									<v-btn color="primary" @click="addCart" style="margin-left:1em">
										<v-icon left>mdi-cart</v-icon> Add to Cart
									</v-btn>
								</v-list-item>
								<v-divider class="my-4" />
								<v-list-item class="ml-n4">
									<span class="title mb-1 font-weight-black grey--text" style="margin-right:1em">Product Info</span>
									<span class="subtitle">Weight</span>
									<span class="subtitle font-weight-bold primary--text" style="margin-left:0.3em">{{merchandise.weight}} gr</span>
									<v-divider class="mx-4 my-2" inset vertical />
									<span class="subtitle">Condition</span>
									<span class="subtitle font-weight-bold primary--text" style="margin-left:0.3em">{{merchandise.condition}}</span>
									<v-divider class="mx-4 my-2" inset vertical />
									<span class="subtitle">Insurance</span>
									<span class="subtitle font-weight-bold primary--text" style="margin-left:0.3em">{{merchandise.insurance}}</span>
								</v-list-item>
							</v-list-item-content>
						</v-list-item>
					</v-card>
				</v-col>
			</v-row>
		</v-list-item>
		<v-divider/>
		<v-list-item three-line>
			<v-row>
				<v-col cols="2" class="mr-n6">
					<v-list-item-avatar size="100">
						<v-img src="http://localhost:8000/storage/logos/no_logo.png" aspect-ratio="1" rounded />
					</v-list-item-avatar>
				</v-col>
				<v-col cols="6" class="ml-n12">
					<v-list-item-content>
						<div class="ml-n4 spacer" no-gutters>
							<v-btn text dark>
								<v-avatar tile size="24">
									<v-icon color="grey">{{iconStatusStore}}</v-icon>
								</v-avatar>
								<div style="margin-left:0.5em" class="grey--text"><strong>{{merchandise.status_store}}</strong></div>
							</v-btn> 
						</div>
						<v-list-item-title class="title font-weight-black">{{merchandise.store_name}}</v-list-item-title>
						<v-list-item class="ml-n4 mt-n2">
							<span class="subtitle-2 grey--text">Followers</span>
							<span class="subtitle-2 font-weight-bold warning--text" style="margin-left:0.5em">{{merchandise.store_followers}}</span>
							<v-divider class="mx-4 my-3" inset vertical />
							<span class="subtitle-2 grey--text">Rating</span>
							<v-rating :value="rating(merchandise.store_rating)" color="amber" dense half-increments readonly size="20" style="margin-left:1em"/>
							<span class=" ml-2 subtitle-2">{{merchandise.store_rating}}</span>
						</v-list-item>
					</v-list-item-content>
				</v-col>
				<v-col cols="2">
					<v-btn large outlined :color="theme ? 'white' : 'secondary'" to="/messages" class="mt-10" v-if="userId">Message Store</v-btn>
				</v-col>
				<v-col cols="2">
					<v-btn large outlined color="success" :to="toStore()" class="mt-10 ml-6" v-if="userId">Store Details</v-btn>
				</v-col>
			</v-row>
		</v-list-item>

		<v-divider/>
		<v-tabs grow v-model="tab" background-color="white" icons-and-text>
			<v-progress-linear :active="loading" :indeterminate="loading" absolute top color="white accent-4"></v-progress-linear>
			<v-tabs-slider :class="{'slider': theme}"></v-tabs-slider>
			<v-tab v-for="(item, index) in tab_header" :key="index" :href="`#tab-${index}`" :class="{'tab': theme}">
				{{item.text}}
				<v-icon>{{item.icon}}</v-icon>
			</v-tab>
		</v-tabs>
		<v-tabs-items v-model="tab">
			<v-tab-item v-for="(item, index) in tab_header" :key="index" :value="`tab-${index}`">
				<v-row class="mx-2">
					<v-col cols="12">
						<v-card flat v-if="index == 0">
							<v-card-text>
								{{merchandise.description}}
							</v-card-text>
						</v-card>
						<v-row v-else>
							<v-col cols="12" v-for="(review) in reviews" :key="review.id">
								<v-card outlined class="mx-4">
									<v-list-item two-line class="mt-n4">
										<v-list-item-avatar tile size="36">
											<v-img :src="getImage(review.user_avatar)"></v-img>
										</v-list-item-avatar>
										<v-list-item-content class="mt-7">
											<v-list-item>
												<span class="ml-n4 title">{{review.user_name}}</span>
												<v-rating :value="rating(review.rating)" color="amber" dense half-increments readonly size="20" style="margin-left:1em"/>
												<span class="mt-1 ml-2 caption">({{review.rating}})</span>
											</v-list-item>
											<v-list-item-subtitle class="subtitle-1 grey--text">
												{{review.comment}}
											</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
								</v-card>
							</v-col>
						</v-row>
					</v-col>
				</v-row>
			</v-tab-item>
		</v-tabs-items>
	</v-card>
</template>
<script>
	import { mapActions, mapGetters } from 'vuex'
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
			merchandise: {},
			reviews: []
		}),
		created(){
			this.axios.get('http://localhost:8000/api/merchandise/search/' + this.$route.params.id)
			.then((res) => {
				this.merchandise = res.data.merchandise
			})
			.catch((err) => {
				console.log(err)
			})

			this.axios.get('http://localhost:8000/api/review/merchandise/' + this.$route.params.id)
			.then((res) => {
				this.reviews = res.data.review
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
			rating(rating) {
				return Number(rating)
			},
			addCart() {
				if(this.userId) {
					this.axios.post('http://localhost:8000/api/cart', { id: this.$route.params.id, quantity: this.qty })
					.then((res) => {
						this.insertCart(res.data.cart)
						this.setAlert({status: true, color: 'success', text: 'Success Adding Item to Cart!'})
					})
					.catch((err) => {
						console.log(err)
						this.setAlert({status: true, color: 'error', text: 'Failed Add Item to Cart!'})
					})
				} else {
					this.setAlert({status: true, color: 'warning', text: 'You Must Login to Adding Item!'})
				}
			},
			addQty() {
				if(this.qty < this.merchandise.stock) this.qty++
			},
			subtractQty() {
				if(this.qty > 1) this.qty--
			},
			toStore() {
				return "/stores/" + this.merchandise.store_id
			},
		},
		computed: {
			...mapGetters({
				userId: 'auth/getId',
			}),
			iconStatusStore() {
				if(this.merchandise.status_store == 'Official Store') return 'mdi-sticker-check'
				else if(this.merchandise.status_store == 'Starred Store') return 'mdi-star-circle'
				else if(this.merchandise.status_store == 'Verified Store') return 'mdi-shield-check'
				else if(this.merchandise.status_store == 'Default') return 'mdi-storefront'
				else return null
			},
			theme() {
				return (this.$vuetify.theme.dark)
			}
		}
	}
</script>
<style scoped>
	.tab {
		color: white;
		background-color: #212121;
	}
	.slider {
		color: white;
	}
</style>