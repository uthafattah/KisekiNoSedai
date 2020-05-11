export default {
	namespaced: true,
	state: {
		user: {}
	},
	getters: {
		getId: state => {
			return state.user.id
		},
		getData: state => {
			var data = {
				name: state.user.name,
				email: state.user.email,
				phone: state.user.phone,
				address: state.user.address,
			}
			return data
		},
		getAvatar: state => {
			return state.user.avatar
		},
		getRole: state => {
			return state.user.role_id
		},
		getPassword: state => {
			return state.user.password
		},
		getToken: state => {
			var token = {
				remember_token: state.user.remember_token,
				api_token: state.user.api_token
			}
			return token
		},
	},
	mutations: {
		UPDATE_PROFILE: (state, payload) => {
			state.user.name = payload.name
			state.user.email = payload.email
			state.user.phone = payload.phone
			state.user.address = payload.address
		},
		UPDATE_AVATAR: (state, payload) => {
			state.user.avatar = payload
		},
		UPDATE_PASSWORD: (state, payload) => {
			state.user.password = payload
		},
		SET_USER: (state, payload) => {
			state.user = payload
		},
	},
	actions: {
		set: ({commit}, payload) => {
			commit("SET_USER", payload)
		}
	},
}
