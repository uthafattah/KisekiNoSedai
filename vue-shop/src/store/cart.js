//import axios from 'axios'
export default {
	namespaced: true,
	state: {
		cart: [],
	},
	getters: {
		getCart: state => {
			return state.cart
		},
		getTotal: state => {
			var total = 0;
			for(var i = 0; i < state.cart.length; i++) {
				total += state.cart[i].price * state.cart[i].quantity
			}
			return total
		},
		getQuantity: state => {
			var qty = 0;
			for(var i = 0; i < state.cart.length; i++) {
				qty += state.cart[i].quantity
			}
			return qty
		}
	},
	mutations: {
		UPDATE_QUANTITY: (state, payload) => {
			let cartItem = state.cart.find(item => item.id === payload.id)
			cartItem.quantity = payload.quantity
		},
		SET_CART: (state, payload) => {
			state.cart = payload
		},
	},
	actions: {
		set: ({commit}, payload) => {
			commit("SET_CART", payload)
		},
		updateQuantity({commit}, payload) {
			commit("UPDATE_QUANTITY", payload)
		},
	},
}
