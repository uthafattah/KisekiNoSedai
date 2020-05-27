<template>
	<v-card class="overflow-hidden" max-height="625" outlined>
		<v-progress-linear :active="loading" :indeterminate="loading" absolute top color="light-blue darken-1"></v-progress-linear>
		<v-row>
			<v-col cols="4" sm="4">
				<v-toolbar flat color="transparent">
					<v-toolbar-title class="ml-6 headline mb-n1 font-weight-bold">Messages</v-toolbar-title>
				</v-toolbar>
				<v-divider class="ml-4 mb-2" />
				<v-sheet id="scrolling-techniques-7" class="overflow-y-auto">
					<v-container id="scroll-target-user" style="height: 550px;">
						<v-list two-line v-scroll:#scroll-target-user>
							<template v-for="(item, index) in store_chat">
								<v-divider v-if="index != 0" :key="'store_chat' + index" inset></v-divider>
								<v-list-item :key="item.user_id" @click="chooseMessage(item.user_id)">
									<v-list-item-avatar>
										<v-img :src="getImage(item.avatar)" aspect-ratio="1"/>
									</v-list-item-avatar>
									<v-list-item-content>
										<v-list-item-title class="subtitle-1">{{item.name}}</v-list-item-title>
									</v-list-item-content>
								</v-list-item>
							</template>
						</v-list>
					</v-container>
				</v-sheet>
			</v-col>
			<v-col cols="8" sm="8">
				<v-toolbar flat color="transparent">
					<v-avatar size="36" v-if="header.avatar" style="margin-right:1em">
						<v-img :src="getImage(header.avatar)" aspect-ratio="1"/>
					</v-avatar>
					<span class="title font-weight-bold">{{header.name}}</span>
					<v-spacer/>
					<v-btn icon large @click="clearInbox" v-if="header.avatar" class="mr-1"><v-icon large>mdi-close-circle-outline</v-icon></v-btn>
				</v-toolbar>
				<v-divider class="mr-4 mb-2" />
				<v-sheet id="scrolling-techniques-8" class="overflow-y-auto" max-height="475">
					<v-container id="scroll-target-user" style="height: 550px;">
						<v-card flat v-for="(item, index) in messages"  :key="'messages' + index">
							<v-card class="d-flex flex-row mb-6" flat tile v-if="item.sender == 'User'">
								<v-card class="pa-2" outlined tile max-width="500" :color="theme ? 'grey darken-3' : 'grey lighten-3'">
									<v-list-item>
										<v-list-item-content>
											<div class="overline mb-4 font-weight-black">{{item.user_name}}</div>
											<v-list-item-subtitle>{{item.messages}}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
								</v-card>
							</v-card>
							<v-card class="d-flex flex-row-reverse mb-6" flat tile v-else>
								<v-card class="pa-2" outlined tile max-width="500" :color="theme ? 'green' : 'green lighten-3'">
									<v-list-item>
										<v-list-item-content>
											<div class="overline mb-4 font-weight-black">{{item.store_name}}</div>
											<v-list-item-subtitle>{{item.messages}}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
								</v-card>
							</v-card>
						</v-card>
					</v-container>
				</v-sheet>
				<v-text-field class="mr-6" outlined v-model="message" :append-outer-icon="message ? 'mdi-send' : 'mdi-microphone'" clear-icon="mdi-close-circle" clearable label="Message" type="text" @click:append-outer="sendMessage" @click:clear="clearMessage"></v-text-field>
				<!--v-text-field outlined label="Send a Message" class="mr-4" append-outer-icon="mdi-send"></v-text-field-->
			</v-col>
		</v-row>
	</v-card>
</template>
<script>
	import { mapActions, mapGetters } from 'vuex'
	export default {
		data: () => ({
			loading: true,
			store_chat: [],
			messages: [],
			message: '',
			header: {
				name: '',
				avatar: '',
			}
		}),
		created() {
			this.initialize()
			this.axios.get('http://localhost:8000/api/message/store_to_user')
			.then((res) => this.store_chat = res.data.store_chat)
			.catch((err) => {
				if(err.response.status == 401) {
					localStorage.removeItem('token');
					this.$router.push('/');
				}
				console.log(err)
			})
			this.loading = false
		},
		computed: {
			...mapGetters({
				store: 'store/getStore',
			}),
			theme() {
				return (this.$vuetify.theme.dark)
			}
		},
		methods: {
			...mapActions({

			}),
			getImage(image) {
				if(image != null && image.length > 0 && image != undefined) return "http://localhost:8000/storage/" + image;
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
			chooseMessage(id) {
				this.axios.get('http://localhost:8000/api/message/store_messages/' + id)
				.then((res) => {
					this.messages = res.data.message
					this.header.name = res.data.message[0].user_name
					this.header.avatar = res.data.message[0].avatar
				})
				.catch((err) => {
					if(err.response.status == 401) {
						localStorage.removeItem('token');
						this.$router.push('/');
					}
					console.log(err)
				})
			},
			sendMessage () {
				this.resetIcon()
				this.clearMessage()
			},
			clearInbox () {
				this.messages = []
				this.header.name = ''
				this.header.avatar = ''
			},
			clearMessage () {
				this.message = ''
			},
			resetIcon () {
				this.iconIndex = 0
			},
		}
	}
</script>
<style scoped></style>