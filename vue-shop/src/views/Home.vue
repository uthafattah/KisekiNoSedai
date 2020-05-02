<template>
	<div>
		<template v-if="isHome">
			<v-carousel cycle height="400" hide-delimiter-background show-arrows-on-hover>
				<v-carousel-item v-for="(slide, i) in slides" :key="i">
					<v-sheet :color="colors[i]" height="100%">
						<v-row class="fill-height" align="center" justify="center">
							<div class="display-3">{{ slide }} Slide</div>
						</v-row>
					</v-sheet>
				</v-carousel-item>
			</v-carousel>
			<v-card class="my-3">
				<v-expansion-panels flat>
					<v-expansion-panel>
						<v-expansion-panel-header>
							<v-row align="center" class="spacer" no-gutters>
								<v-col cols="12" sm="12" md="12">
									<v-btn text dark>
										<v-avatar tile size="36">
											<v-icon class="black--text">mdi-apps</v-icon>
										</v-avatar>
										<div style="margin-left:0.5em" class="black--text"><strong>Categories</strong></div>
									</v-btn>
								</v-col>
							</v-row>
						</v-expansion-panel-header>
						<v-expansion-panel-content>
							<v-row>
								<v-col cols="6" sm="3" v-for="(category) in categories" :key="category.id" link :to="category.action">
									<v-btn text to="#" dark>
										<v-avatar tile size="36">
											<v-img :src="getImage(category.photo)" aspect-ratio="1"></v-img>
										</v-avatar>
										<div style="margin-left:0.5em" class="black--text">{{ category.name }}</div>
									</v-btn>
								</v-col>
							</v-row>
						</v-expansion-panel-content>
					</v-expansion-panel>
				</v-expansion-panels>
			</v-card>
			<v-row>
				<v-col cols="6" sm="3" v-for="(merchandise) in merchandises" :key="merchandise.id" link :to="merchandise.action">
					<MerchandiseItem :merchandise="merchandise" />
				</v-col>
			</v-row>
		</template>
		<router-view></router-view>
	</div>
</template>

<script>
	export default {
		name: 'Home',
		props: {
			source: String,
		},
		components: {
			MerchandiseItem: () => import(/* webpackChunkName: "merchandise-item" */ '@/components/MerchandiseItem.vue')
		},
		data: () => ({
			drawer: null,
			loading: false,
			toggle_exclusive: 2,
			text: 'center',
			snackbar: false,
			toggle_none: null,
			colors: [
				'indigo',
				'warning',
				'pink darken-2',
				'red lighten-1',
				'deep-purple accent-4',
			],
			slides: [
				'First',
				'Second',
				'Third',
				'Fourth',
				'Fifth',
			],
			categories: [],
			merchandises: [],
		}),
		created(){
			if(this.$route.path == '/') {
				this.axios.get('http://localhost:8000/api/category/all')
				.then((res) => {
					this.categories = res.data.data
				})
				.catch((err) => {
					console.log(err)
				})

				this.axios.get('http://localhost:8000/api/merchandise/top/40')
				.then((res) => {
					this.merchandises = res.data.merchandise
				})
				.catch((err) => {
					console.log(err)
				})
			}
		},
		computed: {
			isHome () {
				return (this.$route.path == '/')
			}
		},
		methods : {
			getImage(image) {
				return "http://localhost:8000/storage/" + image;
			},
		}
	}
</script>