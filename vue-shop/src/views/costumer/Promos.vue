<template>
	<v-card outlined>
		<v-card-title>
			<v-btn text dark large>
				<v-avatar tile size="36">
					<v-icon large :class="theme ? 'white--text' : 'black--text'">mdi-ticket-percent</v-icon>
				</v-avatar>
				<div style="margin-left:0.5em" :class="theme ? 'white--text headline' : 'black--text headline'"><strong>PROMO LARASHOP</strong></div>
			</v-btn>
		</v-card-title>
		<v-divider class="mx-4" />
		<v-row class="mx-1">
			<v-col cols="12" sm="6" v-for="(promo) in promos" :key="promo.id" link :to="promo.action">
				<v-card shaped outlined>
					<v-img src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg" height="200px"></v-img>
					<v-card-title>
						{{promo.name}}
					</v-card-title>
					<v-card-subtitle>
						{{promo.description}}
					</v-card-subtitle>

					<v-card-actions>
						<v-spacer />
						<v-btn text rounded small color="light-blue darken-1" @click="copy(promo.promo_code)">
							<v-icon small left>mdi-content-copy</v-icon> Copy Code
						</v-btn>
					</v-card-actions>
				</v-card>
			</v-col>
			<v-col cols="12" md="6">
			</v-col>
		</v-row>
	</v-card>
</template>
<script>
	export default {
		data: () => ({
			promos: []
		}),
		computed: {
			theme() {
				return (this.$vuetify.theme.dark)
			}
		},
		methods: {
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
			copy(code) {
				code.select()
				document.execCommand('copy')
			}
		},
		created(){
			this.axios.get('http://localhost:8000/api/promo/all')
			.then((res) => this.promos = res.data.promos)
			.catch((err) =>  console.log(err))
		},
	}
</script>
<style scoped>
	.btnCustom:hover {
		background-color: #FF5252 !important;
	}
</style>