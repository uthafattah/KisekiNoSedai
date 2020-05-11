<template>
	<div>
		<v-data-table item-key="name" class="elevation-1" :loading="loading" loading-text="Loading... Please wait" :headers="headers" :options.sync="options" :server-items-length="stores.total" :items="stores.data" show-select @input="selectAll" :footer-props="footerProps">
			<template v-slot:top>
				<v-toolbar flat>
					<v-toolbar-title>Store Management System</v-toolbar-title>
					<v-divider class="mx-4" inset vertical></v-divider>
					<v-spacer></v-spacer>
					<v-dialog v-model="dialog" max-width="500px">
						<!--template v-slot:activator="{ on }"-->
						<!--template>
							<v-btn color="primary" dark class="mb-2 mr-2" @click="deleteAll" disabled>Delete</v-btn>
						</template-->
						<v-card>
							<v-card-title>
								<span class="headline">{{ formTitle }}</span>
							</v-card-title>

							<v-card-text>
								<v-container>
									<v-row>
										<v-col cols="12" sm="12">
											<v-select :items="status_stores" :rules="[rules.required]" v-model="editedItem.status_store" label="Select Status Store"></v-select>
										</v-col>
									</v-row>
								</v-container>
							</v-card-text>
							<v-card-actions>
								<v-spacer></v-spacer>
								<!--v-btn color="blue darken-1" text @click="close">Cancel</v-btn-->
								<v-btn color="blue darken-1" text>Cancel</v-btn>
								<v-btn type="submit" :disabled="!valid" color="blue darken-1" text @click.prevent="save">Save</v-btn>
							</v-card-actions>
						</v-card>
					</v-dialog>
				</v-toolbar>
				<v-text-field @input="searchIt" append-icon="mdi-magnify" class="mx-4" label="Search..." single-line hide-details clear-icon="mdi-close-circle" clearable/>
			</template>
			<template v-slot:item.logo="{ item }">
				<v-list-item-avatar>
					<v-img :src="getImage(item.logo)" aspect-ratio="1" class="grey lighten-2"></v-img>
				</v-list-item-avatar>
			</template>
			<template v-slot:item.status_store="{ item }">
				<v-edit-dialog large block persistent :return-value.sync="item.status_store" @save="updateStatus(item)">
					{{item.status_store}}
					<template v-slot:input>
						<h4>Change Status</h4>
						<v-select :rules="[rules.required]" :items="status_stores" v-model="item.status_store" color="error" label="Select Status"></v-select>
					</template>
				</v-edit-dialog>
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
				<v-btn color="primary" @click="initialize">Reset</v-btn>
			</template>
		</v-data-table>
		<!--Alert :alerts="alerts" v-if="isAlert"/-->
		<v-snackbar v-model="alert.status" :color="alert.color" class="top mb-12">
			{{alert.text}}
			<v-btn dark text @click="alert.status = false">
				<v-icon>mdi-close-circle</v-icon>
			</v-btn>
		</v-snackbar>
	</div>
</template>
<script>
	export default {
		data: () => ({
			valid: true,
			dialog: false,
			loading: false,
			selected: [],
			text: '',
			success: '',
			error: '',
			options: {
				itemsPerPage: 10,
				sortBy: ['id'],
				sortDesc: [false]
			},
			alert: {
				text: '',
				color: '',
				status: false,
			},
			rules: {
				required: v => !!v || "This Field Required",
				min: v => (v && v.length >= 5) || "Minimum 5 Characters Required",
				validEmail: v => /.+@.+\..+/.test(v) || "E-mail must be valid",
			},
			footerProps: {
				itemsPerPageOptions: [10, 20, 30],
				itemsPerPageText: 'Stores Per Page',
				'show-current-page': true,
				'show-first-last-page': true
			},
			headers: [
				{ text: '#', align: 'left', sortable: false, value: 'id' },
				{ text: 'Name', value: 'name' },
				{ text: 'Status', value: 'status_store' },
				{ text: 'Logo', sortable: false, value: 'logo' },
				{ text: 'Actions', sortable: false, value: 'actions' },
			],
			stores: [],
			status_stores: [],
			editedIndex: -1,
			editedItem: {
				id: '',
				name: '',
				status_store: '',
			},
			defaultItem: {
				id: '',
				name: '',
				status_store: '',
				created_at: '',
				updated_at: '',
			},
		}),
		computed: {
			formTitle () {
				return 'Edit Store'
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
					this.axios.get(`http://localhost:8000/api/store`, {params: {'page': e.page,'per_page': e.itemsPerPage, 'sort_by': sortBy, 'order_by': orderBy}})
					.then(res => {
						this.stores = res.data.stores;
						this.status_stores = res.data.status_stores;
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
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
			updateStatus(item) {
				const index = this.stores.data.indexOf(item);
				this.axios.post("http://localhost:8000/api/store/status_store", { status_store: item.status_store, store: item.id })
				.then(res => {
					this.alerts(res.data.store.name + "'s Store Status Updated to " + res.data.store.status_store, "success")
				})
				.catch(err => {
					this.stores.data[index].status_store = err.response.data.store.status_store;
					this.alerts(err.response.data.store.name + "'s Store Status Cannot Be Updated to " + err.response.data.store.status_store, "error")
				});
			},
			selectAll(e) {
				this.selected = []
				if(e.length > 0) {
					this.selected = e
					//this.selected = e.map(val => val.id)
				}
			},
			deleteAll() {
				let decide = confirm('Are you sure you want to delete these items?')
				if(decide) {
					const selected_id = this.selected.map(val => val.id)
					//this.axios.post('http://localhost:8000/api/store//delete', {'stores': this.selected})
					this.axios.post('http://localhost:8000/api/store/delete', {'stores': selected_id})
					.then(res => {
						this.selected.map(val => {
							const index = this.stores.data.indexOf(val)
							this.stores.data.splice(index, 1)
						})
						this.alerts("Records Deleted Successfully!", "success")
						console.log(res)
					}).catch(err => {
						console.log(err.response)
						this.alerts("Error Deleting Records!", "error")
					})
				}
			},
			searchIt(e) {
				if(e) {
					if(e.length > 2) {
						this.axios.get(`http://localhost:8000/api/store/${e}`)
						.then(res => this.stores = res.data.stores)
						.catch(err => console.dir(err.response))
					}
					if(e.length<=0){
						this.axios.get(`http://localhost:8000/api/store/`)
						.then(res => this.stores = res.data.stores)
						.catch(err => console.dir(err.response))
					}
				} else {
					this.axios.get(`http://localhost:8000/api/store/`)
					.then(res => this.stores = res.data.stores)
					.catch(err => console.dir(err.response))
				}
			},
			paginate(e) {
				const sortBy = e.sortBy.length == 0 ? "name" : e.sortBy[0];
				const orderBy = e.sortDesc.length > 0 && e.sortDesc[0] ? "asc" : "desc";
				//const sortBy = this.options.sortBy.length == 0 ? "name" : this.options.sortBy[0];
				//const orderBy = this.options.sortDesc.length > 0 && this.options.sortDesc[0] ? "asc" : "desc";
				this.axios.get(`http://localhost:8000/api/store`, {params: {'page': e.page,'per_page': e.itemsPerPage, 'sort_by': sortBy, 'order_by': orderBy}})
				.then(res => {
					this.stores = res.data.stores;
					this.status_store = res.data.status_store;
				})
				.catch(err => {
					if(err.response.status == 401) {
						localStorage.removeItem('token');
						this.$router.push('/');
					}
				})
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
			editItem (item) {
				this.editedIndex = this.stores.data.indexOf(item)
				this.editedItem = Object.assign({}, item)
				this.dialog = true
			},
			deleteItem (item) {
				const index = this.stores.data.indexOf(item)
				let decide = confirm('Are you sure you want to delete this item?')
				if(decide) {
					this.axios.delete('http://localhost:8000/api/store/' + item.id)
					.then(res => {
						this.alerts("Record Deleted Successfully!", "success")
						this.stores.data.splice(index, 1)
						console.log(res)
					}).catch(err => {
						console.log(err.response)
						this.alerts("Error Deleting Record!", "error")
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
					this.axios.put('http://localhost:8000/api/store/' + this.editedItem.id, this.editedItem)
					.then(res => {
						Object.assign(this.stores.data[index], res.data.store)
						this.alerts("Record Updated Successfully!", "success")
					})
					.catch(err => {
						console.log(err.response)
						this.alerts("Error Updating Record!", "error")
					})
				}
				this.close()
			},
			alerts (text, color) {
				this.alert.text = text
				this.alert.color = color
				this.alert.status = true;
			}
		},
	}
</script>
<style scoped></style>