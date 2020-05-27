<template>
	<v-card outlined>
		<v-list-item>
			<v-row>
				<v-col cols="3">
					<v-list-item-avatar size="250">
						<v-img :src="getImage(store.logo)" aspect-ratio="1"/>
					</v-list-item-avatar>
				</v-col>
				<v-col cols="9">
					<v-card flat>
						<v-card-text>
							<v-form ref="form" v-model="valid">
								<v-text-field label="Name" v-model="store.name" :rules="[rules.required, rules.min]" prepend-icon="mdi-account" autocomplete="off" />
								<v-select label="Category" v-model="store.category" :items="categories" :rules="[rules.category]" attach chips  prepend-icon="mdi-apps" multiple  required/>
								<v-textarea type="text" label="Address" v-model="store.address" :rules="[rules.required]" prepend-icon="mdi-map-marker" autocomplete="off" />
								<v-textarea type="text" label="Description" v-model="store.description" :rules="[rules.required]" prepend-icon="mdi-text-box" autocomplete="off" />
							</v-form>
						</v-card-text>
						<v-card-actions class="mr-2">
							<v-spacer />
							<v-btn outlined :color="theme ? 'white' : 'secondary'" @click="clear">Clear</v-btn>
							<v-btn type="submit" :disabled="!valid" @click.prevent="updateStore" outlined color="success" @click="submit">Update Store</v-btn>
						</v-card-actions>
					</v-card>
				</v-col>
			</v-row>
		</v-list-item>
	</v-card>
</template>
<script>
	import { mapActions, mapGetters } from 'vuex'
	export default {
		data: () => ({
			valid: false,
			rules: {
				required: v => !!v || "This Field Required",
				category: v => v.length > 0 || "Category Required",
				min: v => (v && v.length >= 5) || "Minimum 5 Characters Required",
			},
			categories: [],
		}),
		computed: {
			...mapGetters({
				store: 'store/getStore',
			}),
		},
		methods: {
			...mapActions({

			}),
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
			submit() {

			},
			clear() {

			},
			theme() {
				return (this.$vuetify.theme.dark)
			}
		},
		created(){
			this.axios.get('http://localhost:8000/api/category/pluck')
			.then((res) => {
				this.categories = res.data.categories
				console.log(res.data.categories)
			})
			.catch((err) => {
				console.log(err)
			})
		},
	}
</script>
<style scoped>
	.btnCustom:hover {
		background-color: #FF5252 !important;
	}
</style>