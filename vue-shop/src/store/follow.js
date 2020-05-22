export default {
	namespaced: true,
	state: {
		follow: [],
	},
	getters: {
		getFollow: state => {
			return state.follow
		},
	},
	mutations: {
		SET_FOLLOW: (state, payload) => {
			state.follow = payload
		},
		INSERT_FOLLOW: (state, payload) => {
			state.follow.push(payload)
		},
		REMOVE_FOLLOW: (state, payload) => {
			let idx = state.follow.indexOf(payload);
			state.follow.splice(idx,1) 
		},
	},
	actions: {
		set: ({commit}, payload) => {
			commit("SET_FOLLOW", payload)
		},
		insert({commit}, payload) {
			commit("INSERT_FOLLOW", payload) 
		},
		remove({state, commit}, payload) {
			let followItem = state.follow.find(item => item.id === payload.id)
			if(followItem) commit("REMOVE_FOLLOW", followItem)
		},
	},
}
