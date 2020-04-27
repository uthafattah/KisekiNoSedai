<template>
	<v-card outlined>
		<v-list-item>
			<v-row>
				<v-col cols="3" class="mt-12">
					<v-list-item-avatar tile size="250">
						<v-img src="https://cdn.vuetifyjs.com/images/cards/foster.jpg" v-model="profileField.avatar"></v-img>
						<!--v-icon>mdi-store</v-icon-->
					</v-list-item-avatar>
				</v-col>
				<v-col cols="9">
					<v-tabs grow v-model="tab" background-color="white" centered>
						<v-progress-linear :active="loading" :indeterminate="loading" absolute top color="white accent-4"></v-progress-linear>
						<v-tabs-slider></v-tabs-slider>
						<v-tab href="#tab-profile">
							Profile
						</v-tab>
						<v-tab href="#tab-password">
							Change Password
						</v-tab>
					</v-tabs>
					<v-tabs-items v-model="tab">
						<v-tab-item :value="'tab-profile'">
							<v-card flat>
								<v-card-text>
									<v-form ref="form" v-model="valid_profile">
										<v-text-field label="Name" v-model="profileField.name" :rules="[rules.required, rules.min]" prepend-icon="mdi-account" autocomplete="off" />
										<v-text-field label="E-Mail" v-model="profileField.email" :rules="[rules.required, rules.validEmail]" prepend-icon="mdi-email" autocomplete="off" />
										<v-text-field label="Phone" v-model="profileField.phone" :rules="[rules.required]" prepend-icon="mdi-cellphone" autocomplete="off" />
										<v-textarea type="text" label="Address" v-model="profileField.address" :rules="[rules.required]" prepend-icon="mdi-map-marker" autocomplete="off" />
									</v-form>
								</v-card-text>
								<v-card-actions class="mr-2">
									<v-spacer />
									<v-btn outlined color="secondary" @click="clearProfile">Clear</v-btn>
									<v-btn type="submit" :disabled="!valid_profile" @click.prevent="update_profile" outlined color="success" @click="submit">Update Profile</v-btn>
								</v-card-actions>
							</v-card>
						</v-tab-item>
						<v-tab-item :value="'tab-password'">
							<v-card flat>
								<v-card-text>
									<v-form ref="form" v-model="valid_password">
										<v-text-field :append-icon="old_password ? 'mdi-eye' : 'mdi-eye-off'" :type="old_password ? 'text' : 'password'" @click:append="old_password = !old_password" label="Old Password" v-model="resetPasswordField.old_password" :rules="[rules.required, rules.min]" prepend-icon="mdi-lock-clock" autocomplete="off" />
										<v-text-field :append-icon="new_password ? 'mdi-eye' : 'mdi-eye-off'" :type="new_password ? 'text' : 'password'" @click:append="new_password = !new_password" label="New Password" v-model="resetPasswordField.new_password" :rules="[rules.required, rules.min]" prepend-icon="mdi-lock" autocomplete="off" />
										<v-text-field :append-icon="new_rpassword ? 'mdi-eye' : 'mdi-eye-off'" :type="new_rpassword ? 'text' : 'password'" @click:append="new_rpassword = !new_rpassword" label="Retype Password" v-model="resetPasswordField.new_rpassword" :rules="[rules.required, passwordMatch]" prepend-icon="mdi-lock-check" autocomplete="off" />
									</v-form>
								</v-card-text>
								<v-card-actions class="mr-2">
									<v-spacer />
									<v-btn outlined color="secondary" @click="clearPassword">Clear</v-btn>
									<v-btn type="submit" :disabled="!valid_password" @click.prevent="update_password" outlined color="success" @click="submit">Update Password</v-btn>
								</v-card-actions>
							</v-card>
						</v-tab-item>
					</v-tabs-items>
				</v-col>
			</v-row>
		</v-list-item>
	</v-card>
</template>
<script>
	export default {
		data: () => ({
			loading: false,
			tab: null,
			valid_profile: false,
			valid_password: false,
			old_password: false,
			new_password: false,
			new_rpassword: false,
			rules: {
				required: v => !!v || "This Field Required",
				min: v => v.length >= 5 || "Minimum 5 Characters Required",
				validEmail: v => /.+@.+\..+/.test(v) || "E-mail must be valid",
			},
			profileField: {
				name: 'Kiseki No Sedai',
				email: 'kiseki-kun@gmail.com',
				phone: '081234567890',
				address: 'Jeruk Purut',
				avatar: null,
			},
			resetPasswordField: {
				old_password: '',
				new_password: '',
				new_rpassword: '',
			},
		}),
		computed: {
			passwordMatch() {
				return this.resetPasswordField.new_password != this.resetPasswordField.new_rpassword ? "Password Does Not Match" : true;
			},
		},
		methods: {
			getImage(image) {
				return "http://localhost:8000/storage/" + image;
			},
			submit() {

			},
			clearProfile() {
				this.profileField.name = 'Kiseki No Sedai'
				this.profileField.email = 'kiseki-kun@gmail.com'
				this.profileField.phone = '081234567890'
				this.profileField.address = 'Jeruk Purut'
				this.profileField.avatar = null
			},
			clearPassword() {
				this.resetPasswordField.old_password = ''
				this.resetPasswordField.new_password = ''
				this.resetPasswordField.new_rpassword = ''
			}
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