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
				<v-divider class="mx-2" />
				<v-list-item link to="/" v-if="isAdmin || isStore">
					<v-list-item-action>
						<v-icon>mdi-tablet-dashboard</v-icon>
					</v-list-item-action>
					<v-list-item-title>Dashboard</v-list-item-title>
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
					<span class="font-weight-black" v-if="store">{{store.name}} STORE</span>
					<span class="font-weight-black" v-else>Open Your Store!</span>
				</v-toolbar-title>
			</v-btn>
			<v-btn text to="/" large v-else depressed>
				<v-toolbar-title>
					<span class="font-weight-black">LARASHOP</span>
				</v-toolbar-title>
			</v-btn>

			<v-spacer v-if="isAdmin || isStore" />

			<v-text-field flat solo-inverted hide-details prepend-inner-icon="mdi-magnify" label="Search" class="pl-3 pr-3" v-if="!isAdmin && !isStore" clear-icon="mdi-close-circle" clearable @input="searchIt" />

			<v-btn icon text to="/carts" v-if="(!isAdmin && !isStore) && loggedIn">
				<v-badge :content="qty" :value="qty" color="green" overlap v-if="qty != 0"><v-icon>mdi-cart</v-icon></v-badge>
				<v-badge dot color="green" overlap v-else><v-icon>mdi-cart</v-icon></v-badge>
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
						<v-tabs-slider :class="{'slider': theme}"></v-tabs-slider>
						<v-tab href="#tab-login" :class="{'tab': theme}">
							Login
						</v-tab>
						<v-tab href="#tab-register" :class="{'tab': theme}">
							Register
						</v-tab>
					</v-tabs>
					<v-tabs-items v-model="tab">
						<v-tab-item :value="'tab-login'">
							<v-card flat>
								<v-card-text>
									<v-form ref="form_login" v-model="valid_login">
										<v-text-field  color="light-blue darken-1" label="Email" v-model="loginField.email" :rules="[rules.required, rules.validEmail]" name="email" prepend-icon="mdi-email" type="email" autocomplete="off" />
										<v-text-field color="light-blue darken-1" label="Password" v-model="loginField.password" :rules="[rules.required, rules.min]" name="password" prepend-icon="mdi-lock" :append-icon="login_password ? 'mdi-eye' : 'mdi-eye-off'" :type="login_password ? 'text' : 'password'" @click:append="login_password = !login_password" autocomplete="off" />
									</v-form>
								</v-card-text>
								<v-card-actions>
									<v-btn type="submit" color="light-blue darken-1" :disabled="!valid_login" block @click.prevent="login(loginField)" class="title white--text">Login</v-btn>
								</v-card-actions>
							</v-card>
						</v-tab-item>
						<v-tab-item :value="'tab-register'">
							<v-card flat>
								<v-card-text>
									<v-form ref="form_register" v-model="valid_register">
										<v-text-field :rules="[rules.required, rules.min]" label="Name" v-model="registerField.name" prepend-icon="mdi-account" autocomplete="off" />
										<v-text-field type="email" :success-messages="success" v-model="registerField.email" :error-messages="error" :rules="[rules.required, rules.validEmail]" :blur="checkEmail" label="Email" prepend-icon="mdi-email" autocomplete="off" />
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
			<v-btn icon text to="/messages" v-if="(!isAdmin && !isStore) && loggedIn">
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
			<v-btn text @click="storePage" v-if="(!isAdmin && !isStore) && loggedIn">
				<v-avatar size="28" v-if="store">
					<v-img :src="getImage(store.logo)" aspect-ratio="1"/>
				</v-avatar>
				<v-avatar size="36" v-else>
					<v-icon>mdi-store</v-icon>
				</v-avatar>
				<div style="margin-left:0.5em" v-if="store">{{store.name}}</div>
				<div style="margin-left:0.5em" v-else>Open Your Store!</div>
			</v-btn>
			<v-menu open-on-hover offsetY v-if="loggedIn">
				<template v-slot:activator="{ on }">
					<v-btn text v-on="on">
						<v-avatar size="28">
							<v-img :src="getImage(avatar)" aspect-ratio="1"></v-img>
						</v-avatar>
						<div style="margin-left:0.5em">{{user.name}}</div>
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
					<v-list-item>
						<v-list-item-action>
							<v-switch dense v-model="theme"></v-switch>
						</v-list-item-action>
						<v-list-item-title class="ml-n2">
							Switch Theme
						</v-list-item-title>
					</v-list-item>
					<v-list-item link to="/admin" v-if="roleAdmin">
						<v-list-item-action>
							<v-icon>mdi-monitor-dashboard</v-icon>
						</v-list-item-action>
						<v-list-item-title>Admin</v-list-item-title>
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
	</div>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	export default {
		components: {
			//Dialog: () => import(/* webpackChunkName: "dialog" */ '@/components/Dialog.vue'),
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
			rules: {
				required: v => !!v || "This Field Required",
				min: v => (v && v.length >= 5) || "Minimum 5 Characters Required",
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
				rpassword: '',
			},
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
		methods: {
			...mapActions({
				setAuth: 'auth/set',
				setStore: 'store/set',
				setCart: 'cart/set',
				setWishlist: 'wishlist/set',
				setAlert: 'alert/set',
				searchMerchandise: 'search/searchMerchandise',
				searchStore: 'search/searchStore',
				search: 'search/search'
			}),
			storePage: function() {
				this.$router.push('/my-store')
			},
			searchIt(e) {
				if(e) {
					this.search(e)
					if(e.length > 2) {
						this.axios.get(`http://localhost:8000/api/merchandise/find/${e}`)
						.then(res => this.searchMerchandise(res.data.merchandise))
						.catch(err => console.dir(err.response))

						this.axios.get(`http://localhost:8000/api/store/find/${e}`)
						.then(res => this.searchStore(res.data.store))
						.catch(err => console.dir(err.response))
					}
				} else {
					this.searchMerchandise([])
					this.axios.get('http://localhost:8000/api/merchandise/top/40')
					.then((res) => this.searchMerchandise(res.data.merchandise))
					.catch((err) => console.log(err.response))
					this.searchStore([])
					this.search('')
				}
				if(this.$route.path != "/") this.$router.push('/')
			},
			login: function() {
				this.initialize()
				this.axios.post('http://localhost:8000/api/login', {'email': this.loginField.email, 'password': this.loginField.password})
				.then(res => {
					localStorage.setItem('token', res.data.token) 
					localStorage.setItem('loggedIn', true)
					this.setAuth(res.data.user)
					this.setStore(res.data.store)
					this.setAlert({status: true, color: 'success', text: 'LoggedIn Successfully'})
					this.loggedIn = localStorage.getItem('token') ? true : false
					this.dialog = false
				}).catch(err => {
					this.setAlert({status: true, color: 'error', text: err.response.data.status})
				})
				if(this.$refs.form_login) this.$refs.form_login.reset()
				if(this.$refs.register) this.$refs.form_register.reset()
			},
			register: function() {
				this.initialize()
				this.axios.post('http://localhost:8000/api/register', this.registerField)
				.then(res => {
					console.log(res.response)
					this.setAlert({status: true, color: 'success', text: 'Register Successfully! Please Login Again!'})
					this.dialog = false
				})
				.catch(err => {
					console.log(err.response)
					this.setAlert({status: true, color: 'error', text: 'Register Failed!'})
				})
				if(this.$refs.form_login) this.$refs.form_login.reset()
				if(this.$refs.register) this.$refs.form_register.reset()
			},
			logout: function() {
				this.initialize()
				localStorage.removeItem('token');
				this.loggedIn = localStorage.getItem('token') ? true : false
				this.setAlert({status: true, color: 'success', text: 'You are Logged Out Successfully'})
				this.dialog = false
				this.setAuth({})
				this.setStore({})
				this.setCart([])
				this.setWishlist([])
				if(this.$route.path != "/") this.$router.push('/')
			},
			verifyEmail() {
				if (/.+@.+\..+/.test(this.registerField.email)) {
					this.axios.post("http://localhost:8000/api/email/verify", { email: this.registerField.email })
					.then(res => {
						this.success = res.data.message;
						this.error = "";
					})
					.catch(err => {
						console.log(err.response)
						this.success = "";
						this.error = "Email Already Exists";
					});
				} else {
					this.success = "";
					this.error = "";
				}
			},
			initialize () {
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
			},
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
			},
		},
		computed: {
			...mapGetters({
				user: 'auth/getData',
				avatar: 'auth/getAvatar',
				role: 'auth/getRole',
				store: 'store/getStore',
				qty: 'cart/getQuantity',
				store_menu: 'menu/getStoreMenu',
				admin_menu: 'menu/getAdminMenu',
				profile_menu: 'menu/getProfileMenu',
				notification: 'menu/getNotification',
			}),
			checkEmail() {
				return this.verifyEmail()
			},
			passwordMatch() {
				return this.registerField.password != this.registerField.rpassword ? "Password Does Not Match" : true;
			},
			isCostumer () {
				return this.$store.getters.isCostumer(this.$route.path)
			},
			isAdmin () {
				return this.$store.getters.isAdmin(this.$route.path)
			},
			isStore () {
				return this.$store.getters.isStore(this.$route.path)
			},
			roleAdmin() {
				return this.role === 1 ? true : false
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
	.tab {
		color: white;
		/*background-color: #212121;*/
	}
	.slider {
		color: white;
	}
</style>