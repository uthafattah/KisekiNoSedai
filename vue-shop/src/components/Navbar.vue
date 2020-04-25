<template>
	<div>
		<v-navigation-drawer v-model="drawer" app clipped v-if="!isCostumer" >
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
				<v-list-item class="mt-4" link to="/">
					<v-list-item-action>
						<v-icon>mdi-tablet-dashboard</v-icon>
					</v-list-item-action>
					<v-list-item-title>Dashboard</v-list-item-title>
				</v-list-item>
				<v-list-item link>
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
			<v-app-bar-nav-icon @click.stop="drawer = !drawer" v-if="!isCostumer" />

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
			<v-text-field flat solo-inverted hide-details prepend-inner-icon="mdi-magnify" label="Search" class="pl-3 pr-3" v-if="isCostumer" />
			<v-btn icon text to="/carts" v-if="isCostumer">
				<v-icon>mdi-cart</v-icon>
			</v-btn>
			<Dialog v-if="isCostumer" />
			<v-menu open-on-hover offsetY>
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
			<v-btn icon text to="/messages" v-if="isCostumer">
				<v-icon>mdi-email</v-icon>
			</v-btn>
			<v-btn text @click="store" v-if="isCostumer">
				<v-avatar size="36">
					<!--v-img src="storage/logos/no_logo.png" aspect-ratio="1"></v-img-->
					<v-icon>mdi-store</v-icon>
				</v-avatar>
				<div style="margin-left:0.5em">Jannah Gate</div>
			</v-btn>
			<v-menu open-on-hover offsetY>
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
				</v-list>
			</v-menu>
		</v-app-bar>
	</div>
</template>

<script>
	import Dialog from '@/components/Dialog'
	export default {
		props: {
			source: String,
		},
		components: {
			Dialog
		},
		data: () => ({
			drawer: true,
            theme: false,
			profile_menu: [
				{
					icon: 'mdi-account-cog',
					text: 'Account Settings',
					action: '/settings'
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
				{
					icon: 'mdi-logout',
					text: 'Logout',
					action: '/'
				},
			],
			notification: [
				{
					text: 'Admin',
					action: '/admin'
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
				{
					text: 'Reports',
					action: '/reports'
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
            this.$vuetify.theme.dark = false
        },
        watch: {
            theme: function(old) {
                this.$vuetify.theme.dark = old;
            }
        },
		computed: {
			isCostumer () {
				return (
					this.$route.path == '/' ||
					this.$route.path == '/carts' ||
					this.$route.path == '/checkout' ||
					this.$route.path == '/merchandise' ||
					this.$route.path == '/messages' ||
					this.$route.path == '/orders' ||
					this.$route.path == '/promos' ||
					this.$route.path == '/reports' ||
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
			}
		},
		methods:
		{
			store: function() {
				this.$router.push('/my-store')
			},
		}
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