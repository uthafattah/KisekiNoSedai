<template>
	<div>
		<v-card outlined>
			<v-list-item three-line>
				<v-list-item-content>
					<div class="mb-4 ml-n4 spacer" no-gutters>
						<v-btn text dark>
							<v-avatar tile size="24">
								<v-icon color="grey" v-if="store.status_store == 'Official Store'">mdi-sticker-check</v-icon>
								<v-icon color="grey" v-else-if="store.status_store == 'Starred Store'">mdi-star-circle</v-icon>
								<v-icon color="grey" v-else-if="store.status_store == 'Verified Store'">mdi-shield-check</v-icon>
								<v-icon color="grey" v-else>mdi-storefront</v-icon>
							</v-avatar>
							<div style="margin-left:0.5em" class="grey--text"><strong>{{store.status_store}}</strong></div>
						</v-btn> 
					</div>
					<v-list-item-title class="display-1 mb-1 font-weight-black">{{store.name}}</v-list-item-title>
					<v-list-item-subtitle>{{store.description}}</v-list-item-subtitle>
				</v-list-item-content>

				<v-list-item-avatar size="100">
					<v-img :src="getImage(store.logo)" aspect-ratio="1" rounded />
				</v-list-item-avatar>
			</v-list-item>

			<v-card-actions>
				<v-spacer />
				<v-btn :outlined="outlined" :color="follow_color" @click="follow" @mouseover="mouseOver" @mouseleave="mouseLeave">{{messages}}</v-btn>
				<v-btn outlined color="secondary" to="/messages">Message Store</v-btn>
			</v-card-actions>
			<v-divider class="mt-4 mx-4" />
			<v-row class="mx-4 mb-n6">
				<v-col cols="9">
					<v-text-field outlined dense append-icon="mdi-magnify" label="Search..." hide-details></v-text-field>
				</v-col>
				<v-col cols="3">
					<v-select outlined dense :items="sorting" label="Sort By"></v-select>
				</v-col>
			</v-row>
		</v-card>
		<v-row>
			<v-col cols="6" sm="3" v-for="(merchandise) in merchandises" :key="merchandise.id" link :to="merchandise.action">
				<MerchandiseItem :merchandise="merchandise" />
			</v-col>
		</v-row>
	</div>
</template>
<script>
	import { mapActions, mapGetters } from 'vuex'
	export default {
		data: () => ({
			outlined: true,
			messages: 'Follow',
			follow_color: 'success',
			wishlist_color: 'pink lighten-5',
			unfollow : false,
			sorting: ['Highest Rating', 'Highest Price', 'Lowest Price', 'Most Reviews', 'Most Purchases', 'Most Viewed'],
			merchandises: [],
			store: {}
		}),
		components: {
			MerchandiseItem: () => import(/* webpackChunkName: "merchandise-item" */ '@/components/MerchandiseItem.vue')
		},
		methods: {
			...mapActions({
				setAlert: 'alert/set'
			}),
			follow() {
				if(this.messages === 'Follow') {
					this.messages = 'Following'
					this.outlined = false
					this.unfollow = true
					this.setAlert({status: true, color: 'success', text: 'You are Now Following this Store'})
				} else if (this.messages === 'Unfollow') {
					this.messages = 'Follow'
					this.follow_color = 'success'
					this.outlined = true
					this.unfollow = false
					this.setAlert({status: true, color: 'error', text: 'You are Unfollowing this Store'})
				}
			},
			mouseOver: function() {
				if(this.unfollow) {
					this.messages = 'Unfollow'
					this.follow_color = 'error'
				}
			},
			mouseLeave: function() {
				if(this.unfollow) {
					this.messages = 'Following'
					this.follow_color = 'success'
					this.outlined = false
				}
			},
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
		},
		computed: {
			...mapGetters({

			}),
		},
		created(){
			this.axios.get('http://localhost:8000/api/store/search/' + this.$route.params.id)
			.then((res) => this.store = res.data.store)
			.catch((err) => console.log(err.response))

			this.axios.get('http://localhost:8000/api/merchandise/store_merchandise/' + this.$route.params.id)
			.then((res) => this.merchandises = res.data.merchandise)
			.catch((err) => console.log(err.response))
		},
	}
</script>
<style scoped>
	.btnCustom:hover {
		background-color: #FF5252 !important;
	}
</style>