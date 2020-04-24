<template>
	<v-app id="inspire">
		<v-data-table item-key="name" class="elevation-1" :loading="loading" loading-text="Loading... Please wait" 
		:headers="headers" :options.sync="options" :server-items-length="orders.total" :items="orders.data" show-select @input="selectAll" :footer-props="footerProps">
			<template v-slot:top>
				<v-toolbar flat>
					<v-toolbar-title >Order Management System</v-toolbar-title>
					<v-divider class="mx-4" inset vertical></v-divider>
					<v-spacer></v-spacer>
					<v-dialog v-model="dialog" max-width="500px">
						<template v-slot:activator="{ on }">
							<v-btn color="primary" dark class="mb-2" v-on="on">Order By</v-btn>
							<!--v-list dense>
								<v-list-item v-for="(item, index) in order_report" :key="index" link :to="item.action">
									<v-list-item-content>
										<v-list-item-title>
											{{ item.text }}
										</v-list-item-title>
									</v-list-item-content>
								</v-list-item>
							</v-list-->
						</template>
						<v-card>
							<v-card-title>
								<span class="headline">{{ formTitle }}</span>
							</v-card-title>

							<v-card-text>
								<v-container>
									<v-row>
										<v-col cols="12" sm="6">
											<v-text-field v-model="editedItem.name" :rules="[rules.required]" :blur="checkRole" label="From Date"></v-text-field>
										</v-col>
										<v-col cols="12" sm="6">
											<v-text-field v-model="editedItem.name" :rules="[rules.required]" :blur="checkRole" label="To Date"></v-text-field>
										</v-col>
									</v-row>
								</v-container>
							</v-card-text>
							<v-card-actions>
								<v-spacer></v-spacer>
								<v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
								<v-btn type="submit" :disabled="!valid" color="blue darken-1" text @click.prevent="order">Order</v-btn>
							</v-card-actions>
						</v-card>
					</v-dialog>
				</v-toolbar>
				<v-text-field @input="searchIt" append-icon="mdi-magnify" class="mx-4" label="Search..." single-line hide-details></v-text-field>
			</template>
			<template v-slot:no-data>
				<v-btn color="primary" @click="initialize">Reset</v-btn>
			</template>
		</v-data-table>
	</v-app>
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
				itemsPerPage: 5,
				sortBy: ['id'],
				sortDesc: [false]
			},
			rules: {
				required: v => !!v || "This Field Required",
			},
			footerProps: {
				itemsPerPageOptions: [5, 10, 15],
				itemsPerPageText: 'Orders Per Page',
				'show-current-page': true,
				'show-first-last-page': true
			},
			headers: [
				{ text: '#', align: 'left', sortable: false, value: 'id'},
				{ text: 'Merchandise', value: 'merchandise' },
				{ text: 'Price', value: 'price' },
				{ text: 'Qty', value: 'qty' },
				{ text: 'Total', value: 'total' },
				{ text: 'Actions', sortable: false, value: 'actions'},
			],
			orders: [],
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
			order_report: [
				{
					text: 'Daily',
					action: '#'
				},
				{
					text: 'Weekly',
					action: '#'
				},
				{
					text: 'Monthly',
					action: '#'
				},
				{
					text: '6 Month',
					action: '#'
				},
				{
					text: 'Year',
					action: '#'
				},
			],
		}),
		computed: {
			formTitle () {
				return this.editedIndex === -1 ? 'Order Order' : 'Edit Order'
			},
		},
		watch: {
			dialog (val) {
				val || this.close()
			},
			/*options: {
				handler(e) {
					const sortBy = e.sortBy.length > 0 ? e.sortBy[0].trim() : 'id';
					const orderBy = e.sortDesc[0] ? 'desc' : 'asc';
					axios.get(`/api/orders`, {params: {'page': e.page,'per_page': e.itemsPerPage, 'sort_by': sortBy, 'order_by': orderBy}})
					.then(res => {
						this.orders = res.data.orders
					})
					.catch(err => {
						if(err.response.status == 401) {
							localStorage.removeItem('token');
							this.$router.push('/login');
						}
					})
				},
				deep: true
			},*/
		},
		created () {
			this.initialize()
		},
		methods: {
			/*selectAll(e) {
				this.selected = []
				if(e.length > 0) {
					this.selected = e
					//this.selected = e.map(val => val.id)
				}
			},
			searchIt(e) {
				if(e.length > 2) {
					axios.get(`/api/orders/${e}`)
					.then(res => this.orders = res.data.orders)
					.catch(err => console.dir(err.response))
				}
				if(e.length<=0){
					axios.get(`/api/orders`)
					.then(res => this.orders = res.data.orders)
					.catch(err => console.dir(err.response))
				}
			},
			paginate(e) {
				const sortBy = e.sortBy.length > 0 ? e.sortBy[0].trim() : 'name';
				const orderBy = e.sortDesc[0] ? 'desc' : 'asc';
				axios.get(`/api/orders`, {params: {'page': e.page,'per_page': e.itemsPerPage, 'sort_by': sortBy, 'order_by': orderBy}})
				.then(res => {
					this.orders = res.data.orders
				})
				.catch(err => {
					if(err.response.status == 401) {
						localStorage.removeItem('token');
						this.$router.push('/login');
					}
				})
			},
			initialize () {
				axios.interceptors.request.use((config) => {
					this.loading = true; 
					return config;
				}, (error) => {
					this.loading = false;
					return Promise.reject(error);
				});

				axios.interceptors.response.use((response) => {
					this.loading = false;
					return response;
				}, (error) => {
					this.loading = false;
					return Promise.reject(error);
				});
			},
			close () {
				this.dialog = false
				setTimeout(() => {
					this.editedItem = Object.assign({}, this.defaultItem)
					this.editedIndex = -1
				}, 300)
			}, 
			order () {
				axios.post('/api/orders', {'name': this.editedItem.name })
				.then(res => {
					this.text = "Record Added Successfully!";
					this.snackbar = true;
					this.orders.data.push(res.data.order)
				})
				.catch(err => {
					console.log(err.response)
					this.text = "Error Inserting Record!";
					this.snackbar = true;
				})
				this.close()
			},*/
		},
	}
</script>
<style scoped></style>