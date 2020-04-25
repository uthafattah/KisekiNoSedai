<template>
	<v-card outlined>
		<v-card-title class="text-center justify-center py-6">
			<h1 class="font-weight-bold display-1 basil--text">BASiL</h1>
		</v-card-title>
		<v-tabs fixed-tabs v-model="tab" background-color="white" icons-and-text>
			<v-progress-linear :active="loading" :indeterminate="loading" absolute top color="white accent-4"></v-progress-linear>
			<v-tabs-slider></v-tabs-slider>
			<v-tab href="#tab-all">
				All
				<v-icon>mdi-package</v-icon>
			</v-tab>
			<v-tab href="#tab-requested">
				Requested
				<v-icon>mdi-note-text</v-icon>
			</v-tab>
			<v-tab href="#tab-waiting">
				Waiting
				<v-icon>mdi-clock</v-icon>
			</v-tab>
			<v-tab href="#tab-on_process">
				On Process
				<v-icon>mdi-package-variant</v-icon>
			</v-tab>
			<v-tab href="#tab-shipped">
				Shipped
				<v-icon>mdi-truck-fast</v-icon>
			</v-tab>
			<v-tab href="#tab-arrived">
				Arrived
				<v-icon>mdi-truck-check</v-icon>
			</v-tab>
			<v-tab href="#tab-success">
				Success
				<v-icon>mdi-briefcase-check</v-icon>
			</v-tab>
			<v-tab href="#tab-canceled">
				Canceled
				<v-icon>mdi-file-cancel</v-icon>
			</v-tab>
		</v-tabs>
		<v-tabs-items v-model="tab">
			<v-tab-item :value="'tab-all'">
				<v-card flat>
					<v-card-text>
						asasas
					</v-card-text>
					<v-card-actions class="mr-2">
						<v-spacer />
						<v-btn outlined color="secondary" @click="clearProfile">Clear</v-btn>
						<v-btn type="submit" :disabled="!valid_profile" @click.prevent="update_profile" outlined color="success" @click="submit">Update Profile</v-btn>
					</v-card-actions>
				</v-card>
			</v-tab-item>
			<v-tab-item :value="'tab-requested'">
				<v-card flat>
					<v-card-text>
						asasas
					</v-card-text>
					<v-card-actions class="mr-2">
						<v-spacer />
						<v-btn outlined color="secondary" @click="clearProfile">Clear</v-btn>
						<v-btn type="submit" :disabled="!valid_profile" @click.prevent="update_profile" outlined color="success" @click="submit">Update Profile</v-btn>
					</v-card-actions>
				</v-card>
			</v-tab-item>
			<v-tab-item :value="'tab-waiting'">
				<v-card flat>
					<v-card-text>
						asasas
					</v-card-text>
					<v-card-actions class="mr-2">
						<v-spacer />
						<v-btn outlined color="secondary" @click="clearProfile">Clear</v-btn>
						<v-btn type="submit" :disabled="!valid_profile" @click.prevent="update_profile" outlined color="success" @click="submit">Update Profile</v-btn>
					</v-card-actions>
				</v-card>
			</v-tab-item>
			<v-tab-item :value="'tab-on_process'">
				<v-card flat>
					<v-card-text>
						asasas
					</v-card-text>
					<v-card-actions class="mr-2">
						<v-spacer />
						<v-btn outlined color="secondary" @click="clearProfile">Clear</v-btn>
						<v-btn type="submit" :disabled="!valid_profile" @click.prevent="update_profile" outlined color="success" @click="submit">Update Profile</v-btn>
					</v-card-actions>
				</v-card>
			</v-tab-item>
			<v-tab-item :value="'tab-shipped'">
				<v-card flat>
					<v-card-text>
						asasas
					</v-card-text>
					<v-card-actions class="mr-2">
						<v-spacer />
						<v-btn outlined color="secondary" @click="clearProfile">Clear</v-btn>
						<v-btn type="submit" :disabled="!valid_profile" @click.prevent="update_profile" outlined color="success" @click="submit">Update Profile</v-btn>
					</v-card-actions>
				</v-card>
			</v-tab-item>
			<v-tab-item :value="'tab-arrived'">
				<v-card flat>
					<v-card-text>
						asasas
					</v-card-text>
					<v-card-actions class="mr-2">
						<v-spacer />
						<v-btn outlined color="secondary" @click="clearProfile">Clear</v-btn>
						<v-btn type="submit" :disabled="!valid_profile" @click.prevent="update_profile" outlined color="success" @click="submit">Update Profile</v-btn>
					</v-card-actions>
				</v-card>
			</v-tab-item>
			<v-tab-item :value="'tab-success'">
				<v-card flat>
					<v-card-text>
						asasas
					</v-card-text>
					<v-card-actions class="mr-2">
						<v-spacer />
						<v-btn outlined color="secondary" @click="clearProfile">Clear</v-btn>
						<v-btn type="submit" :disabled="!valid_profile" @click.prevent="update_profile" outlined color="success" @click="submit">Update Profile</v-btn>
					</v-card-actions>
				</v-card>
			</v-tab-item>
			<v-tab-item :value="'tab-canceled'">
				<v-card flat>
					<v-card-text>
						asasas
					</v-card-text>
					<v-card-actions class="mr-2">
						<v-spacer />
						<v-btn outlined color="secondary" @click="clearProfile">Clear</v-btn>
						<v-btn type="submit" :disabled="!valid_profile" @click.prevent="update_profile" outlined color="success" @click="submit">Update Profile</v-btn>
					</v-card-actions>
				</v-card>
			</v-tab-item>
		</v-tabs-items>
	</v-card>
</template>
<script>
	export default {
		data: () => ({
			loading: false,
			tab: null,
		}),
		computed: {
		},
		methods: {
			getImage(image) {
				return "http://localhost:8000/storage/" + image;
			},
			submit() {

			},
		},
		created(){
		},
	}
</script>
<style scoped>
	.btnCustom:hover {
		background-color: #FF5252 !important;
	}
</style>