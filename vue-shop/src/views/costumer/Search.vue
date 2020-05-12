<template>
	<v-row>
		<v-col cols="12" sm="12">
			<v-card outlined>
				<v-list-item>
					<v-list-item-content>
						You are Searching for : {{search}}
					</v-list-item-content>
				</v-list-item>
			</v-card>
		</v-col>
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
								STORE FOUNDED NOT FOUND
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
								MERCHANDISE FOUNDED NOT FOUND
							</v-list-item-content>
						</v-list-item>
					</v-card>
				</v-col>
			</v-row>
		</v-col>
	</v-row>
</template>
<script>
	import { mapGetters } from 'vuex'
	export default {
		data: () => ({
			
		}),
		components: {
			StoreItem: () => import(/* webpackChunkName: "store-item" */ '@/components/StoreItem.vue'),
			MerchandiseItem: () => import(/* webpackChunkName: "merchandise-item" */ '@/components/MerchandiseItem.vue')
		},
		created(){

		},
		methods: {
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
		},
		computed: {
			...mapGetters({
				merchandises: 'search/getMerchandise',
				stores: 'search/getStore',
				search: 'search/getSearch'
			}),
		}
	}
</script>
<style scoped></style>