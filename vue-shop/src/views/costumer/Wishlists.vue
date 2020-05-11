<template>
	<v-row>
		<v-col cols="3" sm="3">
			<v-card class="mt-3" outlined>
				<v-card-text class="font-weight-black">
					Filter
				</v-card-text>
				<v-divider class="mx-4" />
				<v-card-actions>

				</v-card-actions>
			</v-card>
		</v-col>
		<v-col cols="9" sm="9">
			<v-row>
				<v-col cols="6" sm="4" v-for="(merchandise) in merchandises" :key="merchandise.id" link :to="merchandise.action">
					<MerchandiseItem :merchandise="merchandise" />
				</v-col>
			</v-row>
		</v-col>
	</v-row>
</template>
<script>
	import { mapGetters } from 'vuex'
	export default {
		data: () => ({
			merchandises: [],
		}),
		components: {
			MerchandiseItem: () => import(/* webpackChunkName: "merchandise-item" */ '@/components/MerchandiseItem.vue')
		},
		created() {
			this.axios.get('http://localhost:8000/api/wishlist/user_wishlist/' + this.userId)
				.then((res) => {
					this.merchandises = res.data.wishlist
				})
				.catch((err) => {
					if(err.response.status == 401) {
						localStorage.removeItem('token');
						this.$router.push('/');
					}
					console.log(err)
				})
		},
		computed : {
			...mapGetters({
				userId: 'auth/getId',
			}),
		}
	}
</script>
<style scoped></style>