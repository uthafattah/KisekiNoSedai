import Vue from 'vue'
import Vuex from 'vuex'
import cart from '@/store/cart'
import auth from '@/store/auth'
import store from '@/store/store'
import alert from '@/store/alert'
import menu from '@/store/menu'
import search from '@/store/search'
import wishlist from '@/store/wishlist'
import follow from '@/store/follow'
import order from '@/store/order'

Vue.use(Vuex)

export default new Vuex.Store({
	state: {
		routeCostumer: ['/', '/carts', '/checkout', '/merchandise', '/messages', '/orders', '/promos', '/settings', '/stores', '/wishlists'],
		routeAdmin: ['/admin', '/admin/categories', '/admin/messages', '/admin/payments', '/admin/promos', '/admin/roles', '/admin/status-store', '/admin/status-order', '/admin/stores', '/admin/users'],
		routeStore: ['/my-store', '/my-store/merchandise', '/my-store/messages', '/my-store/orders', '/my-store/reports', '/my-store/settings'],
	},
	getters: {
		isCostumer: (state) => (route) => {
			for(var i = 0; i < state.routeCostumer.length; i++) {
				if(state.routeCostumer[i] === route) return true
			}
			return false
		},
		isAdmin: (state) => (route) => {
			for(var i = 0; i < state.routeCostumer.length; i++) {
				if(state.routeAdmin[i] === route) return true
			}
			return false
		},
		isStore: (state) => (route) => {
			for(var i = 0; i < state.routeCostumer.length; i++) {
				if(state.routeStore[i] === route) return true
			}
			return false
		},
	},
	mutations: {

	},
	actions: {

	},
	modules: {
		cart,
		auth,
		store,
		alert,
		menu,
		search,
		wishlist,
		follow,
		order,
	}
})
