<template>
	<v-card outlined class="mx-4">
		<v-list-item three-line>
			<v-list-item-avatar tile size="80">
				<v-img :src="getImage(cart.photo)"></v-img>
				<!--v-icon>mdi-store</v-icon-->
			</v-list-item-avatar>
			<v-list-item-content>
				<v-list-item-title class="title font-weight-bold">{{cart.name}}</v-list-item-title>
				<v-list-item-subtitle class="subtitle-1 font-weight-black warning--text">{{cart.price | currency}}</v-list-item-subtitle>
			</v-list-item-content>
		</v-list-item>

		<v-card-actions class="mt-n12">
			<v-spacer />
			<v-btn icon :color="wishlist_color" @click="wishlist">
				<v-icon>mdi-heart</v-icon>
			</v-btn>
			<v-btn icon color="grey">
				<v-icon>mdi-delete</v-icon>
			</v-btn>
			<v-btn icon color="grey" @click="subtractQty">
				<v-icon>mdi-do-not-disturb</v-icon>
			</v-btn>
			<v-text-field class="shrink justify-center" label="Qty" v-model="qty" style="width: 40px;" />
			<v-btn icon color="green" @click="addQty">
				<v-icon>mdi-plus-circle</v-icon>
			</v-btn>
		</v-card-actions>
	</v-card>
</template>

<script>
	export default {
		name: 'CartItem',
		props: ['cart'],
		data: () => ({
			wishlist_color: 'pink lighten-5',
			qty: 1,
			total: 0,
		}),
		methods : {
			getImage(image) {
				return "http://localhost:8000/storage/" + image;
			},
			addQty() {
				this.qty++
				this.total += this.price
			},
			subtractQty() {
				if(this.qty > 1) {
					this.qty--
					this.total -= this.price
				}
			},
			wishlist() {
				if(this.wishlist_color === 'pink lighten-5') {
					this.wishlist_color = 'pink'
				} else if (this.wishlist_color === 'pink') {
					this.wishlist_color = 'pink lighten-5'
				}
			}
		}
	}
</script>