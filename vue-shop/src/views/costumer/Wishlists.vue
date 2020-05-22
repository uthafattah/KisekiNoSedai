<template>
	<v-row>
		<v-col cols="3" sm="3">
			<v-row v-if="stores.length > 0">
				<v-col cols="12" sm="12" v-for="(store) in stores" :key="store.id" link :to="store.action">
					<StoreItem :store="store" />
				</v-col>
			</v-row>
			<v-row v-else>
				<v-col cols="12" sm="12">
					<v-card outlined>
						<v-list-item>
							<v-list-item-content>
								STORE FOLLOWED NOT FOUND
							</v-list-item-content>
						</v-list-item>
					</v-card>
				</v-col>
			</v-row>
		</v-col>
		<v-col cols="9" sm="9">
			<v-row v-if="merchandises.length > 0">
				<v-col cols="6" sm="4" v-for="(merchandise) in merchandises" :key="merchandise.id" link :to="merchandise.action">
					<MerchandiseItem :merchandise="merchandise" />
				</v-col>
			</v-row>
			<v-row v-else>
				<v-col cols="12" sm="12">
					<v-card outlined>
						<v-list-item>
							<v-list-item-content>
								MERCHANDISE WISHLISTED NOT FOUND
							</v-list-item-content>
						</v-list-item>
					</v-card>
				</v-col>
			</v-row>
		</v-col>
	</v-row>
</template>
<script>
	import { mapGetters, mapActions } from 'vuex'
	export default {
		components: {
			StoreItem: () => import(/* webpackChunkName: "store-item" */ '@/components/StoreItem.vue'),
			MerchandiseItem: () => import(/* webpackChunkName: "merchandise-item" */ '@/components/MerchandiseItem.vue')
		},
		created() {
			this.axios.get('http://localhost:8000/api/wishlist')
			.then((res) => {
				this.setWishlist(res.data.wishlist)
			})
			.catch((err) => {
				if(err.response.status == 401) {
					localStorage.removeItem('token');
					this.$router.push('/');
				}
				console.log(err)
			})

			this.axios.get('http://localhost:8000/api/follow')
			.then((res) => {
				this.setFollow(res.data.follow)
			})
			.catch((err) => {
				if(err.response.status == 401) {
					localStorage.removeItem('token');
					this.$router.push('/');
				}
				console.log(err)
			})
		},
		computed: {
			...mapGetters({
				merchandises: 'wishlist/getWishlist',
				stores: 'follow/getFollow',
			}),
		},
		methods: {
			...mapActions({
				setWishlist: 'wishlist/set',
				setFollow: 'follow/set'
			}),
		},
	}
</script>
<style scoped></style>