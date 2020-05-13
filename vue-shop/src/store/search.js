export default {
	namespaced: true,
	state: {
		merchandise: [],
		store: [],
		category: [],
		search: ''
	},
	getters: {
		getMerchandise: state => {
			return state.merchandise
		},
		getStore: state => {
			return state.store
		},
		getCategory: state => {
			return state.category
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
		SEARCH_CATEGORY: (state, payload) => {
			state.category = payload
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
		searchCategory: ({commit}, payload) => {
			commit("SEARCH_CATEGORY", payload)
		},
		search: ({commit}, payload) => {
			commit("SEARCH", payload)
		}
	},
}
