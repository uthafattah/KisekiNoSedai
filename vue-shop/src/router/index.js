import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

	const routes = [
	{
		path: '/',
		name: 'Home',
		component: () => import( /*webpackChunkName: "about"*/ '../views/Home.vue'),
		children: [
			{
				path: 'carts',
				name: 'Carts',
				component: () => import( /*webpackChunkName: "about"*/ '../views/costumer/Carts.vue')
			},
			{
				path: 'checkout',
				name: 'Checkout',
				component: () => import( /*webpackChunkName: "about"*/ '../views/costumer/Checkout.vue')
			},
			{
				path: 'merchandise',
				name: 'Merchandise',
				component: () => import( /*webpackChunkName: "about"*/ '../views/costumer/Merchandise.vue')
			},
			{
				path: 'messages',
				name: 'Messages',
				component: () => import( /*webpackChunkName: "about"*/ '../views/costumer/Messages.vue')
			},
			{
				path: 'orders',
				name: 'Orders',
				component: () => import( /*webpackChunkName: "about"*/ '../views/costumer/Orders.vue')
			},
			{
				path: 'promos',
				name: 'Promos',
				component: () => import( /*webpackChunkName: "about"*/ '../views/costumer/Promos.vue')
			},
			{
				path: 'reports',
				name: 'Reports',
				component: () => import( /*webpackChunkName: "about"*/ '../views/costumer/Reports.vue')
			},
			{
				path: 'settings',
				name: 'Settings',
				component: () => import( /*webpackChunkName: "about"*/ '../views/costumer/Settings.vue')
			},
			{
				path: 'stores',
				name: 'Stores',
				component: () => import( /*webpackChunkName: "about"*/ '../views/costumer/Stores.vue')
			},
			{
				path: 'wishlists',
				name: 'Wishlists',
				component: () => import( /*webpackChunkName: "about"*/ '../views/costumer/Wishlists.vue')
			},
		]
	},
	{
		path: '/my-store',
		name: 'My Store',
		component: () => import( /*webpackChunkName: "about"*/ '../views/store/MyStore.vue'),
		children: [
			{
				path: 'messages',
				name: 'Messages',
				component: () => import( /*webpackChunkName: "about"*/ '../views/store/Messages.vue')
			},
			{
				path: 'orders',
				name: 'Orders',
				component: () => import( /*webpackChunkName: "about"*/ '../views/store/Orders.vue')
			},
			{
				path: 'reports',
				name: 'Reports',
				component: () => import( /*webpackChunkName: "about"*/ '../views/store/Reports.vue')
			},
			{
				path: 'merchandise',
				name: 'Merchandise',
				component: () => import( /*webpackChunkName: "about"*/ '../views/store/Merchandise.vue')
			},
			{
				path: 'settings',
				name: 'Settings',
				component: () => import( /*webpackChunkName: "about"*/ '../views/store/Settings.vue')
			},
		]
	},
	{
		path: '/admin',
		name: 'Admin',
		component: () => import( /*webpackChunkName: "about"*/ '../views/admin/Admin.vue'),
		children: [
			{
				path: 'categories',
				name: 'Categories',
				component: () => import( /*webpackChunkName: "about"*/ '../views/admin/Categories.vue')
			},
			{
				path: 'messages',
				name: 'Messages',
				component: () => import( /*webpackChunkName: "about"*/ '../views/admin/Messages.vue')
			},
			{
				path: 'payments',
				name: 'Payments',
				component: () => import( /*webpackChunkName: "about"*/ '../views/admin/Payments.vue')
			},
			{
				path: 'promos',
				name: 'Promos',
				component: () => import( /*webpackChunkName: "about"*/ '../views/admin/Promos.vue')
			},
			{
				path: 'roles',
				name: 'Roles',
				component: () => import( /*webpackChunkName: "about"*/ '../views/admin/Roles.vue')
			},
			{
				path: 'stores',
				name: 'Stores',
				component: () => import( /*webpackChunkName: "about"*/ '../views/admin/Stores.vue')
			},
			{
				path: 'status-store',
				name: 'Status Store',
				component: () => import( /*webpackChunkName: "about"*/ '../views/admin/StatusStore.vue')
			},
			{
				path: 'status-order',
				name: 'Status Order',
				component: () => import( /*webpackChunkName: "about"*/ '../views/admin/StatusOrder.vue')
			},
			{
				path: 'users',
				name: 'Users',
				component: () => import( /*webpackChunkName: "about"*/ '../views/admin/Users.vue')
			},
		]
	},
]

const router = new VueRouter({
	mode: 'history',
	base: process.env.BASE_URL,
	routes
})

export default router
