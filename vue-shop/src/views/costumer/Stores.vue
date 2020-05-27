<template>
	<div>
		<v-card outlined>
			<v-list-item three-line>
				<v-list-item-content>
					<div class="mb-4 ml-n4 spacer" no-gutters>
						<v-btn text dark>
							<v-avatar tile size="24">
								<v-icon color="grey">{{iconStatusStore}}</v-icon>
							</v-avatar>
							<div style="margin-left:0.5em" class="grey--text"><strong>{{store.status_store}}</strong></div>
						</v-btn> 
					</div>
					<v-list-item-title class="display-1 mb-1 font-weight-black">{{store.name}}</v-list-item-title>
					<v-list-item-subtitle>{{store.description}}</v-list-item-subtitle>
					<v-list-item class="ml-n4">
						<span class="subtitle-2 grey--text">Followers</span>
						<span class="subtitle-2 font-weight-bold warning--text" style="margin-left:0.5em">{{store.followers}}</span>
						<v-divider class="mx-4 my-3" inset vertical />
						<span class="subtitle-2 grey--text">Rating</span>
						<v-rating :value="rating(store.rating)" color="amber" dense half-increments readonly size="20" style="margin-left:1em"/>
						<span class=" ml-2 subtitle-2">({{store.rating}})</span>
					</v-list-item>
				</v-list-item-content>

				<v-list-item-avatar size="100">
					<v-img :src="getImage(store.logo)" aspect-ratio="1" rounded />
				</v-list-item-avatar>
			</v-list-item>

			<v-card-actions class="mr-2">
				<v-spacer />
				<v-btn :outlined="outlined" :color="follow_color" @click="follow" @mouseover="mouseOver" @mouseleave="mouseLeave" v-if="userId">{{message}}</v-btn>
				<v-btn outlined :color="theme ? 'white' : 'secondary'" to="/message" v-if="userId">Message Store</v-btn>
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
			message: '',
			follow_color: 'success',
			status: false,
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
				if(!this.status) {
					this.axios.post('http://localhost:8000/api/follow', { store_id: this.$route.params.id })
					.then(res => {
						console.log(res)
						this.message = 'Following'
						this.outlined = !this.outlined
						this.status = !this.status
						this.unfollow = true
						this.setAlert({status: true, color: 'success', text: 'You are Now Following this Store'})
					})
					.catch(err => {
						console.log(err.response)
						this.setAlert({status: true, color: 'error', text: 'Failed Following this Store!'})
					})
				} else {
					this.axios.delete('http://localhost:8000/api/follow/' + this.$route.params.id)
					.then(res => {
						this.removeFollow(res.data.follow)
						this.message = 'Follow'
						this.outlined = !this.outlined
						this.status = !this.status
						this.follow_color = 'success'
						this.unfollow = false
						this.setAlert({status: true, color: 'error', text: 'You are Unfollowing this Store'})
					})
					.catch(err => {
						console.log(err.response)
						this.setAlert({status: true, color: 'error', text: 'Error Unfollowing this Store!'})
					})
				}
			},
			mouseOver: function() {
				if(this.unfollow) {
					this.message = 'Unfollow'
					this.follow_color = 'error'
				}
			},
			mouseLeave: function() {
				if(this.unfollow) {
					this.message = 'Following'
					this.follow_color = 'success'
					this.outlined = false
				}
			},
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
			rating(rating) {
				return Number(rating)
			},
		},
		computed: {
			...mapGetters({
				userId: 'auth/getId',
			}),
			iconStatusStore() {
				if(this.store.status_store == 'Official Store') return 'mdi-sticker-check'
				else if(this.store.status_store == 'Starred Store') return 'mdi-star-circle'
				else if(this.store.status_store == 'Verified Store') return 'mdi-shield-check'
				else if(this.store.status_store == 'Default') return 'mdi-storefront'
				else return null
			},
			msg() {
				return (this.store.status) ? 'Following' : 'Follow'
			},
			theme() {
				return (this.$vuetify.theme.dark)
			}
		},
		created(){
			this.axios.get('http://localhost:8000/api/store/search/' + this.$route.params.id)
			.then((res) => {
				this.store = res.data.store
				this.status = this.store.status
					this.outlined = !this.status
					this.message = this.msg
			})
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