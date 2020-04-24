<template>
	<div>
		<v-card outlined>
			<v-list-item three-line>
				<v-list-item-content>
					<div class="mb-4 ml-n4 spacer" no-gutters>
						<v-btn text dark>
							<v-avatar tile size="24">
								<v-icon color="grey">mdi-sticker-check</v-icon>
							</v-avatar>
							<div style="margin-left:0.5em" class="grey--text"><strong>Official Store</strong></div>
						</v-btn> 
					</div>
					<v-list-item-title class="display-1 mb-1 font-weight-black">Jannah Gate</v-list-item-title>
					<v-list-item-subtitle>Menjual Pakaian A, B, C</v-list-item-subtitle>
				</v-list-item-content>

				<v-list-item-avatar tile size="100">
						<v-img src="https://cdn.vuetifyjs.com/images/cards/foster.jpg"></v-img>
						<!--v-icon>mdi-store</v-icon-->
				</v-list-item-avatar>
			</v-list-item>

			<v-card-actions>
				<v-spacer />
				<v-btn :outlined="outlined" :color="follow_color" @click="follow" @mouseover="mouseOver" @mouseleave="mouseLeave">{{messages}}</v-btn>
				<v-btn outlined color="secondary" to="/messages">Message Store</v-btn>
			</v-card-actions>
			<v-divider class="mt-4 mx-4" />
			<v-row class="mx-4">
				<v-col cols="9">
					<v-text-field append-icon="mdi-magnify" label="Search..." single-line hide-details></v-text-field>
				</v-col>
				<v-col cols="3">
					<v-select :items="sorting" label="Sort By"></v-select>
				</v-col>
			</v-row>
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
							<v-col><b>Rp. {{merchandise.price}}</b></v-col>
							<v-col class="text-right">xxx Terjual</v-col>
						</v-row>
					</v-card-text>
				</v-card>
			</v-col>
		</v-row>
	</div>
</template>
<script>
	export default {
		data: () => ({
			outlined: true,
			messages: 'Follow',
			follow_color: 'success',
			wishlist_color: 'pink lighten-5',
			unfollow : false,
			hover: '',
			sorting: ['Highest Rating', 'Highest Price', 'Lowest Price', 'Most Reviews', 'Most Purchases', 'Most Viewed'],
            merchandises: [],
		}),
		computed: {

		},
		methods: {
			follow() {
				if(this.messages === 'Follow') {
					this.messages = 'Following'
					this.outlined = false
					this.unfollow = true
				} else if (this.messages === 'Unfollow') {
					this.messages = 'Follow'
					this.follow_color = 'success'
					this.outlined = true
					this.unfollow = false
				}
			},
			mouseOver: function() {
				if(this.unfollow) {
					this.messages = 'Unfollow'
					this.follow_color = 'error'
				}
			},
			mouseLeave: function() {
				if(this.unfollow) {
					this.messages = 'Following'
					this.follow_color = 'success'
					this.outlined = false
				}
			},
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
	}
</script>
<style scoped>
	.btnCustom:hover {
		background-color: #FF5252 !important;
	}
</style>