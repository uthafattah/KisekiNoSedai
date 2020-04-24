<template>
	<v-snackbar v-model="alert" :color="color" class="mb-12">
		Alertnya mas
		<v-btn dark text @click="alert = false">
			<v-icon>mdi-close-circle</v-icon>
		</v-btn>
	</v-snackbar>
</template>
<script>
	export default {
		data: () => ({
            alert: true,
            color: 'success'
		}),
	};
</script>