<template>
	<v-card outlined>
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
					<v-col cols="12" v-for="(order) in orders" :key="order.id" link :to="order.action">
						<OrderItem :order="order" />
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
			orders: ['1', '2'],
		}),
		created(){

		},
		components: {
			OrderItem: () => import(/* webpackChunkName: "order-item" */ '@/components/OrderItem.vue')
		},
		computed: {
			dateRangeText () {
				return this.dates.join(' ~ ')
			},
		},
		methods: {
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
			clearDate () {
				this.dates = []
			},
		},
	}
</script>
<style scoped>
	.btnCustom:hover {
		background-color: #FF5252 !important;
	}
</style>