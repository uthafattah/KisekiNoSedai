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
					<v-card :loading="loading">
						<v-img width="300px" :src="getImage(merchandise.photo)">
							<v-btn icon large :color="wishlist_color" @click="wishlist"><v-icon>mdi-heart</v-icon></v-btn>
						</v-img>
						<v-card-title>{{merchandise.name}}</v-card-title>
						<v-card-text>
							<v-row align="center" class="mx-0">
								<v-rating :value="4.5" color="amber" dense half-increments readonly size="14"></v-rating>
								<div class="grey--text ml-4">x.x (xxx)</div>
							</v-row>
							<v-row>
								<v-col><b>{{merchandise.price | currency}}</b></v-col>
								<v-col class="text-right">xxx Terjual</v-col>
							</v-row>
						</v-card-text>
					</v-card>
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
			wishlist_color: 'pink lighten-5',
		}),
		created(){
			if(this.$route.path == '/') {
				this.axios.get('http://localhost:8000/api/category/all')
				.then((response) => {
					this.categories = response.data.category
					console.log(this.categories)
				})
				.catch((error) => {
					let { responses } = error
					console.log(responses)
				})

				this.axios.get('http://localhost:8000/api/merchandise/all')
				.then((response) => {
					this.merchandises = response.data.merchandise
					console.log(this.merchandises)
				})
				.catch((error) => {
					let { responses } = error
					console.log(responses)
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
			wishlist() {
				if(this.wishlist_color === 'pink lighten-5') {
					this.wishlist_color = 'pink'
				} else if (this.wishlist_color === 'pink') {
					this.wishlist_color = 'pink lighten-5'
				}
			},
		}
	}
</script>