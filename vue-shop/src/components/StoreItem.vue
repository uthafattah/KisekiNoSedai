<template>
	<v-card outlined :loading="loading">
		<v-list-item three-line>
			<v-list-item-content>
				<div class="mb-4 ml-n4 spacer" no-gutters>
					<v-btn text dark small>
						<v-avatar tile size="24">
							<v-icon small color="grey" v-if="store.status_store == 'Official Store'">mdi-sticker-check</v-icon>
							<v-icon small color="grey" v-else-if="store.status_store == 'Starred Store'">mdi-star-circle</v-icon>
							<v-icon small color="grey" v-else-if="store.status_store == 'Verified Store'">mdi-shield-check</v-icon>
							<v-icon small color="grey" v-else>mdi-storefront</v-icon>
						</v-avatar>
						<div style="margin-left:0.5em" class="grey--text caption"><strong>{{store.status_store}}</strong></div>
					</v-btn> 
				</div>
				<v-list-item-title class="title mb-1 font-weight-black">{{store.name}}</v-list-item-title>
			</v-list-item-content>
			<v-list-item-avatar size="50">
				<v-img :src="getImage(store.logo)" aspect-ratio="1" rounded />
			</v-list-item-avatar>
		</v-list-item>
		<v-card-actions class="mt-n4">
			<v-btn block small outlined rounded color="primary" :to="toStore()">See Store Detail</v-btn>
		</v-card-actions>
		<v-card-actions class="mt-n2" v-if="userId">
			<v-btn block small rounded :outlined="outlined" :color="follow_color" @click="follow" @mouseover="mouseOver" @mouseleave="mouseLeave">{{message}}</v-btn>
		</v-card-actions>
	</v-card>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	export default {
		name: 'StoreItem',
		props: ['store'],
		data: () => ({
			loading: false,
			outlined: true,
			message: '',
			follow_color: 'success',
			status: false,
			unfollow : false,
		}),
		created() {
			this.status = this.store.status
			this.outlined = !this.status
			this.message = this.msg
		},
		methods : {
			...mapActions({
				setAlert: 'alert/set',
				removeFollow: 'follow/remove',
			}),
			follow() {
				var id = this.store.store_id ? this.store.store_id : this.store.id
				if(!this.status) {
					this.axios.post('http://localhost:8000/api/follow', { store_id: id })
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
					this.axios.delete('http://localhost:8000/api/follow/' + id)
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
			toStore() {
				var id = this.store.store_id ? this.store.store_id : this.store.id
				return "/stores/" + id
			},
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
		},
		computed: {
			...mapGetters({
				userId: 'auth/getId',
			}),
			msg() {
				return (this.store.status) ? 'Following' : 'Follow'
			},
		},
	}
</script>