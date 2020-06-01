<template>
	<v-card outlined>
		<v-divider class="mx-4" />
		<v-tabs fixed-tabs v-model="tab" background-color="white" icons-and-text>
			<v-progress-linear :active="loading" :indeterminate="loading" absolute top color="white accent-4"></v-progress-linear>
			<v-tabs-slider :class="{'slider': theme}"></v-tabs-slider>
			<v-tab v-for="(item, index) in tab_header" :key="index" :href="`#tab-${index}`" :class="{'tab': theme}">
				{{item.text}}
				<v-icon>{{item.icon}}</v-icon>
			</v-tab>
		</v-tabs>
		<v-tabs-items v-model="tab">
			<v-tab-item v-for="(item, index) in tab_item" :key="index" :value="`tab-${index}`">
				<v-data-table item-key="name" class="elevation-1" :loading="loading" loading-text="Loading... Please wait" :headers="headers" :options.sync="options" :server-items-length="orders.total" :items="orders.data" :footer-props="footerProps">
					<template v-slot:top>
						<v-toolbar flat color="transparent">
							<v-toolbar-title>{{item.text}} Orders</v-toolbar-title>
						</v-toolbar>
						<v-row class="mx-1 mt-n6 mb-2">
							<v-col cols="4">
								<v-menu v-model="datepicker" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="290px">
									<template v-slot:activator="{ on }">
										<v-text-field single-line hide-details :value="dateRangeText" label="Lihat Transaksi" prepend-icon="mdi-calendar-blank" readonly v-on="on" @click:clear="clearDate" clear-icon="mdi-close-circle" clearable/>
										<!--v-text-field v-model="dateRangeText" label="Date range" prepend-icon="mdi-calendar-blank" readonly v-on="on"></v-text-field-->
									</template>
									<v-date-picker v-model="dates" @input="pickCount++, pickCount == 2 ? (datepicker = false, pickCount = 0) : datepicker " range></v-date-picker>
								</v-menu>
							</v-col>
							<v-col cols="6">
								<v-text-field single-line hide-details append-icon="mdi-magnify" label="Search..." clear-icon="mdi-close-circle" clearable/>
							</v-col>
							<v-col cols="2">
								<v-select single-line hide-details :items="sorting" label="Sort By"></v-select>
							</v-col>
						</v-row>
					</template>
					<template v-slot:item.status_order="{ item }">
						<v-edit-dialog large block persistent :return-value.sync="item.status_order" @save="updateStatus(item)">
								{{item.status_order}}
								
							<template v-slot:input>
								<h4>Change Role</h4>
								<v-select :rules="[rules.required]" :items="status_order" v-model="item.status_order" color="error" label="Select Status"></v-select>
							</template>
						</v-edit-dialog>
					</template>
					<!--template v-slot:item.photo="{ item }">
						<v-list-item-avatar>
							<v-img :src="getImage(item.photo)" aspect-ratio="1" class="grey lighten-2"></v-img>
						</v-list-item-avatar>
					</template-->
					<template v-slot:no-data>
						<v-btn color="primary" @click="refresh">Reset</v-btn>
					</template>
				</v-data-table>
			</v-tab-item>
		</v-tabs-items>
	</v-card>
</template>
<script>
	import { mapGetters } from 'vuex'
	export default {
		data: () => ({
			tab: null,
			dates: [],
			datepicker: false,
			pickCount: 0,
			sorting: ['The Latest', 'Highest Price', 'Lowest Price'],
			tab_header: [
				{ icon: 'mdi-package', text: 'All' },
				{ icon: 'mdi-note-text', text: 'Requested' },
				{ icon: 'mdi-clock', text: 'Waiting' },
				{ icon: 'mdi-package-variant', text: 'On Process' },
				{ icon: 'mdi-truck-fast', text: 'Shipped' },
				{ icon: 'mdi-truck-check', text: 'Arrived' },
				{ icon: 'mdi-briefcase-check', text: 'Success' },
				{ icon: 'mdi-file-cancel', text: 'Canceled' },
			],
			tab_item: [
				{ text: 'All' },
				{ text: 'Requested' },
				{ text: 'Waiting' },
				{ text: 'On Process' },
				{ text: 'Shipped' },
				{ text: 'Arrived' },
				{ text: 'Success' },
				{ text: 'Canceled' },
			],
			orders: [],
			status_order: [],
			loading: false,
			options: {
				itemsPerPage: 10,
				sortBy: ['role_id'],
				sortDesc: [false]
			},
			rules: {
				required: v => !!v || "This Field Required",
			},
			footerProps: {
				itemsPerPageOptions: [10, 20, 30],
				itemsPerPageText: 'Users Per Page',
				'show-current-page': true,
				'show-first-last-page': true
			},
			headers: [
				{ text: 'Invoice', align: 'left', sortable: false, value: 'invoice_number' },
				//{ text: 'Costumer', value: 'user_name' },
				//{ text: 'Name Merchandise', value: 'merchandise_name' },
				//{ text: 'Quantity', value: 'quantity' },
				{ text: 'Total Price', value: 'total_price' },
				//{ text: 'Photo', sortable: false, value: 'photo' },
				{ text: 'Status', value: 'status_order' },
			],
		}),
		created(){
			this.axios.get('http://localhost:8000/api/order/store_order')
			.then((res) => {
				this.orders = res.data.order
				this.status_order = res.data.status_order
			})
			.catch((err) => {
				if(err.response.status == 401) {
					localStorage.removeItem('token');
					this.$router.push('/');
				}
				console.log(err.response)
			})
		},
		computed: {
			...mapGetters({
				store: 'store/getStore',
			}),
			dateRangeText () {
				return this.dates.join(' ~ ')
			},
			theme() {
				return (this.$vuetify.theme.dark)
			}
		},
		methods: {
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
			clearDate () {
				this.dates = []
			},
			checkStatusOrder (index) {
				for(var i = 0; i < this.orders.length; i++) {
					if(this.orders[i].status_order_id == index) return true
				}
				return false
			},
			total(index) {
				var total = 0;
				if(index == 0) {
					for(var i = 0; i < this.orders.length; i++) {
						total += this.orders[i].total_price + 10
					}
				} else {
					for(var j = 0; j < this.orders.length; j++) {
						if(this.orders[j].status_order_id == index) total += this.orders[j].total_price + 10
					}
				}
				return total
			},
			updateStatus(item) {
				const index = this.users.data.indexOf(item);
				this.axios.post("http://localhost:8000/api/user/role", { role: item.role, user: item.id })
				.then(res => {
					this.setAlert({status: true, color: 'success', text: res.data.user.name + "'s Role Updated to " + res.data.user.role})
				})
				.catch(err => {
					this.users.data[index].role = err.response.data.user.role;
					this.setAlert({status: true, color: 'error', text: err.response.data.user.name + "'s Role Cannot Be Updated to " + err.response.data.user.role})
				});
			},
			refresh() {
				//this.initialize()
				this.axios.get('http://localhost:8000/api/order/user_order')
				.then((res) => {
					this.orders = res.data.order
				})
				.catch((err) => {
					if(err.response.status == 401) {
						localStorage.removeItem('token');
						this.$router.push('/');
					}
					console.log(err.response)
				})
			},
		},
	}
</script>
<style scoped>
	.tab {
		color: white;
		background-color: #212121;
	}
	.slider {
		color: white;
	}
</style>