<template>
	<v-snackbar v-model="alert" :color="alerts.color" class="mb-12">
		{{alerts.text}}
		<v-btn dark text @click="alert = false">
			<v-icon>mdi-close-circle</v-icon>
		</v-btn>
	</v-snackbar>
</template>
<script>
	export default {
		name: 'alerts',
		props: ['alerts'],
		data: () => ({
            alert: true,
            //color: 'success'
		}),
	};
</script>