<template>
	<div>
		<v-navigation-drawer v-model="drawer" app clipped v-if="isAdmin || isStore">
			<v-list dense>
				<div v-if="isAdmin">
					<v-list-item v-for="item in admin_menu" :key="item.text" link :to="item.action">
						<v-list-item-action>
							<v-icon>{{ item.icon }}</v-icon>
						</v-list-item-action>
						<v-list-item-content>
							<v-list-item-title>
								{{ item.text }}
							</v-list-item-title>
						</v-list-item-content>
					</v-list-item>
				</div>
				<div v-else-if="isStore">
					<v-list-item v-for="item in store_menu" :key="item.text" link :to="item.action">
						<v-list-item-action>
							<v-icon>{{ item.icon }}</v-icon>
						</v-list-item-action>
						<v-list-item-content>
							<v-list-item-title>
								{{ item.text }}
							</v-list-item-title>
						</v-list-item-content>
					</v-list-item>
				</div>
				<v-list-item class="mt-4" link to="/" v-if="isAdmin || isStore">
					<v-list-item-action>
						<v-icon>mdi-tablet-dashboard</v-icon>
					</v-list-item-action>
					<v-list-item-title>Dashboard</v-list-item-title>
				</v-list-item>
				<v-list-item link v-if="isAdmin || isStore">
					<v-list-item-action>
						<v-switch v-model="theme"></v-switch>
					</v-list-item-action>
					<v-list-item-title>
						Switch Theme
					</v-list-item-title>
				</v-list-item>
			</v-list>
		</v-navigation-drawer>
		<v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" app color="light-blue darken-1" dark class="pr-3">
			<v-app-bar-nav-icon @click.stop="drawer = !drawer" v-if="isAdmin || isStore" />

			<v-btn text to="/admin" v-if="isAdmin" depressed>
				<v-toolbar-title>
					<span class="font-weight-black">ADMIN LARASHOP</span>
				</v-toolbar-title>
			</v-btn>
			<v-btn text to="/my-store" v-else-if="isStore" depressed>
				<v-toolbar-title>
					<span class="font-weight-black">JANNNAH GATE</span>
				</v-toolbar-title>
			</v-btn>
			<v-btn text to="/" large v-else depressed>
				<v-toolbar-title>
					<span class="font-weight-black">LARASHOP</span>
				</v-toolbar-title>
			</v-btn>

			<v-spacer v-if="!isCostumer" />
			<v-text-field flat solo-inverted hide-details prepend-inner-icon="mdi-magnify" label="Search" class="pl-3 pr-3" v-if="isCostumer" clear-icon="mdi-close-circle" clearable/>
			<v-btn icon text to="/carts" v-if="isCostumer">
				<v-icon>mdi-cart</v-icon>
			</v-btn>
			<!--Dialog v-if="!loggedIn" /-->
			<v-dialog v-model="dialog" max-width="600px" v-if="!loggedIn">
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
			<v-btn icon text to="/messages" v-if="isCostumer && loggedIn">
				<v-icon>mdi-email</v-icon>
			</v-btn>
			<v-menu open-on-hover offsetY v-if="loggedIn">
				<template v-slot:activator="{ on }">
					<v-btn icon v-on="on">
						<v-icon>mdi-bell</v-icon>
					</v-btn>
				</template>
				<v-list dense>
					<v-list-item v-for="(item, index) in notification" :key="index" link :to="item.action">
						<v-list-item-content>
							<v-list-item-title>
								{{ item.text }}
							</v-list-item-title>
						</v-list-item-content>
					</v-list-item>
				</v-list>
			</v-menu>
			<v-btn text @click="store" v-if="isCostumer && loggedIn">
				<v-avatar size="36">
					<!--v-img src="storage/logos/no_logo.png" aspect-ratio="1"></v-img-->
					<v-icon>mdi-store</v-icon>
				</v-avatar>
				<div style="margin-left:0.5em">Jannah Gate</div>
			</v-btn>
			<v-menu open-on-hover offsetY v-if="loggedIn">
				<template v-slot:activator="{ on }">
					<v-btn text v-on="on">
						<v-avatar size="36">
							<!--v-img src="storage/avatars/no_image.png" aspect-ratio="1"></v-img-->
							<v-icon>mdi-account</v-icon>
						</v-avatar>
						<div style="margin-left:0.5em">Kiseki no Sedai</div>
					</v-btn>
				</template>
				<v-list dense>
					<v-list-item v-for="(item, index) in profile_menu" :key="index" link :to="item.action">
						<v-list-item-action>
							<v-icon>{{ item.icon }}</v-icon>
						</v-list-item-action>
						<v-list-item-content>
							<v-list-item-title>
								{{ item.text }}
							</v-list-item-title>
						</v-list-item-content>
					</v-list-item>
					<v-divider class="mx-2" />
					<v-list-item link @click="logout">
						<v-list-item-action>
							<v-icon>mdi-logout</v-icon>
						</v-list-item-action>
						<v-list-item-title>Logout</v-list-item-title>
					</v-list-item>
				</v-list>
			</v-menu>
		</v-app-bar>
		<!--Alert :alerts="alerts" v-if="isAlert"/-->
		<v-snackbar v-model="snackbar" :color="alert.color" class="top mb-12">
			{{alert.text}}
			<v-btn dark text @click="snackbar = false">
				<v-icon>mdi-close-circle</v-icon>
			</v-btn>
		</v-snackbar>
	</div>
</template>

<script>
	//import Dialog from '@/components/Dialog'
	export default {
		props: {
			source: String,
		},
		components: {
			//Dialog,
			//Alert: () => import( /* webpackChunkName: "alert" */ '@/components/Alert.vue'),
		},
		data: () => ({
			drawer: true,
			theme: false,
			loggedIn: false,
			//---------------
			loading: false,
			dialog: false,
			tab: null,
			valid_login: false,
			valid_register: false,
			login_password: false,
			register_password: false,
			register_rpassword: false,
			success: '',
			error: '',
			//---------------
            snackbar: false,
			alert: {
				text: '',
				color: '',
				status: false,
			},
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
			profile_menu: [
				{
					icon: 'mdi-account-cog',
					text: 'Account Settings',
					action: '/settings'
				},
				{
					icon: 'mdi-monitor-dashboard',
					text: 'Admin',
					action: '/admin'
				},
				{
					icon: 'mdi-heart',
					text: 'Wishlists',
					action: 'wishlists'
				},
				{
					icon: 'mdi-package',
					text: 'My Order',
					action: '/orders'
				},
			],
			notification: [
				{
					text: 'Checkout',
					action: '/checkout'
				},
				{
					text: 'Merchandise',
					action: '/merchandise'
				},
				{
					text: 'Stores',
					action: '/stores'
				},
				{
					text: 'Promos',
					action: '/promos'
				},
			],
			admin_menu: [
				{
					icon: 'mdi-account-group',
					text: 'Users',
					action: '/admin/users'
				}, 
				{
					icon: 'mdi-animation-outline',
					text: 'Roles',
					action: '/admin/roles'
				}, 
				{
					icon: 'mdi-briefcase-edit-outline',
					text: 'Categories',
					action: '/admin/categories'
				}, 
				{
					icon: 'mdi-store',
					text: 'Stores',
					action: '/admin/stores'
				}, 
				{
					icon: 'mdi-wallet',
					text: 'Payments',
					action: '/admin/payments'
				}, 
				{
					icon: 'mdi-ticket-percent',
					text: 'Promos',
					action: '/admin/promos'
				}, 
				{
					icon: 'mdi-sticker-check',
					text: 'Status Store',
					action: '/admin/status-store'
				}, 
				{
					icon: 'mdi-truck-check',
					text: 'Status Order',
					action: '/admin/status-order'
				}, 
				{
					icon: 'mdi-email',
					text: 'Messages',
					action: '/admin/messages'
				},
			],
			store_menu: [
				{
					icon: 'mdi-gift',
					text: 'Merchandise',
					action: '/my-store/merchandise'
				}, 
				{
					icon: 'mdi-package',
					text: 'Orders',
					action: '/my-store/orders'
				},
				{
					icon: 'mdi-book-multiple',
					text: 'Reports',
					action: '/my-store/reports'
				},
				{
					icon: 'mdi-email',
					text: 'Messages',
					action: '/my-store/messages'
				},
				{
					icon: 'mdi-cog',
					text: 'Store Settings',
					action: '/my-store/settings'
				},
			],
		}),
		created() {
			this.loggedIn = localStorage.getItem('token') ? true : false
			this.$vuetify.theme.dark = false
		},
		watch: {
			theme: function(old) {
				this.$vuetify.theme.dark = old;
			}
		},
		mounted() {
            //this.snackbar = localStorage.getItem('loggedIn') ? true : false;
			localStorage.getItem('loggedIn') ? true : false;
			localStorage.removeItem('loggedIn');
		},
		methods: {
			store: function() {
				this.$router.push('/my-store')
			},
			clear: function () {
				this.loginField.email = ''
				this.loginField.password = ''
				this.registerField.name = ''
				this.registerField.email = ''
				this.registerField.password = ''
				this.registerField.created_at = ''
				this.registerField.updated_at = ''
			},
			login: function() {
				this.axios.interceptors.request.use((config) => {
					this.loading = true; 
					return config;
				}, (error) => {
					this.loading = false;
					return Promise.reject(error);
				});

				this.axios.interceptors.response.use((response) => {
					this.loading = false;
					return response;
				}, (error) => {
					this.loading = false;
					return Promise.reject(error);
				});
				this.axios.post('http://localhost:8000/api/login', {'email': this.loginField.email, 'password': this.loginField.password})
				.then(res => {
					localStorage.setItem('token', res.data.token) 
					localStorage.setItem('loggedIn', true)
					this.loggedIn = localStorage.getItem('token') ? true : false
					if(res.data.isAdmin) {
						localStorage.setItem('role', 1)
						this.alert.text = "LoggedIn as Admin Successfully"
						this.alert.color = "success"
					} else if (res.data.isStaff) {
						this.alert.text = "LoggedIn as Staff Successfully"
						this.alert.color = "success"
						localStorage.setItem('role', 2)
					} else if (res.data.isCostumer) {
						this.alert.text = "LoggedIn Successfully"
						this.alert.color = "success"
						localStorage.setItem('role', 3)
					} else {
						console.log('LoggedIn Role Wrong')
					}
					this.snackbar = true
					this.dialog = false
					this.clear()
					/*else {
						this.text = "You Need to be LoggedIn as an Administrator";
						//this.snackbar = true
						console.log(this.text)
					}*/
				}).catch(err => {
					this.alert.text = err.response.data.status
					this.alert.color = "success"
				})
					this.alert.status = true
			},
			logout: function() {
				localStorage.removeItem('token');
				localStorage.removeItem('role');
				this.loggedIn = localStorage.getItem('token') ? true : false
				
				//this.$router.push('/')
					//.then(res => {
						this.alert.text = "You are Logged Out Successfully";
						this.alert.color = "success"
						this.snackbar = true
						//console.log(res)
					//})
					//.catch(err => console.log(err))
			},
		},
		computed: {
			passwordMatch() {
				return this.registerField.password != this.registerField.rpassword ? "Password Does Not Match" : true;
			},
			isCostumer () {
				return ( 
					this.$route.path == '/' ||
					this.$route.path == '/carts' ||
					this.$route.path == '/checkout' ||
					this.$route.path == '/merchandise' ||
					this.$route.path == '/messages' ||
					this.$route.path == '/orders' ||
					this.$route.path == '/promos' ||
					this.$route.path == '/settings' ||
					this.$route.path == '/stores' ||
					this.$route.path == '/wishlists'
				)
			},
			isAdmin () {
				return ( 
					this.$route.path == '/admin' ||
					this.$route.path == '/admin/categories' ||
					this.$route.path == '/admin/messages' ||
					this.$route.path == '/admin/payments' ||
					this.$route.path == '/admin/promos' ||
					this.$route.path == '/admin/roles' ||
					this.$route.path == '/admin/status-store' ||
					this.$route.path == '/admin/status-order' ||
					this.$route.path == '/admin/stores' ||
					this.$route.path == '/admin/users'
				)
			},
			isStore () {
				return ( 
					this.$route.path == '/my-store' ||
					this.$route.path == '/my-store/merchandise' ||
					this.$route.path == '/my-store/messages' ||
					this.$route.path == '/my-store/orders' ||
					this.$route.path == '/my-store/reports' ||
					this.$route.path == '/my-store/settings'
				)
			},
		},
	}
</script>
<style scoped>
	.v-btn:before {
		background-color: transparent;
	}
	
	a.v-btn--active {
		box-shadow: none;
		border: none;
		background: transparent;
	}
</style>