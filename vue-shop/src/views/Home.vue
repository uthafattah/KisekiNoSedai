<template>
	<div>
		<template>
			<v-carousel cycle height="400" hide-delimiter-background show-arrows-on-hover v-if="isHome && isSearch">
				<v-carousel-item v-for="(slide, i) in slides" :key="i">
					<v-sheet :color="colors[i]" height="100%">
						<v-row class="fill-height" align="center" justify="center">
							<div class="display-3">{{ slide }} Slide</div>
						</v-row>
					</v-sheet>
				</v-carousel-item>
			</v-carousel>
			<v-card class="my-3" outlined v-if="isHome">
				<v-expansion-panels flat>
					<v-expansion-panel>
						<v-expansion-panel-header>
							<v-row align="center" class="spacer" no-gutters>
								<v-col cols="12" sm="12" md="12">
									<v-btn text dark>
										<v-avatar tile size="36">
											<v-icon :class="theme ? 'white--text' : 'black--text'">mdi-apps</v-icon>
										</v-avatar>
										<div style="margin-left:0.5em" :class="theme ? 'white--text' : 'black--text'"><strong>Categories</strong></div>
									</v-btn>
								</v-col>
							</v-row>
						</v-expansion-panel-header>
						<v-expansion-panel-content>
							<v-row>
								<v-col cols="6" sm="3" v-for="(category) in categories" :key="category.id" link :to="category.action">
									<v-btn text @click="searchByCategory(category)" dark>
										<v-avatar tile size="36">
											<v-img :src="getImage(category.photo)" aspect-ratio="1"></v-img>
										</v-avatar>
										<div style="margin-left:0.5em" :class="theme ? 'white--text' : 'black--text'">{{ category.name }}</div>
									</v-btn>
								</v-col>
							</v-row>
						</v-expansion-panel-content>
					</v-expansion-panel>
				</v-expansion-panels>
			</v-card>
			<v-row v-if="isHome && isSearch">
				<v-col cols="6" sm="3" v-for="(merchandise) in merchandises" :key="merchandise.id" link :to="merchandise.action">
					<MerchandiseItem :merchandise="merchandise" />
				</v-col>
			</v-row>
		</template>
		<v-row v-if="isHome && !isSearch">
			<v-col cols="12" sm="12">
				<v-card outlined>
					<v-list-item>
						<v-list-item-content>You are Searching for : {{search}}</v-list-item-content>
						<v-list-item-content>
							<v-btn outlined color="secondary" @click="clearSearch">Clear Search</v-btn>
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
		<router-view></router-view>
	</div>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	export default {
		name: 'Home',
		components: {
			StoreItem: () => import(/* webpackChunkName: "store-item" */ '@/components/StoreItem.vue'),
			MerchandiseItem: () => import(/* webpackChunkName: "merchandise-item" */ '@/components/MerchandiseItem.vue')
		},
		data: () => ({
			colors: ['indigo', 'warning', 'pink darken-2', 'red lighten-1', 'deep-purple accent-4'],
			slides: ['First', 'Second', 'Third', 'Fourth', 'Fifth'],
		}),
		created(){
			if(this.$route.path == '/') {
				this.axios.get('http://localhost:8000/api/category/all')
				.then((res) => this.searchCategory(res.data.categories))
				.catch((err) => console.log(err.response))

				this.axios.get('http://localhost:8000/api/merchandise/top/40')
				.then((res) => this.searchMerchandise(res.data.merchandise))
				.catch((err) => console.log(err.response))
			}
		},
		computed: {
			...mapGetters({
				merchandises: 'search/getMerchandise',
				stores: 'search/getStore',
				categories: 'search/getCategory',
				search: 'search/getSearch'
			}),
			isHome () {
				return (this.$route.path === '/')
			},
			isSearch () {
				return (this.search === '')
			},
			theme() {
				return (this.$vuetify.theme.dark)
			}
		},
		methods : {
			...mapActions({
				searchMerchandise: 'search/searchMerchandise',
				searchCategory: 'search/searchCategory',
				searchStore: 'search/searchStore',
				searchKeyword: 'search/search'
			}),
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
			clearSearch() {
				this.searchKeyword('')
			},
			searchByCategory(category) {
				this.axios.get('http://localhost:8000/api/merchandise_category/find/' + category.id)
				.then((res) => this.searchMerchandise(res.data.merchandise))
				.catch((err) => console.log(err.response))

				this.axios.get('http://localhost:8000/api/store_category/find/' + category.id)
				.then((res) => this.searchStore(res.data.store))
				.catch((err) => console.log(err.response))

				this.searchKeyword('Category ' + category.name)
			},
		}
	}
</script>