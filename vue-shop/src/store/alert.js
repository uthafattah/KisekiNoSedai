export default {
	namespaced: true,
	state: {
		status: false,
		color: 'success',
		text: ''
	},
	getters: {
		getStatus: state => {
			return state.status
		},getColor: state => {
			return state.color
		},getText: state => {
			return state.text
		},
	},
	mutations: {
		SET_ALERT: (state, payload) => {
			state.status = payload.status
			state.color = payload.color
			state.text = payload.text
		},
	},
	actions: {
		set: ({commit}, payload) => {
			commit("SET_ALERT", payload)
		}
	},
}
