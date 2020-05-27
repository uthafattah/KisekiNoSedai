<template>
	<v-data-table item-key="name" class="elevation-1" :loading="loading" loading-text="Loading... Please wait" :headers="headers" :options.sync="options" :server-items-length="payments.total" :items="payments.data" :footer-props="footerProps">
		<template v-slot:top>
			<v-toolbar flat color="transparent">
				<v-toolbar-title>Payment Management System</v-toolbar-title>
				<v-divider class="mx-4" inset vertical></v-divider>
				<v-spacer></v-spacer>
				<v-dialog v-model="dialog" max-width="500px">
					<template v-slot:activator="{ on }">
						<v-btn color="primary" dark class="mb-2" v-on="on">Add New Payment</v-btn>
					</template>
					<v-card>
						<v-card-title>
							<span class="headline">{{ formTitle }}</span>
						</v-card-title>
						<v-form ref="form" v-model="valid" v-on:submit.stop.prevent="save">
							<v-card-text>
								<v-container>
									<v-row>
										<v-col cols="12" sm="12">
											<v-text-field v-model="editedItem.name" :rules="[rules.required, rules.min]" label="Payment Name" v-if="editedIndex > -1"/>
											<v-text-field v-model="editedItem.name" :success-messages="msg.success" :error-messages="msg.error" :rules="[rules.required, rules.min]" :blur="checkPayment" label="Payment Name" v-else/>
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
				min: v => (v && v.length >= 3) || "Minimum 3 Characters Required",
			},
			footerProps: {
				itemsPerPageOptions: [10, 20, 30],
				itemsPerPageText: 'Payments Per Page',
				'show-current-page': true,
				'show-first-last-page': true
			},
			headers: [
				{ text: '#', align: 'left', sortable: false, value: 'id'},
				{ text: 'Name', value: 'name' },
				{ text: 'Slug', value: 'slug' },
				{ text: 'Actions', sortable: false, value: 'actions'},
			],
			payments: [],
			editedIndex: -1,
			editedItem: {
				id: '',
				name: '',
			},
			defaultItem: {
				id: '',
				name: '',
				slug: '',
				created_at: '',
				updated_at: '',
			},
		}),
		computed: {
			formTitle () {
				return this.editedIndex === -1 ? 'New Payment' : 'Edit Payment'
			},
			checkPayment() {
				return this.editedItem.name != undefined ? this.verifyPayment() : null
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
					this.axios.get(`http://localhost:8000/api/payment`, {params: {'page': e.page,'per_page': e.itemsPerPage, 'sort_by': sortBy, 'order_by': orderBy}})
					.then(res => {
						this.payments = res.data.payments
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
			verifyPayment() {
				if (this.editedItem.name.length >= 3) {
					this.axios.post("http://localhost:8000/api/payment/verify", { name: this.editedItem.name })
					.then(res => {
						this.success = res.data.message;
						this.error = "";
					})
					.catch(err => {
						console.log(err.response)
						this.success = "";
						this.error = "Payment Already Exists";
					});
				} else {
					this.success = "";
					this.error = "";
				}
			},
			searchIt(e) {
				if(e) {
					if(e.length > 2) {
						this.axios.get(`http://localhost:8000/api/payment/${e}`)
						.then(res => this.payments = res.data.payment)
						.catch(err => console.dir(err.response))
					}
				} else {
					this.axios.get(`http://localhost:8000/api/payment`)
					.then(res => this.payments = res.data.payments)
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
				this.axios.get(`http://localhost:8000/api/payment`)
				.then(res => {
					this.payments = res.data.payments
				})
				.catch(err => {
					if(err.response.status == 401) {
						localStorage.removeItem('token');
						this.$router.push('/');
					}
				})
			},
			editItem (item) {
				this.editedIndex = this.payments.data.indexOf(item)
				this.editedItem = Object.assign({}, item)
				this.dialog = true
			},
			deleteItem (item) {
				const index = this.payments.data.indexOf(item)
				let decide = confirm('Are you sure you want to delete this item?')
				if(decide) {
					this.axios.delete('http://localhost:8000/api/payment/' + item.id)
					.then(res => {
						this.setAlert({status: true, color: 'success', text: 'Record Deleted Successfully!'})
						this.payments.data.splice(index, 1)
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
					this.axios.put('http://localhost:8000/api/payment/' + this.editedItem.id, this.editedItem)
					.then(res => {
						this.setAlert({status: true, color: 'success', text: 'Record Updated Successfully!'})
						Object.assign(this.payments.data[index], res.data.payment)
						this.$refs.form.reset()
					})
					.catch(err => {
						console.log(err.response)
						this.setAlert({status: true, color: 'error', text: 'Error Updating Record!'})
					})
				} else {
					this.axios.post('http://localhost:8000/api/payment', this.editedItem)
					.then(res => {
						this.setAlert({status: true, color: 'success', text: 'Record Added Successfully!'})
						this.payments.data.push(res.data.payment)
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