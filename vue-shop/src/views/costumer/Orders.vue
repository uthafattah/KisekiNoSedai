<template>
	<v-card outlined>
		<!--v-card-title class="text-center justify-center py-6">
			<h1 class="font-weight-bold display-1 basil--text">BASiL</h1>
		</v-card-title-->
		<v-row class="mx-4 mt-4 mb-n4">
			<v-col cols="4">
				<v-menu v-model="datepicker" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="290px">
					<template v-slot:activator="{ on }">
						<v-text-field dense outlined :value="dateRangeText" label="Lihat Transaksi" prepend-icon="mdi-calendar-blank" readonly v-on="on" @click:clear="clearDate" clear-icon="mdi-close-circle" clearable/>
						<!--v-text-field v-model="dateRangeText" label="Date range" prepend-icon="mdi-calendar-blank" readonly v-on="on"></v-text-field-->
					</template>
					<v-date-picker v-model="dates" @input="pickCount++, pickCount == 2 ? (datepicker = false, pickCount = 0) : datepicker " range></v-date-picker>
				</v-menu>
			</v-col>
			<v-col cols="6">
				<v-text-field dense outlined append-icon="mdi-magnify" label="Search..." hide-details clear-icon="mdi-close-circle" clearable/>
			</v-col>
			<v-col cols="2">
				<v-select dense outlined :items="sorting" label="Sort By"></v-select>
			</v-col>
		</v-row>
		<v-divider class="mx-4" />
		<v-tabs fixed-tabs v-model="tab" background-color="white" icons-and-text>
			<v-progress-linear :active="loading" :indeterminate="loading" absolute top color="white accent-4"></v-progress-linear>
			<v-tabs-slider></v-tabs-slider>
			<v-tab v-for="(item, index) in tab_header" :key="index" :href="`#tab-${index}`">
				{{item.text}}
				<v-icon>{{item.icon}}</v-icon>
			</v-tab>
		</v-tabs>
		<v-tabs-items v-model="tab">
			<v-tab-item v-for="(item, index) in tab_item" :key="index" :value="`tab-${index}`">
				<v-row class="mx-2">
					<v-col cols="12">
						<v-card outlined>
							<v-card-text class="font-weight-black">
								18 Mar 2020 - {{item.text}}
							</v-card-text>
							<v-divider class="mx-4" />
							<v-card flat>
								<v-list-item three-line>
									<v-list-item-avatar tile size="80">
											<v-img src="https://cdn.vuetifyjs.com/images/cards/foster.jpg"></v-img>
											<!--v-icon>mdi-store</v-icon-->
									</v-list-item-avatar>
									<v-list-item-content>
										<v-row>
											<v-col cols="6">
												<v-list-item-subtitle>
												<span class="success--text font-weight-bold mr-2">Jannah Gate</span> <span>(INV/20200318/XX/III/504846623)</span>
											</v-list-item-subtitle>
												<v-list-item-title class="title font-weight-bold">Bundle Package WD Green SSD 240GB</v-list-item-title>
												<v-list-item-subtitle>
													<span class="warning--text mr-4">Rp. 1.600.000</span> <span class="grey--text">1 Produk</span>
												</v-list-item-subtitle>
											</v-col>
											<v-divider class="mx-4" inset vertical></v-divider>
											<v-col cols="2">
												<v-list-item-subtitle class="grey--text">Status</v-list-item-subtitle>
												<v-list-item-title class="subtitle-1 font-weight-bold success--text">Pesanan Selesai</v-list-item-title>
											</v-col>
											<v-divider class="mx-4" inset vertical></v-divider>
											<v-col cols="2">
												<v-list-item-subtitle class="grey--text">Total Harga Produk</v-list-item-subtitle>
												<v-list-item-title class="subtitle-1 font-weight-bold warning--text">Rp. 1.600.000</v-list-item-title>
											</v-col>
										</v-row>
									</v-list-item-content>
								</v-list-item>

								<v-card-actions>
									<v-spacer />
									<v-btn small outlined color="secondary" to="/checkout"><v-icon small left>mdi-eye</v-icon>See Order Details</v-btn>
									<v-btn small outlined color="secondary" to="/messages"><v-icon small left>mdi-email</v-icon>Message Store</v-btn>
									<v-btn small color="light-blue darken-1" class="white--text" to="/carts"><v-icon small left>mdi-cart</v-icon>Buy Again</v-btn>
								</v-card-actions>
							</v-card>
						</v-card>
					</v-col>
				</v-row>
			</v-tab-item>
		</v-tabs-items>
		<v-card-actions>
			<v-spacer />
			<v-text-field dense outlined readonly v-model="total" label="Total Shopping" prefix="Rp" class="mr-3 mt-4 shrink" style="width: 250px;"/>
		</v-card-actions>
	</v-card>
</template>
<script>
	export default {
		data: () => ({
			loading: false,
			tab: null,
			dates: [],
			datepicker: false,
			pickCount: 0,
			total: '1.000.000.000',
			sorting: ['The Latest', 'Highest Price', 'Lowest Price'],
			tab_header: [
				{
					icon: 'mdi-package',
					text: 'All',
				},
				{
					icon: 'mdi-note-text',
					text: 'Requested',
				},
				{
					icon: 'mdi-clock',
					text: 'Waiting',
				},
				{
					icon: 'mdi-package-variant',
					text: 'On Process',
				},
				{
					icon: 'mdi-truck-fast',
					text: 'Shipped',
				},
				{
					icon: 'mdi-truck-check',
					text: 'Arrived',
				},
				{
					icon: 'mdi-briefcase-check',
					text: 'Success',
				},
				{
					icon: 'mdi-file-cancel',
					text: 'Canceled',
				},
			],
			tab_item: [
				{
					text: 'All',
				},
				{
					text: 'Requested',
				},
				{
					text: 'Waiting',
				},
				{
					text: 'On Process',
				},
				{
					text: 'Shipped',
				},
				{
					text: 'Arrived',
				},
				{
					text: 'Success',
				},
				{
					text: 'Canceled',
				},
			],
		}),
		computed: {
			dateRangeText () {
				return this.dates.join(' ~ ')
			},
		},
		methods: {
			getImage(image) {
				return "http://localhost:8000/storage/" + image;
			},
			clearDate () {
				this.dates = []
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