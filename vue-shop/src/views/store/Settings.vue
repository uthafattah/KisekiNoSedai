<template>
	<v-card outlined>
		<v-list-item>
			<v-row>
				<v-col cols="3">
					<v-list-item-avatar tile size="250">
						<v-img src="https://cdn.vuetifyjs.com/images/cards/foster.jpg" v-model="avatar"></v-img>
						<!--v-icon>mdi-store</v-icon-->
					</v-list-item-avatar>
				</v-col>
				<v-col cols="9">
					<v-card flat>
						<v-card-text>
							<v-form ref="form" v-model="valid">
								<v-text-field label="Name" v-model="storeField.name" :rules="[rules.required, rules.min]" prepend-icon="mdi-account" autocomplete="off" />
								<v-select label="Category" v-model="storeField.category" :items="category" :rules="[rules.category]" attach chips  prepend-icon="mdi-apps" multiple  required/>
								<v-textarea type="text" label="Address" v-model="storeField.address" :rules="[rules.required]" prepend-icon="mdi-map-marker" autocomplete="off" />
								<v-textarea type="text" label="Description" v-model="storeField.description" :rules="[rules.required]" prepend-icon="mdi-text-box" autocomplete="off" />
							</v-form>
						</v-card-text>
						<v-card-actions class="mr-2">
							<v-spacer />
							<v-btn outlined color="secondary" @click="clearProfile">Clear</v-btn>
							<v-btn type="submit" :disabled="!valid" @click.prevent="updateStore" outlined color="success" @click="submit">Update Store</v-btn>
						</v-card-actions>
					</v-card>
				</v-col>
			</v-row>
		</v-list-item>
	</v-card>
</template>
<script>
	export default {
		data: () => ({
			loading: false,
			valid: false,
			rules: {
				required: v => !!v || "This Field Required",
				category: v => v.length > 0 || "Category Required",
				min: v => v.length >= 5 || "Minimum 5 Characters Required",
			},
			storeField: {
				name: 'Jannah Gate',
				category: ['foo', 'fizz'],
				address: 'Jeruk Purut',
				description: 'Nihonggo Mantappu',
				logo: null
			},
			category: ['foo', 'bar', 'fizz', 'buzz'],
		}),
		computed: {

		},
		methods: {
			getImage(image) {
				return "http://localhost:8000/storage/" + image;
			},
			submit() {

			},
			clear() {
				this.storeField.name = 'Kiseki No Sedai'
				this.storeField.email = 'kiseki-kun@gmail.com'
				this.storeField.address = 'Jeruk Purut'
				this.storeField.description = 'Nihonggo Mantappu'
				this.storeField.logo = null
			},
		},
		created(){
		},
	}
</script>
<style scoped>
	.btnCustom:hover {
		background-color: #FF5252 !important;
	}
</style>