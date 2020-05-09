<template>
	<v-snackbar v-model="alert" :color="color" class="mb-12">
		{{text}}
		<v-btn dark text @click="close">
			<v-icon>mdi-close-circle</v-icon>
		</v-btn>
	</v-snackbar>
</template>
<script>
	import { mapGetters, mapActions } from 'vuex'
	export default {
		name: 'alerts',
		methods: {
			...mapActions({
				setAlert: 'alert/set'
			}),
			close(){
				this.setAlert({
					status : false
				})
			}
		},
		computed: {
			...mapGetters({
				status: 'alert/getStatus',
				color: 'alert/getColor',
				text: 'alert/getText',
			}),
			alert: {
				get() {
					return this.status
				},
				set (value) {
					this.setAlert({
						status: value,
						type: 'success',
						text: 'alert'
					})
				}
			}
		}
	};
</script>