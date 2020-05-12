export default {
	namespaced: true,
	state: {
		merchandise: [],
		store: [],
		search: ''
	},
	getters: {
		getMerchandise: state => {
			return state.merchandise
		},
		getStore: state => {
			return state.store
		},
		getSearch: state => {
			return state.search
		},
	},
	mutations: {
		SEARCH_MERCHANDISE: (state, payload) => {
			state.merchandise = payload
		},
		SEARCH_STORE: (state, payload) => {
			state.store = payload
		},
		SEARCH: (state, payload) => {
			state.search = payload
		},
	},
	actions: {
		searchMerchandise: ({commit}, payload) => {
			commit("SEARCH_MERCHANDISE", payload)
		},
		searchStore: ({commit}, payload) => {
			commit("SEARCH_STORE", payload)
		},
		search: ({commit}, payload) => {
			commit("SEARCH", payload)
		}
	},
}
