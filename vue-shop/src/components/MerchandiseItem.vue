<template>
	<v-card :loading="loading">
		<v-img width="300px" :src="getImage(merchandise.photo)">
			<v-btn icon large :color="wishlist_color" @click="wishlist"><v-icon>mdi-heart</v-icon></v-btn>
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
			<v-btn block outlined large rounded color="primary" :to="toMerchandise(merchandise.id)">See Merchandise Detail</v-btn>
		</v-card-actions>
	</v-card>
</template>

<script>
	import { mapActions } from 'vuex'
	export default {
		name: 'MerchandiseItem',
		props: ['merchandise'],
		data: () => ({
			loading: false,
			wishlist_color: 'pink lighten-5',
			status: false,
		}),
		methods : {
			...mapActions({
				setAlert: 'alert/set'
			}),
			toMerchandise(id) {
				return "/merchandise/" + id
			},
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
			wishlist() {
				if(!this.status) {
					this.wishlist_color = 'pink'
					this.status = true
					this.setAlert({status: true, color: 'success', text: 'Item Saved to Wishlist!'})
				} else if (this.wishlist_color === 'pink') {
					this.wishlist_color = 'pink lighten-5'
					this.status = false
					this.setAlert({status: true, color: 'error', text: 'Item Removed from Wishlist!'})
				}
			},
		}
	}
</script>