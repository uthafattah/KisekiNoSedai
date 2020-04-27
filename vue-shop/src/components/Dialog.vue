<template>
	<v-dialog v-model="dialog" max-width="600px">
		<template v-slot:activator="{ on }">
			<v-btn text icon v-on="on">
				<v-icon>mdi-login</v-icon>
			</v-btn>
		</template>
		<v-card>
			<v-tabs fixed-tabs v-model="tab" background-color="light-blue darken-1" centered dark icons-and-text>
				<v-progress-linear :active="loading" :indeterminate="loading" absolute top color="white accent-4"></v-progress-linear>
				<v-tabs-slider></v-tabs-slider>
				<v-tab href="#tab-login">
					Login
				</v-tab>
				<v-tab href="#tab-register">
					Register
				</v-tab>
			</v-tabs>
			<v-tabs-items v-model="tab">
				<v-tab-item :value="'tab-login'">
					<v-card flat>
						<v-card-text>
							<v-form ref="form" v-model="valid_login">
								<v-text-field  color="light-blue darken-1" label="Email" v-model="loginField.email" :rules="[rules.required, rules.validEmail]" name="email" prepend-icon="mdi-email" type="email" autocomplete="off" />
								<v-text-field color="light-blue darken-1" label="Password" v-model="loginField.password" :rules="[rules.required, rules.min]" name="password" prepend-icon="mdi-lock" :append-icon="login_password ? 'mdi-eye' : 'mdi-eye-off'" :type="login_password ? 'text' : 'password'" @click:append="login_password = !login_password" autocomplete="off" />
							</v-form>
						</v-card-text>
						<v-card-actions>
							<v-btn type="submit" color="light-blue darken-1" :disabled="!valid_login" block @click.prevent="login" class="title white--text">Login</v-btn>
						</v-card-actions>
					</v-card>
				</v-tab-item>
				<v-tab-item :value="'tab-register'">
					<v-card flat>
						<v-card-text>
							<v-form ref="form" v-model="valid_register">
								<v-text-field :rules="[rules.required, rules.min]" label="Name" prepend-icon="mdi-account" autocomplete="off" />
								<v-text-field type="email" :success-messages="success" :error-messages="error" :rules="[rules.required, rules.validEmail]" label="Email" prepend-icon="mdi-email" autocomplete="off" />
								<!--v-text-field type="email" :success-messages="success" :error-messages="error" :rules="[rules.required, rules.validEmail]" :blur="checkEmail" label="Email" prepend-icon="mdi-email" autocomplete="off" /-->
								<v-text-field :append-icon="register_password ? 'mdi-eye' : 'mdi-eye-off'" :type="register_password ? 'text' : 'password'" @click:append="register_password = !register_password" :rules="[rules.required, rules.min]" v-model="registerField.password" label="Type Password" autocomplete="off" prepend-icon="mdi-lock" />
								<v-text-field :append-icon="register_rpassword ? 'mdi-eye' : 'mdi-eye-off'" :type="register_rpassword ? 'text' : 'password'" @click:append="register_rpassword = !register_rpassword" :rules="[rules.required, passwordMatch]" v-model="registerField.rpassword" label="Retype Password" prepend-icon="mdi-lock-check" autocomplete="off" />
							</v-form>
						</v-card-text>
						<v-card-actions>
							<v-btn type="submit" color="light-blue darken-1" :disabled="!valid_register" block @click.prevent="register" class="title white--text">Register</v-btn>
						</v-card-actions>
					</v-card>
				</v-tab-item>
			</v-tabs-items>
		</v-card>
	</v-dialog>
</template>
<script>
	export default {
		data: () => ({
			loading: false,
			dialog: false,
			tab: null,
			valid_login: false,
			valid_register: false,
			success: '',
			error: '',
			login_password: false,
			register_password: false,
			register_rpassword: false,
			rules: {
				required: v => !!v || "This Field Required",
				min: v => v.length >= 5 || "Minimum 5 Characters Required",
				validEmail: v => /.+@.+\..+/.test(v) || "E-mail must be valid",
			},
			loginField: {
				email: '',
				password: '',
			},
			registerField: {
				name: '',
				email: '',
				password: '',
				created_at: '',
				updated_at: '',
			},
		}),
		computed: {
			passwordMatch() {
				return this.registerField.password != this.registerField.rpassword ? "Password Does Not Match" : true;
			},
			/*checkEmail() {
				if (/.+@.+\..+/.test(this.editedItem.email)) {
					axios.post("/api/email/verify", { email: this.editedItem.email })
					.then(res => {
						this.success = res.data.message;
						this.error = "";
					})
					.catch(err => {
						this.success = "";
						this.error = "Email Already Exists";
					});
				} else {
					this.success = "";
					this.error = "";
				}
			},*/
		}
	};
</script>