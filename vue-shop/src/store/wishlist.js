export default {
	namespaced: true,
	state: {
		wishlist: [],
	},
	getters: {
		getWishlist: state => {
			return state.wishlist
		},
	},
	mutations: {
		SET_WISHLIST: (state, payload) => {
			state.wishlist = payload
		},
		INSERT_WISHLIST: (state, payload) => {
			state.wishlist.push(payload)
		},
		REMOVE_WISHLIST: (state, payload) => {
			let idx = state.wishlist.indexOf(payload);
			state.wishlist.splice(idx,1) 
		},
	},
	actions: {
		set: ({commit}, payload) => {
			commit("SET_WISHLIST", payload)
		},
		insert({commit}, payload) {
			commit("INSERT_WISHLIST", payload) 
		},
		remove({state, commit}, payload) {
			let wishlistItem = state.wishlist.find(item => item.id === payload.id)
			if(wishlistItem) commit("REMOVE_WISHLIST", wishlistItem)
		},
	},
}
