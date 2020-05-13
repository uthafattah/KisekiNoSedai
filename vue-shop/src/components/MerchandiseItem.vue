<template>
	<v-card outlined :loading="loading">
		<v-img width="300px" :src="getImage(merchandise.photo)">
			<v-btn icon large :color="wishlist_color" @click="wishlist" v-if="userId"><v-icon>mdi-heart</v-icon></v-btn>
		</v-img>
		<v-card-title>{{merchandise.name}}</v-card-title>
		<v-card-text>
			<v-row align="center" class="mx-0">
				<v-rating :value="4.5" color="amber" dense half-increments readonly size="14"></v-rating>
				<div class="grey--text ml-4">x.x (xxx)</div>
			</v-row>
			<v-row>
				<v-col><b>{{merchandise.price | currency}}</b></v-col>
				<v-col class="text-right">xxx Terjual</v-col>
			</v-row>
		</v-card-text>
		<v-card-actions class="mt-n4">
			<v-btn block outlined large rounded color="primary" :to="toMerchandise()">See Merchandise Detail</v-btn>
		</v-card-actions>
	</v-card>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	export default {
		name: 'MerchandiseItem',
		props: ['merchandise'],
		data: () => ({
			loading: false,
			wishlist_color: 'pink lighten-5',
			status: false,
		}),
		created() {
			this.status = this.merchandise.status
			this.wishlist_color = this.stat
		},
		methods : {
			...mapActions({
				setAlert: 'alert/set',
				removeWishlist: 'wishlist/remove',
				cartStatus: 'cart/status'
			}),
			toMerchandise() {
				var id = this.merchandise.merchandise_id ? this.merchandise.merchandise_id : this.merchandise.id
				return "/merchandise/" + id
			},
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
			wishlist() {
				var id = this.merchandise.merchandise_id ? this.merchandise.merchandise_id : this.merchandise.id
				if(!this.status) {
					this.axios.post('http://localhost:8000/api/wishlist', { merchandise_id: id })
					.then(res => {
						console.log(res)
						this.cartStatus(id)
						this.setAlert({status: true, color: 'success', text: 'Item Saved to Wishslist!'})
						this.wishlist_color = 'pink'
						this.status = true
					})
					.catch(err => {
						console.log(err.response)
						this.setAlert({status: true, color: 'error', text: 'Failed Saving Item to Wishslist!'})
					})
				} else {
					this.axios.delete('http://localhost:8000/api/wishlist/' + id)
					.then(res => {
						this.removeWishlist(res.data.wishlist)
						this.cartStatus(id)
						this.setAlert({status: true, color: 'warning', text: 'Item Removed from Wishlist!'})
						this.wishlist_color = 'pink lighten-5'
						this.status = false
					})
					.catch(err => {
						console.log(err.response)
						this.setAlert({status: true, color: 'error', text: 'Error Removing Item From Wishlist!'})
					})
				}
			},
		},
		computed: {
			...mapGetters({
				userId: 'auth/getId',
			}),
			stat() {
				return (this.merchandise.status) ? 'pink' : 'pink lighten-5'
			},
		},
	}
</script>