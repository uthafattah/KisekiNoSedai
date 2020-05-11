<template>
	<v-data-table item-key="name" class="elevation-1" :loading="loading" loading-text="Loading... Please wait" :headers="headers" :options.sync="options" :server-items-length="merchandise.total" :items="merchandise.data" show-select @input="selectAll" :footer-props="footerProps">
		<template v-slot:top>
			<v-toolbar flat>
				<v-toolbar-title>Merchandise Management System</v-toolbar-title>
				<v-divider class="mx-4" inset vertical></v-divider>
				<v-spacer></v-spacer>
				<v-dialog v-model="dialog" max-width="800px">
					<template v-slot:activator="{ on }">
						<v-btn color="primary" dark class="mb-2" v-on="on">Add New Merchandise</v-btn>
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
										<v-col cols="12" sm="12">
											<v-text-field :rules="[rules.required, rules.min]" v-model="editedItem.name" label="Name"></v-text-field>
										</v-col>
										<v-col cols="12" sm="6">
											<v-select :items="categories" :rules="[rules.required]" v-model="editedItem.category" label="Select Category"></v-select>
										</v-col>
										<v-col cols="12" sm="6">
											<v-file-input v-model="editedItem.photo" :rules="[rules.required]" label="Select File" placeholder="Upload Photo" accept="image/jpg, image/png, image/bmp, image/jpeg" />
										</v-col>
										<v-col cols="12" sm="6">
											<v-text-field type="text" :rules="[rules.required]" v-model="editedItem.stock" label="Stock"></v-text-field>
										</v-col>
										<v-col cols="12" sm="6">
											<v-text-field type="text" :rules="[rules.required]" v-model="editedItem.price" label="Price"></v-text-field>
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
								<v-btn type="submit" :disabled="!valid" color="blue darken-1" text @clic.prevent="save">Save</v-btn>
							</v-card-actions>
						</v-form>
					</v-card>
				</v-dialog>
			</v-toolbar>
			<v-text-field @input="searchIt" append-icon="mdi-magnify" class="mx-4" label="Search..." single-line hide-details clear-icon="mdi-close-circle" clearable/>
		</template>
		<template v-slot:item.category="{ item }">
			<v-edit-dialog large block persistent :return-value.sync="item.category" @save="updateCategory(item)">
				{{item.category}}
				<template v-slot:input>
					<h4>Change Category</h4>
					<v-select :rules="[rules.required]" :items="categories" v-model="item.category" color="error" label="Select Category"></v-select>
				</template>
			</v-edit-dialog>
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
			<v-btn color="primary" @click="initialize">Reset</v-btn>
		</template>
	</v-data-table>
</template>
<script>
	import { mapGetters } from 'vuex'
	export default {
		data: () => ({
			valid: true,
			dialog: false,
			loading: false,
			snackbar: false,
			selected: [],
			text: '',
			categories: [],
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
				itemsPerPageText: 'Merchandise Per Page',
				'show-current-page': true,
				'show-first-last-page': true
			},
			headers: [
				{ text: '#', align: 'left', sortable: false, value: 'id' },
				{ text: 'Name', value: 'name' },
				{ text: 'Category', value: 'category' },
				{ text: 'Stock', value: 'stock' },
				{ text: 'Price', value: 'price' },
				{ text: 'Photo', sortable: false, value: 'photo' },
				{ text: 'Actions', sortable: false, value: 'actions' },
			],
			merchandise: [],
			editedIndex: -1,
			editedItem: {
				id: '',
				name: '',
				category: '',
				stock: '',
				price: '',
				photo: null,
			},
			defaultItem: {
				id: '',
				name: '',
				category: '',
				stock: '',
				price: '',
				photo: '',
				created_at: '',
				updated_at: '',
			},
		}),
		computed: {
			...mapGetters({
				store: 'store/getStore',
			}),
			formTitle () {
				return this.editedIndex === -1 ? 'New Merchandise' : 'Edit Merchandise'
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
					this.axios.get('http://localhost:8000/api/merchandise/store_merchandise/' + this.store.id, {params: {'page': e.page,'per_page': e.itemsPerPage, 'sort_by': sortBy, 'order_by': orderBy}})
					.then(res => {
						this.merchandise = res.data.merchandise;
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
			uploadPhoto(item) {
				if (this.editedItem.photo != null) {
					const index = this.merchandise.data.indexOf(item);
					let formData = new FormData();
					formData.append( "photo", this.editedItem.photo, this.editedItem.photo.name );
					formData.append("merchandise", item.id);
					this.axios.post("http://localhost:8000/api/merchandise/searchStoreId/1/photo", formData)
					.then(res => {
						this.merchandise.data[index].photo = res.data.merchandise.photo;
						this.editedItem.photo = null;
					})
					.catch(err => console.log(err.response));
				}
			},
			updateCategory(item) {
				const index = this.merchandise.data.indexOf(item);
				this.axios.post("http://localhost:8000/api/merchandise/searchStoreId/1/category", { category: item.category, merchandise: item.id })
				.then(res => {
					this.text = res.data.merchandise.name + "'s Category Updated to " + res.data.merchandise.category;
					this.snackbar = true;
				})
				.catch(error => {
					this.text = error.response.data.merchandise.name + "'s Category Cannot Be Updated to " + error.response.data.merchandise.category;
					this.merchandise.data[index].category = error.response.data.merchandise.category;
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
					//this.axios.post('http://localhost:8000/api/merchandise/searchStoreId/1/delete', {'merchandise': this.selected})
					this.axios.post('http://localhost:8000/api/merchandise/searchStoreId/1/delete', {'merchandise': selected_id})
					.then(res => {
						this.text = "Records Deleted Successfully!";
						this.selected.map(val => {
							const index = this.merchandise.data.indexOf(val)
							this.merchandise.data.splice(index, 1)
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
						this.axios.get(`http://localhost:8000/api/merchandise/searchStoreId/1/${e}`)
						.then(res => this.merchandise = res.data.merchandise)
						.catch(err => console.dir(err.response))
					}
					if(e.length<=0){
						this.axios.get(`http://localhost:8000/api/merchandise/searchStoreId/1`)
						.then(res => this.merchandise = res.data.merchandise)
						.catch(err => console.dir(err.response))
					}
				} else {
					this.axios.get(`http://localhost:8000/api/merchandise/searchStoreId/1`)
					.then(res => this.merchandise = res.data.merchandise)
					.catch(err => console.dir(err.response))
				}
			},
			paginate(e) {
				const sortBy = e.sortBy.length == 0 ? "name" : e.sortBy[0];
				const orderBy = e.sortDesc.length > 0 && e.sortDesc[0] ? "asc" : "desc";
				//const sortBy = this.options.sortBy.length == 0 ? "name" : this.options.sortBy[0];
				//const orderBy = this.options.sortDesc.length > 0 && this.options.sortDesc[0] ? "asc" : "desc";
				this.axios.get(`http://localhost:8000/api/merchandise/searchStoreId/1`, {params: {'page': e.page,'per_page': e.itemsPerPage, 'sort_by': sortBy, 'order_by': orderBy}})
				.then(res => {
					this.merchandise = res.data.merchandise
					this.categories = res.data.categories;
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
				this.editedIndex = this.merchandise.data.indexOf(item)
				this.editedItem = Object.assign({}, item)
				this.dialog = true
			},
			deleteItem (item) {
				const index = this.merchandise.data.indexOf(item)
				let decide = confirm('Are you sure you want to delete this item?')
				if(decide) {
					this.axios.delete('http://localhost:8000/api/merchandise/searchStoreId/1/' + item.id)
					.then(res => {
						this.text = "Record Deleted Successfully!";
						this.snackbar = true;
						this.merchandise.data.splice(index, 1)
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
					this.axios.put('http://localhost:8000/api/merchandise/searchStoreId/1/' + this.editedItem.id, this.editedItem)
					.then(res => {
						this.text = "Record Updated Successfully!";
						this.snackbar = true;
						Object.assign(this.merchandise.data[index], res.data.merchandise)
					})
					.catch(err => {
						console.log(err.response)
						this.text = "Error Updating Record!";
						this.snackbar = true;
					})
				} else {
					this.axios.post('http://localhost:8000/api/merchandise/searchStoreId/1', this.editedItem)
					.then(res => {
						this.text = "Record Added Successfully!";
						this.snackbar = true;
						this.merchandise.data.push(res.data.merchandise)
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