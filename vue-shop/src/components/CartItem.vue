<template>
	<v-card outlined class="mx-4">
		<v-list-item three-line>
			<v-checkbox v-model="checked" class="mt-8" @change="check(cart)"></v-checkbox>
			<v-row>
				<v-col cols="2" class="mt-n2">
					<v-list-item-avatar tile size="80">
						<v-img :src="getImage(cart.photo)"></v-img>
					</v-list-item-avatar>
				</v-col>
				<v-col cols="10" class="ml-n4">
					<v-list-item-content>
						<v-list-item-subtitle>
							<span class="success--text font-weight-bold mr-2">{{cart.store_name}}</span>
						</v-list-item-subtitle>
							<v-list-item-title class="title font-weight-bold">{{cart.merchandise_name}}</v-list-item-title>
						<v-list-item-subtitle>
							<span class="warning--text mr-4">{{cart.price | currency}}</span> <span class="grey--text">Stock {{cart.stock}} Produk</span>
						</v-list-item-subtitle>
					</v-list-item-content>
				</v-col>
			</v-row>
		</v-list-item>

		<v-card-actions class="mt-n12">
			<v-spacer />
			<v-btn small outlined color="secondary" :to="toMerchandise(cart.merchandise_id)">
				Merchandise Details
			</v-btn>
			<v-btn icon :color="wishlist_color" @click="wishlist">
				<v-icon>mdi-heart</v-icon>
			</v-btn>
			<v-btn icon color="grey" @click="deleteCart(cart)">
				<v-icon>mdi-delete</v-icon>
			</v-btn>
			<v-btn icon color="grey" @click="subtractQty(cart)">
				<v-icon>mdi-do-not-disturb</v-icon>
			</v-btn>
			<v-text-field type="text" class="shrink justify-center" label="Qty" v-model="cart.quantity" style="width: 40px;" readonly/>
			<v-btn icon color="green" @click="addQty(cart)">
				<v-icon>mdi-plus-circle</v-icon>
			</v-btn>
		</v-card-actions>
	</v-card>
</template>

<script>
	import { mapActions } from 'vuex'
	export default {
		name: 'CartItem',
		props: ['cart'],
		data: () => ({
			wishlist_color: 'pink lighten-5',
			status: false,
			checked: true,
		}),
		created() {
			this.status = this.cart.status
			this.wishlist_color = (this.cart.status) ? 'pink' : 'pink lighten-5'
		},
		methods : {
			...mapActions({
				updateQty: 'cart/updateQuantity',
				removeCart: 'cart/remove',
				setAlert: 'alert/set',
				wishlistCart: 'cart/wishlist',
				checkCart: 'cart/checkCart',
				uncheckCart: 'cart/uncheckCart',
			}),
			check(cart) {
				if(this.checked) this.checkCart(cart)
				else this.uncheckCart(cart)
			},
			toMerchandise(id) {
				return "/merchandise/" + id
			},
			addQty(cart) {
				this.axios.get('http://localhost:8000/api/cart/add_quantity/' + cart.id)
				.then(res => this.updateQty(res.data.cart))
				.catch(err => console.log(err.response))
			},
			subtractQty(cart) {
				if(cart.quantity > 1) {
					this.axios.get('http://localhost:8000/api/cart/subtract_quantity/' + cart.id)
					.then(res => this.updateQty(res.data.cart))
					.catch(err => console.log(err.response) )
				}
			},
			deleteCart(cart) {
				this.axios.delete('http://localhost:8000/api/cart/' + cart.id)
				.then(res => {
					this.removeCart(res.data.cart)
					this.setAlert({status: true, color: 'success', text: 'Success Deleting Cart!'})
				}).catch(err => {
					console.log(err.response)
					this.setAlert({status: true, color: 'error', text: 'Error Deleting Cart!'})
				})
			},
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
			wishlist() {
				if(!this.status) {
					this.axios.post('http://localhost:8000/api/wishlist', { merchandise_id: this.cart.merchandise_id })
					.then(res => {
						console.log(res)
						this.wishlistCart(this.cart)
						this.setAlert({status: true, color: 'success', text: 'Item Saved to Wishslist!'})
						this.wishlist_color = 'pink'
						this.status = true
					})
					.catch(err => {
						console.log(err.response)
						this.setAlert({status: true, color: 'error', text: 'Failed Saving Item to Wishslist!'})
					})
				} else {
					this.axios.delete('http://localhost:8000/api/wishlist/' + this.cart.merchandise_id)
					.then(res => {
						console.log(res)
						this.wishlistCart(this.cart)
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
	}
</script>