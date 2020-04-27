<template>
	<v-data-table item-key="name" class="elevation-1" :loading="loading" loading-text="Loading... Please wait" :headers="headers" :options.sync="options" :server-items-length="users.total" :items="users.data" show-select @input="selectAll" :footer-props="footerProps">
		<template v-slot:top>
			<v-toolbar flat>
				<v-toolbar-title>User Management System</v-toolbar-title>
				<v-divider class="mx-4" inset vertical></v-divider>
				<v-spacer></v-spacer>
				<v-dialog v-model="dialog" max-width="800px">
					<template v-slot:activator="{ on }">
						<v-btn color="primary" dark class="mb-2" v-on="on">Add New User</v-btn>
						<!--v-btn color="primary" dark class="mb-2 mr-2" @click="deleteAll" disabled>Delete</v-btn-->
					</template>
					<v-card>
						<v-card-title>
							<span class="headline">{{ formTitle }}</span>
						</v-card-title>
						<!--v-form v-model="valid" v-on:submit.stop.preverent="save"-->
						<v-form v-model="valid">
							<v-card-text>
								<v-container>
									<v-row>
										<v-col cols="12" sm="6">
											<v-text-field :rules="[rules.required, rules.min]" v-model="editedItem.name" label="Name"></v-text-field>
										</v-col>
										<v-col cols="12" sm="6">
											<v-select :items="roles" :rules="[rules.required]" v-model="editedItem.role" label="Select Role"></v-select>
										</v-col>
									</v-row>
									<v-row v-if="editedIndex == -1">
										<v-col cols="12" sm="6">
											<!--v-text-field type="email" :success-messages="success" :error-messages="error" :rules="[rules.required, rules.validEmail ]" :blur="checkEmail" v-model="editedItem.email" label="Email"></v-text-field-->
											<v-text-field type="email" :success-messages="success" :error-messages="error" :rules="[rules.required, rules.validEmail ]" v-model="editedItem.email" label="Email"></v-text-field>
										</v-col>
										<v-col cols="12" sm="6">
											<v-text-field type="text" :rules="[rules.required]" v-model="editedItem.phone" label="Phone"></v-text-field>
										</v-col>
										<v-col cols="12" sm="6">
											<v-text-field :append-icon="add_password ? 'mdi-eye' : 'mdi-eye-off'" :type="add_password ? 'text' : 'password'" @click:append="add_password = !add_password" :rules="[rules.required, rules.min]" v-model="editedItem.password" label="Type Password"></v-text-field>
										</v-col>
										<v-col cols="12" sm="6">
											<v-text-field :append-icon="add_rpassword ? 'mdi-eye' : 'mdi-eye-off'" :type="add_rpassword ? 'text' : 'password'" @click:append="add_rpassword = !add_rpassword" :rules="[rules.required, passwordMatch]" v-model="editedItem.rpassword" label="Retype Password"></v-text-field>
										</v-col>
										<v-col cols="12" md="12">
											<v-textarea type="text" :rules="[rules.required]" v-model="editedItem.address" label="Address"></v-textarea>
										</v-col>
									</v-row>
								</v-container>
							</v-card-text>
							<v-card-actions>
								<v-spacer></v-spacer>
								<v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
								<v-btn type="submit" :disabled="!valid" color="blue darken-1" text @clic.prevent="save">Save</v-btn>
							</v-card-actions>
						</v-form>
					</v-card>
				</v-dialog>
			</v-toolbar>
			<v-text-field @input="searchIt" append-icon="mdi-magnify" class="mx-4" label="Search..." single-line hide-details clear-icon="mdi-close-circle" clearable/>
		</template>
		<template v-slot:item.role="{ item }">
			<v-edit-dialog large block persistent :return-value.sync="item.role" @save="updateRole(item)">
				{{item.role}}
				<template v-slot:input>
					<h4>Change Role</h4>
					<v-select :rules="[rules.required]" :items="roles" v-model="item.role" color="error" label="Select Role"></v-select>
				</template>
			</v-edit-dialog>
		</template>
		<template v-slot:item.avatar="{ item }">
			<v-edit-dialog>
				<v-list-item-avatar>
					<v-img :src="getImage(item.avatar)" aspect-ratio="1" class="grey lighten-2"></v-img>
				</v-list-item-avatar>
				<template v-slot:input>
					<v-file-input v-model="editedItem.avatar" label="Select File" placeholder="Upload Avatar" accept="image/jpg, image/png, image/bmp, image/jpeg" @change="uploadAvatar(item)" />
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
</template>
<script>
	export default {
		data: () => ({
			valid: true,
			dialog: false,
			loading: false,
			snackbar: false,
			add_password: false,
			add_rpassword: false,
			selected: [],
			text: '',
			roles: [],
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
				validEmail: v => /.+@.+\..+/.test(v) || "E-mail must be valid",
			},
			footerProps: {
				itemsPerPageOptions: [10, 20, 30],
				itemsPerPageText: 'Users Per Page',
				'show-current-page': true,
				'show-first-last-page': true
			},
			headers: [
				{ text: '#', align: 'left', sortable: false, value: 'id' },
				{ text: 'Name', value: 'name' },
				{ text: 'Email', value: 'email' },
				{ text: 'Role', value: 'role' },
				{ text: 'Avatar', sortable: false, value: 'avatar' },
				{ text: 'Actions', sortable: false, value: 'actions' },
			],
			users: [],
			editedIndex: -1,
			editedItem: {
				id: '',
				name: '',
				email: '',
				password: '',
				role: '',
				address: '',
				phone: '',
				avatar: null,
			},
			defaultItem: {
				id: '',
				name: '',
				email: '',
				role: '',
				address: '',
				phone: '',
				avatar: '',
				created_at: '',
				updated_at: '',
			},
		}),
		computed: {
			formTitle () {
				return this.editedIndex === -1 ? 'New User' : 'Edit User'
			},
			passwordMatch() {
				return this.editedItem.password != this.editedItem.rpassword ? "Password Does Not Match" : true;
			},
			/*checkEmail() {
				if (/.+@.+\..+/.test(this.editedItem.email)) {
					this.axios.post("/api/email/verify", { email: this.editedItem.email })
					.then(res => {
						this.success = res.data.message;
						this.error = "";
					})
					.catch(err => {
						this.success = "";
						this.error = "Email Already Exists";
					});
				} else {
					this.success = "";
					this.error = "";
				}
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
					this.axios.get(`http://localhost:8000/api/user`, {params: {'page': e.page,'per_page': e.itemsPerPage, 'sort_by': sortBy, 'order_by': orderBy}})
					.then(res => {
						this.users = res.data;
						this.roles = res.data.roles;
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
			getImage(image) {
				return "http://localhost:8000/storage/" + image;
			},
			uploadAvatar(item) {
				if (this.editedItem.avatar != null) {
					const index = this.users.data.indexOf(item);
					let formData = new FormData();
					formData.append( "avatar", this.editedItem.avatar, this.editedItem.avatar.name );
					formData.append("user", item.id);
					this.axios.post("/api/user/avatar", formData)
					.then(res => {
						this.users.data[index].avatar = res.data.user.avatar;
						this.editedItem.avatar = null;
					})
					.catch(err => console.log(err.response));
				}
			},
			updateRole(item) {
				const index = this.users.data.indexOf(item);
				this.axios.post("/api/user/role", { role: item.role, user: item.id })
				.then(res => {
					this.text = res.data.user.name + "'s Role Updated to " + res.data.user.role;
					this.snackbar = true;
				})
				.catch(error => {
					this.text = error.response.data.user.name + "'s Role Cannot Be Updated to " + error.response.data.user.role;
					this.users.data[index].role = error.response.data.user.role;
					this.snackbar = true;
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
					//this.axios.post('http://localhost:8000/api/user/delete', {'users': this.selected})
					this.axios.post('http://localhost:8000/api/user/delete', {'users': selected_id})
					.then(res => {
						this.text = "Records Deleted Successfully!";
						this.selected.map(val => {
							const index = this.users.data.indexOf(val)
							this.users.data.splice(index, 1)
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
				if(e) {
					if(e.length > 2) {
						this.axios.get(`http://localhost:8000/api/user/search/${e}`)
						.then(res => this.users = res.data.user)
						.catch(err => console.dir(err.response))
					}
					if(e.length<=0){
						this.axios.get(`http://localhost:8000/api/user`)
						.then(res => this.users = res.data)
						.catch(err => console.dir(err.response))
					}
				} else {
					this.axios.get(`http://localhost:8000/api/user`)
					.then(res => this.users = res.data)
					.catch(err => console.dir(err.response))
				}
			},
			paginate(e) {
				const sortBy = e.sortBy.length == 0 ? "name" : e.sortBy[0];
				const orderBy = e.sortDesc.length > 0 && e.sortDesc[0] ? "asc" : "desc";
				//const sortBy = this.options.sortBy.length == 0 ? "name" : this.options.sortBy[0];
				//const orderBy = this.options.sortDesc.length > 0 && this.options.sortDesc[0] ? "asc" : "desc";
				this.axios.get(`http://localhost:8000/api/user`, {params: {'page': e.page,'per_page': e.itemsPerPage, 'sort_by': sortBy, 'order_by': orderBy}})
				.then(res => {
					this.users = res.data
					this.roles = res.data.roles;
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
				this.editedIndex = this.users.data.indexOf(item)
				this.editedItem = Object.assign({}, item)
				this.dialog = true
			},
			deleteItem (item) {
				const index = this.users.data.indexOf(item)
				let decide = confirm('Are you sure you want to delete this item?')
				if(decide) {
					this.axios.delete('http://localhost:8000/api/user/' + item.id)
					.then(res => {
						this.text = "Record Deleted Successfully!";
						this.snackbar = true;
						this.users.data.splice(index, 1)
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
					this.axios.put('http://localhost:8000/api/user/' + this.editedItem.id, this.editedItem)
					.then(res => {
						this.text = "Record Updated Successfully!";
						this.snackbar = true;
						Object.assign(this.users.data[index], res.data.user)
					})
					.catch(err => {
						console.log(err.response)
						this.text = "Error Updating Record!";
						this.snackbar = true;
					})
				} else {
					this.axios.post('http://localhost:8000/api/user', this.editedItem)
					.then(res => {
						this.text = "Record Added Successfully!";
						this.snackbar = true;
						this.users.data.push(res.data.user)
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