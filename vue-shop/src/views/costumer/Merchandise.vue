<template>
	<v-row>
		<v-col cols="3" sm="3">
			<v-card class="mt-3">
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
					<v-card :loading="loading">
						<v-img width="300px" :src="getImage(merchandise.photo)">
							<v-btn icon large color="pink lighten-5">
								<v-btn icon large :color="wishlist_color" @click="wishlist"><v-icon>mdi-heart</v-icon></v-btn>
							</v-btn>
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
		</v-col>
	</v-row>
</template>
<script>
	export default {
		data: () => ({
			drawer: null,
			loading: false,
            merchandises: [],
			wishlist_color: 'pink lighten-5',
		}),
        created(){
            this.axios.get('http://localhost:8000/api/merchandise/all')
            .then((response) => {
                  this.merchandises = response.data.merchandise
                  console.log(this.merchandises)
            })
            .catch((error) => {
                  let { responses } = error
                  console.log(responses)
            })
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
<style scoped></style>