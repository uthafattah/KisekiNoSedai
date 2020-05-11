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
	export default {
		data: () => ({
			drawer: null,
			loading: false,
            merchandises: [],
			wishlist_color: 'pink lighten-5',
		}),
		components: {
			MerchandiseItem: () => import(/* webpackChunkName: "merchandise-item" */ '@/components/MerchandiseItem.vue')
		},
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
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
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