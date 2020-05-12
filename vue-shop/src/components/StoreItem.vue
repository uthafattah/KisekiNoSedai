<template>
	<v-card outlined :loading="loading">
		<v-list-item three-line>
			<v-list-item-content>
				<div class="mb-4 ml-n4 spacer" no-gutters>
					<v-btn text dark small>
						<v-avatar tile size="24">
							<v-icon color="grey" v-if="store.status_store == 'Official Store'">mdi-sticker-check</v-icon>
							<v-icon color="grey" v-else-if="store.status_store == 'Starred Store'">mdi-star-circle</v-icon>
							<v-icon color="grey" v-else-if="store.status_store == 'Verified Store'">mdi-shield-check</v-icon>
							<v-icon color="grey" v-else>mdi-storefront</v-icon>
						</v-avatar>
						<div style="margin-left:0.5em" class="grey--text"><strong>{{store.status_store}}</strong></div>
					</v-btn> 
				</div>
				<v-list-item-title class="body-1 mb-1 font-weight-black">{{store.name}}</v-list-item-title>
			</v-list-item-content>
			<v-list-item-avatar size="50">
				<v-img :src="getImage(store.logo)" aspect-ratio="1" rounded />
			</v-list-item-avatar>
		</v-list-item>
		<v-card-actions class="mt-n4">
			<v-btn block small outlined rounded color="primary" :to="toStore(store.id)">See Store Detail</v-btn>
		</v-card-actions>
	</v-card>
</template>

<script>
	import { mapActions } from 'vuex'
	export default {
		name: 'StoreItem',
		props: ['store'],
		data: () => ({
			loading: false,
		}),
		methods : {
			...mapActions({
				setAlert: 'alert/set'
			}),
			toStore(id) {
				return "/stores/" + id
			},
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
		}
	}
</script>