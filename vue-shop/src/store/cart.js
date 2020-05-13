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
		INSERT_CART: (state, payload) => {
			state.cart.push(payload)
		},
		REMOVE_CART: (state, payload) => {
			let idx = state.cart.indexOf(payload);
			state.cart.splice(idx,1) 
		},
		WISHLIST_CART: (state, payload) => {
			let cartItem = state.cart.find(item => item.id === payload.id)
			cartItem.status = !payload.status
		},
		STATUS: (state, payload) => {
			let cartItem = state.cart.find(item => item.id === payload.id)
			cartItem.status = !payload.status
		},
	},
	actions: {
		set: ({commit}, payload) => {
			commit("SET_CART", payload)
		},
		updateQuantity({commit}, payload) {
			commit("UPDATE_QUANTITY", payload)
		},
		insert({state, commit}, payload) {
			let cartItem = state.cart.find(item => item.id === payload.id)
			cartItem ? commit("UPDATE_QUANTITY", payload) : commit("INSERT_CART", payload) 
		},
		remove({state, commit}, payload) {
			let cartItem = state.cart.find(item => item.id === payload.id)
			if(cartItem) commit("REMOVE_CART", cartItem)
		},
		wishlist({state, commit}, payload) {
			let cartItem = state.cart.find(item => item.id === payload.id)
			if(cartItem) commit("WISHLIST_CART", cartItem)
		},
		status({state, commit}, payload) {
			let cartItem = state.cart.find(item => item.merchandise_id === payload)
			if(cartItem) commit("STATUS", cartItem)
		},
	},
}
