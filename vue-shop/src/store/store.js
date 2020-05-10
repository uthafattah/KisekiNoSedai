export default {
	namespaced: true,
	state: {
		store: {}
	},
	getters: {
		getStore: state => {
			return state.store
		},
	},
	mutations: {
		UPDATE_STORE: (state, payload) => {
			state.store.name = payload.name
			state.store.category = payload.category
			state.store.address = payload.address
			state.store.description = payload.description
		},
		UPDATE_LOGO: (state, payload) => {
			state.store.avatar = payload
		},
		SET_STORE: (state, payload) => {
			state.store = payload
		},
	},
	actions: {
		set: ({commit}, payload) => {
			commit("SET_STORE", payload)
		}
	},
}
