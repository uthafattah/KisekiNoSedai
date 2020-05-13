export default {
	namespaced: true,
	state: {
		order: [],
	},
	getters: {
		getOrder: state => {
			return state.order
		},
		getTotal: state => {
			var total = 0;
			for(var i = 0; i < state.order.length; i++) {
				total += state.order[i].price * state.order[i].quantity
			}
			return total
		},
	},
	mutations: {
		SET_ORDER: (state, payload) => {
			state.order = payload
		},
	},
	actions: {
		set: ({commit}, payload) => {
			commit("SET_ORDER", payload)
		},
	},
}
