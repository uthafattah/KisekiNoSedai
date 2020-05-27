<template>
	<v-data-table item-key="name" class="elevation-1" :loading="loading" loading-text="Loading... Please wait" :headers="headers" :options.sync="options" :server-items-length="promos.total" :items="promos.data" :footer-props="footerProps">
		<template v-slot:top>
			<v-toolbar flat color="transparent">
				<v-toolbar-title>Promo Management System</v-toolbar-title>
				<v-divider class="mx-4" inset vertical></v-divider>
				<v-spacer></v-spacer>
				<v-dialog v-model="dialog" max-width="800px">
					<template v-slot:activator="{ on }">
						<v-btn color="primary" dark class="mb-2" v-on="on">Add New Promo</v-btn>
					</template>
					<v-card>
						<v-card-title>
							<span class="headline">{{ formTitle }}</span>
						</v-card-title>
						<v-form ref="form" v-model="valid" v-on:submit.stop.prevent="save">
							<v-card-text>
								<v-container>
									<v-row>
										<v-col cols="12" sm="6">
											<v-text-field v-model="editedItem.name" :rules="[rules.required, rules.min]" label="Promo Name" />
										</v-col>
										<v-col cols="12" sm="6">
											<v-text-field v-model="editedItem.promo_code" :rules="[rules.required, rules.min]" label="Promo Code" v-if="editedIndex > 0" />
											<v-text-field v-model="editedItem.promo_code" :success-messages="msg.success" :error-messages="msg.error" :rules="[rules.required, rules.min]" :blur="checkCode" label="Promo Code" v-else/>
										</v-col>
										<v-col cols="12" md="12">
											<v-textarea type="text" :rules="[rules.required]" v-model="editedItem.description" label="Description"></v-textarea>
										</v-col>
									</v-row>
								</v-container>
							</v-card-text>
							<v-card-actions>
								<v-spacer></v-spacer>
								<v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
								<v-btn type="submit" :disabled="!valid" color="blue darken-1" text @click.prevent="save">Save</v-btn>
							</v-card-actions>
						</v-form>
					</v-card>
				</v-dialog>
			</v-toolbar>
			<v-text-field @input="searchIt" append-icon="mdi-magnify" class="mx-4" label="Search..." single-line hide-details clear-icon="mdi-close-circle" clearable/>
		</template>
		<template v-slot:item.actions="{ item }">
			<v-icon small class="mr-2" @click="editItem(item)">
				mdi-pencil
			</v-icon>
			<v-icon small @click="deleteItem(item)">
				mdi-delete
			</v-icon>
		</template>
		<template v-slot:no-data>
			<v-btn color="primary" @click="refresh">Reset</v-btn>
		</template>
	</v-data-table>
</template>
<script>
	import { mapActions } from 'vuex'
	export default {
		data: () => ({
			valid: true,
			dialog: false,
			loading: false,
			msg: {
				success: '',
				error: '',
			},
			options: {
				itemsPerPage: 10,
				sortBy: ['id'],
				sortDesc: [false]
			},
			rules: {
				required: v => !!v || "This Field Required",
				min: v => (v && v.length >= 5) || "Minimum 5 Characters Required",
			},
			footerProps: {
				itemsPerPageOptions: [10, 20, 30],
				itemsPerPageText: 'Promos Per Page',
				'show-current-page': true,
				'show-first-last-page': true
			},
			headers: [
				{ text: '#', align: 'left', sortable: false, value: 'id'},
				{ text: 'Name', value: 'name' },
				{ text: 'Promo Code', value: 'promo_code' },
				{ text: 'Actions', sortable: false, value: 'actions'},
			],
			promos: [],
			editedIndex: -1,
			editedItem: {
				id: '',
				name: '',
				promo_code: '',
				promo: '',
			},
			defaultItem: {
				id: '',
				name: '',
				promo_code: '',
				promo: '',
				created_at: '',
				updated_at: '',
			},
		}),
		computed: {
			formTitle () {
				return this.editedIndex === -1 ? 'New Promo' : 'Edit Promo'
			},
			checkCode() {
				return this.editedItem.promo_code != undefined ? this.verifyCode() : null
			},
		},
		watch: {
			dialog (val) {
				val || this.close()
			},
			options: {
				handler(e) {
					const sortBy = e.sortBy.length > 0 ? e.sortBy[0].trim() : 'id';
					const orderBy = e.sortDesc[0] ? 'desc' : 'asc';
					this.axios.get(`http://localhost:8000/api/promo`, {params: {'page': e.page,'per_page': e.itemsPerPage, 'sort_by': sortBy, 'order_by': orderBy}})
					.then(res => {
						this.promos = res.data.promos
					})
					.catch(err => {
						if(err.response.status == 401) {
							localStorage.removeItem('token');
							this.$router.push('/');
						}
					})
				},
				deep: true
			},
		},
		created () {
			this.initialize()
		},
		methods: {
			...mapActions({
				setAlert: 'alert/set'
			}),
			verifyCode() {
				if (this.editedItem.promo_code.length >= 5) {
					this.axios.post("http://localhost:8000/api/promo/verify", { promo_code: this.editedItem.promo_code })
					.then(res => {
						this.msg.success = res.data.message;
						this.msg.error = "";
					})
					.catch(err => {
						console.log(err.response)
						this.msg.success = "";
						this.msg.error = "Promo Already Exists";
					});
				} else {
					this.msg.success = "";
					this.msg.error = "";
				}
			},
			searchIt(e) {
				if(e) {
					if(e.length > 2) {
						this.axios.get(`http://localhost:8000/api/promo/${e}`)
						.then(res => this.promos = res.data.promo)
						.catch(err => console.dir(err.response))
					}
				} else {
					this.axios.get(`http://localhost:8000/api/promo`)
					.then(res => this.promos = res.data.promos)
					.catch(err => console.dir(err.response))
				}
			},
			initialize () {
				this.axios.interceptors.request.use((config) => {
					this.loading = true; 
					return config;
				}, (error) => {
					this.loading = false;
					return Promise.reject(error);
				});

				this.axios.interceptors.response.use((response) => {
					this.loading = false;
					return response;
				}, (error) => {
					this.loading = false;
					return Promise.reject(error);
				});
			},
			refresh() {
				this.initialize()
				this.axios.get(`http://localhost:8000/api/promo`)
				.then(res => {
					this.promos = res.data.promos
				})
				.catch(err => {
					if(err.response.status == 401) {
						localStorage.removeItem('token');
						this.$router.push('/');
					}
				})
			},
			editItem (item) {
				this.editedIndex = this.promos.data.indexOf(item)
				this.editedItem = Object.assign({}, item)
				this.dialog = true
			},
			deleteItem (item) {
				const index = this.promos.data.indexOf(item)
				let decide = confirm('Are you sure you want to delete this item?')
				if(decide) {
					this.axios.delete('http://localhost:8000/api/promo/' + item.id)
					.then(res => {
						this.setAlert({status: true, color: 'success', text: 'Record Deleted Successfully!'})
						this.promos.data.splice(index, 1)
						console.log(res)
					}).catch(err => {
						console.log(err.response)
						this.setAlert({status: true, color: 'error', text: 'Error Deleting Record!'})
					})
				}
			},
			close () {
				this.dialog = false
				setTimeout(() => {
					this.editedItem = Object.assign({}, this.defaultItem)
					this.editedIndex = -1
				}, 300)
			}, 
			save () {
				if (this.editedIndex > -1) {
					const index = this.editedIndex
					this.axios.put('http://localhost:8000/api/promo/' + this.editedItem.id, this.editedItem)
					.then(res => {
						this.setAlert({status: true, color: 'success', text: 'Record Updated Successfully!'})
						Object.assign(this.promos.data[index], res.data.promo)
					})
					.catch(err => {
						console.log(err.response)
						this.setAlert({status: true, color: 'error', text: 'Error Updating Record!'})
						this.$refs.form.reset()
					})
				} else {
					this.axios.post('http://localhost:8000/api/promo', this.editedItem)
					.then(res => {
						this.setAlert({status: true, color: 'success', text: 'Record Added Successfully!'})
						this.promos.data.push(res.data.promo)
						this.$refs.form.reset()
					})
					.catch(err => {
						console.log(err.response)
						this.setAlert({status: true, color: 'error', text: 'Error Inserting Record!'})
					})
				}
				this.close()
			},
		},
	}
</script>
<style scoped></style>