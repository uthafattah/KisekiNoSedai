export default {
	namespaced: true,
	state: {
		store_menu: [
			{ icon: 'mdi-gift', text: 'Merchandise', action: '/my-store/merchandise' }, 
			{ icon: 'mdi-package', text: 'Orders', action: '/my-store/orders' },
			{ icon: 'mdi-email', text: 'Messages', action: '/my-store/messages' },
			{ icon: 'mdi-cog', text: 'Store Settings', action: '/my-store/settings' },
		],
		admin_menu: [
			{ icon: 'mdi-account-group', text: 'Users', action: '/admin/users' }, 
			{ icon: 'mdi-animation-outline', text: 'Roles', action: '/admin/roles' }, 
			{ icon: 'mdi-briefcase-edit-outline', text: 'Categories', action: '/admin/categories' }, 
			{ icon: 'mdi-store', text: 'Stores', action: '/admin/stores' }, 
			{ icon: 'mdi-wallet', text: 'Payments', action: '/admin/payments' }, 
			{ icon: 'mdi-ticket-percent', text: 'Promos', action: '/admin/promos' }, 
			{ icon: 'mdi-sticker-check', text: 'Status Store', action: '/admin/status-store' }, 
			{ icon: 'mdi-truck-check', text: 'Status Order', action: '/admin/status-order' },
		],
		profile_menu: [
			{ icon: 'mdi-account-cog', text: 'Account Settings', action: '/settings' },
			{ icon: 'mdi-heart', text: 'Wishlists', action: '/wishlists' },
			{ icon: 'mdi-package', text: 'My Order', action: '/orders' },
		],
		notification: [
			{ text: 'Checkout', action: '/checkout' },
			{ text: 'Promos', action: '/promos' },
		],
	},
	getters: {
		getStoreMenu: state => {
			return state.store_menu
		},
		getAdminMenu: state => {
			return state.admin_menu
		},
		getProfileMenu: state => {
			return state.profile_menu
		},
		getNotification: state => {
			return state.notification
		},
	},
}
