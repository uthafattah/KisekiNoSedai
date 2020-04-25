<template>
	<v-data-table item-key="name" class="elevation-1" :loading="loading" loading-text="Loading... Please wait" :headers="headers" :options.sync="options" :server-items-length="roles.total" :items="roles.data" show-select @input="selectAll" :footer-props="footerProps">
		<template v-slot:top>
			<v-toolbar flat>
				<v-toolbar-title>Role Management System</v-toolbar-title>
				<v-divider class="mx-4" inset vertical></v-divider>
				<v-spacer></v-spacer>
				<v-dialog v-model="dialog" max-width="500px">
					<template v-slot:activator="{ on }">
						<v-btn color="primary" dark class="mb-2" v-on="on">Add New Role</v-btn>
						<!--v-btn color="primary" dark class="mb-2 mr-2" @click="deleteAll" disabled>Delete</v-btn-->
					</template>
					<v-card>
						<v-card-title>
							<span class="headline">{{ formTitle }}</span>
						</v-card-title>

						<v-card-text>
							<v-container>
								<v-row>
									<v-col cols="12" sm="12">
										<!--v-text-field v-model="editedItem.name" :rules="[rules.required, rules.min]" :blur="checkRole" label="Role Name"></v-text-field-->
										<v-text-field v-model="editedItem.name" :rules="[rules.required, rules.min]" label="Role Name"></v-text-field>
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
			<v-text-field @input="searchIt" append-icon="mdi-magnify" class="mx-4" label="Search..." single-line hide-details></v-text-field>
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
</template>
<script>
	export default {
		data: () => ({
			valid: true,
			dialog: false,
			loading: false,
			snackbar: false,
			selected: [],
			text: '',
			success: '',
			error: '',
			options: {
				itemsPerPage: 10,
				sortBy: ['id'],
				sortDesc: [false]
			},
			rules: {
				required: v => !!v || "This Field Required",
				min: v => v.length >= 5 || "Minimum 5 Characters Required",
			},
			footerProps: {
				itemsPerPageOptions: [10, 20, 30],
				itemsPerPageText: 'Roles Per Page',
				'show-current-page': true,
				'show-first-last-page': true
			},
			headers: [
				{ text: '#', align: 'left', sortable: false, value: 'id'},
				{ text: 'Name', value: 'name' },
				{ text: 'Slug', value: 'slug' },
				{ text: 'Actions', sortable: false, value: 'actions'},
			],
			roles: [],
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
				return this.editedIndex === -1 ? 'New Role' : 'Edit Role'
			},
			/*checkRole() {
				if (this.editedItem.name.length >= 5) {
					this.axios.post("http://localhost:8000/api/role/verify", { name: this.editedItem.name })
					.then(res => {
						this.success = res.data.message;
						this.error = "";
					})
					.catch(err => {
						console.log(err)
						this.success = "";
						this.error = "Role Already Exists";
					});
				} else {
					this.success = "";
					this.error = "";
				}
				return 0;
			},*/
		},
		watch: {
			dialog (val) {
				val || this.close()
			},
			options: {
				handler(e) {
					const sortBy = e.sortBy.length > 0 ? e.sortBy[0].trim() : 'id';
					const orderBy = e.sortDesc[0] ? 'desc' : 'asc';
					this.axios.get(`http://localhost:8000/api/role/`, {params: {'page': e.page,'per_page': e.itemsPerPage, 'sort_by': sortBy, 'order_by': orderBy}})
					.then(res => {
						this.roles = res.data
					})
					.catch(err => {
						if(err.response.status == 401) {
							localStorage.removeItem('token');
							this.$router.push('/login');
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
					//this.axios.post('http://localhost:8000/api/role/delete', {'roles': this.selected})
					this.axios.post('http://localhost:8000/api/role/delete', {'roles': selected_id})
					.then(res => {
						this.text = "Records Deleted Successfully!";
						this.selected.map(val => {
							const index = this.roles.data.indexOf(val)
							this.roles.data.splice(index, 1)
						})
						console.log(res)
						this.snackbar = true;
					}).catch(err => {
						console.log(err.response)
						this.text = "Error Deleting Records!";
						this.snackbar = true;
					})
				}
			},
			searchIt(e) {
				if(e.length > 2) {
					this.axios.get(`http://localhost:8000/api/role/${e}`)
					.then(res => this.roles = res.data.role)
					.catch(err => console.dir(err.response))
				}
				if(e.length<=0){
					this.axios.get(`http://localhost:8000/api/role/`)
					.then(res => this.roles = res.data)
					.catch(err => console.dir(err.response))
				}
			},
			paginate(e) {
				const sortBy = e.sortBy.length > 0 ? e.sortBy[0].trim() : 'name';
				const orderBy = e.sortDesc[0] ? 'desc' : 'asc';
				this.axios.get(`http://localhost:8000/api/role/`, {params: {'page': e.page,'per_page': e.itemsPerPage, 'sort_by': sortBy, 'order_by': orderBy}})
				.then(res => {
					this.roles = res.data.role
				})
				.catch(err => {
					if(err.response.status == 401) {
						localStorage.removeItem('token');
						this.$router.push('/login');
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
				this.editedIndex = this.roles.data.indexOf(item)
				this.editedItem = Object.assign({}, item)
				this.dialog = true
			},
			deleteItem (item) {
				const index = this.roles.data.indexOf(item)
				let decide = confirm('Are you sure you want to delete this item?')
				if(decide) {
					this.axios.delete('http://localhost:8000/api/role/' + item.id)
					.then(res => {
						this.text = "Record Deleted Successfully!";
						this.snackbar = true;
						this.roles.data.splice(index, 1)
						console.log(res)
					}).catch(err => {
						console.log(err.response)
						this.text = "Error Deleting Record!";
						this.snackbar = true;
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
					this.axios.put('http://localhost:8000/api/role/' + this.editedItem.id, {'name': this.editedItem.name })
					.then(res => {
						this.text = "Record Updated Successfully!";
						this.snackbar = true;
						Object.assign(this.roles.data[index], res.data.role)
					})
					.catch(err => {
						console.log(err.response)
						this.text = "Error Updating Record!";
						this.snackbar = true;
					})
				} else {
					this.axios.post('http://localhost:8000/api/role/', {'name': this.editedItem.name })
					.then(res => {
						this.text = "Record Added Successfully!";
						this.snackbar = true;
						this.roles.data.push(res.data.role)
					})
					.catch(err => {
						console.log(err.response)
						this.text = "Error Inserting Record!";
						this.snackbar = true;
					})
				}
				this.close()
			},
		},
	}
</script>
<style scoped></style>