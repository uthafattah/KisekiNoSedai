<template>
	<v-data-table item-key="name" class="elevation-1" :loading="loading" loading-text="Loading... Please wait" :headers="headers" :options.sync="options" :server-items-length="categories.total" :items="categories.data" :footer-props="footerProps">
		<template v-slot:top>
			<v-toolbar flat color="transparent">
				<v-toolbar-title>Category Management System</v-toolbar-title>
				<v-divider class="mx-4" inset vertical></v-divider>
				<v-spacer></v-spacer>
				<v-dialog v-model="dialog" max-width="800px">
					<template v-slot:activator="{ on }">
						<v-btn color="primary" dark class="mb-2" v-on="on">Add New Category</v-btn>
					</template>
					<v-card>
						<v-card-title>
							<span class="headline">{{ formTitle }}</span>
						</v-card-title>
						<v-form ref="form" v-model="valid" v-on:submit.stop.prevent="save">
							<v-card-text>
								<v-container>
									<v-row v-if="editedIndex > -1">
										<v-col cols="12" sm="12">
											<v-text-field v-model="editedItem.name" :rules="[rules.required, rules.min]" label="Category Name" />
										</v-col>
									</v-row>
									<v-row v-if="editedIndex == -1">
										<v-col cols="12" sm="6">
											<v-text-field v-model="editedItem.name" :success-messages="msg.success" :error-messages="msg.error" :rules="[rules.required, rules.min]" :blur="checkCategory" label="Category Name" />
										</v-col>
										<v-col cols="12" sm="6">
											<v-file-input v-model="editedItem.photo" :rules="[rules.required]" label="Select File" placeholder="Upload Photo" accept="image/jpg, image/png, image/bmp, image/jpeg" />
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
		<template v-slot:item.photo="{ item }">
			<v-edit-dialog>
				<v-list-item-avatar tile>
					<v-img :src="getImage(item.photo)" aspect-ratio="1" class="grey lighten-2"></v-img>
				</v-list-item-avatar>
				<template v-slot:input>
					<v-file-input v-model="editedItem.photo" label="Select File" placeholder="Upload Photo" accept="image/jpg, image/png, image/bmp, image/jpeg" @change="uploadPhoto(item)" />
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
				itemsPerPageText: 'Categories Per Page',
				'show-current-page': true,
				'show-first-last-page': true
			},
			headers: [
				{ text: '#', align: 'left', sortable: false, value: 'id'},
				{ text: 'Name', value: 'name' },
				{ text: 'Slug', value: 'slug' },
				{ text: 'Photo', sortable: false, value: 'photo' },
				{ text: 'Actions', sortable: false, value: 'actions'},
			],
			categories: [],
			editedIndex: -1,
			editedItem: {
				id: '',
				name: '',
				photo: [],
			},
			defaultItem: {
				id: '',
				name: '',
				slug: '',
				photo: [],
				created_at: '',
				updated_at: '',
			},
		}),
		computed: {
			formTitle () {
				return this.editedIndex === -1 ? 'New Category' : 'Edit Category'
			},
			checkCategory() {
				return this.editedItem.name != undefined ? this.verifyCategory() : null
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
					this.axios.get(`http://localhost:8000/api/category`, {params: {'page': e.page,'per_page': e.itemsPerPage, 'sort_by': sortBy, 'order_by': orderBy}})
					.then(res => {
						this.categories = res.data.categories
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
			verifyCategory() {
				if (this.editedItem.name.length >= 3) {
					this.axios.post("http://localhost:8000/api/category/verify", { name: this.editedItem.name })
					.then(res => {
						this.msg.success = res.data.message;
						this.msg.error = "";
					})
					.catch(err => {
						console.log(err.response)
						this.msg.success = "";
						this.msg.error = "Category Already Exists";
					});
				} else {
					this.msg.success = "";
					this.msg.error = "";
				}
			},
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
			uploadPhoto(item) {
				if (this.editedItem.photo != null) {
					const index = this.users.data.indexOf(item);
					let formData = new FormData();
					formData.append( "photo", this.editedItem.photo, this.editedItem.photo.name );
					formData.append("user", item.id);
					this.axios.post("http://localhost:8000/api/user/photo", formData)
					.then(res => {
						this.users.data[index].photo = res.data.user.photo;
						this.editedItem.photo = null;
					})
					.catch(err => console.log(err.response));
				}
			},
			searchIt(e) {
				if(e) {
					if(e.length > 2) {
						this.axios.get(`http://localhost:8000/api/category/${e}`)
						.then(res => this.categories = res.data.category)
						.catch(err => console.dir(err.response))
					}
				} else {
					this.axios.get(`http://localhost:8000/api/category`)
					.then(res => this.categories = res.data.categories)
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
				this.axios.get(`http://localhost:8000/api/category`)
				.then(res => {
					this.categories = res.data.categories
				})
				.catch(err => {
					if(err.response.status == 401) {
						localStorage.removeItem('token');
						this.$router.push('/');
					}
				})
			},
			editItem (item) {
				this.editedIndex = this.categories.data.indexOf(item)
				this.editedItem = Object.assign({}, item)
				this.dialog = true
			},
			deleteItem (item) {
				const index = this.categories.data.indexOf(item)
				let decide = confirm('Are you sure you want to delete this item?')
				if(decide) {
					this.axios.delete('http://localhost:8000/api/category/' + item.id)
					.then(res => {
						this.setAlert({status: true, color: 'success', text: 'Record Deleted Successfully!'})
						this.categories.data.splice(index, 1)
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
					this.axios.put('http://localhost:8000/api/category/' + this.editedItem.id, this.editedItem)
					.then(res => {
						this.setAlert({status: true, color: 'success', text: 'Record Updated Successfully!'})
						Object.assign(this.categories.data[index], res.data.category)
						this.$refs.form.reset()
					})
					.catch(err => {
						console.log(err.response)
						this.setAlert({status: true, color: 'error', text: 'Error Updating Record!'})
					})
				} else {
					this.axios.post('http://localhost:8000/api/category', this.editedItem)
					.then(res => {
						this.setAlert({status: true, color: 'success', text: 'Record Added Successfully!'})
						this.categories.data.push(res.data.category)
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