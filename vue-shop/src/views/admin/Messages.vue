<template>
	<v-card class="overflow-hidden" max-height="625" outlined>
		<v-progress-linear :active="loading" :indeterminate="loading" absolute top color="light-blue darken-1"></v-progress-linear>
		<v-row>
			<v-col cols="4" sm="4">
				<v-toolbar flat>
					<v-toolbar-title>Messages</v-toolbar-title>
				</v-toolbar>
				<v-divider class="ml-4 mb-2" />
				<v-sheet id="scrolling-techniques-7" class="overflow-y-auto">
					<v-container id="scroll-target-user" style="height: 550px;">
						<v-list three-line v-scroll:#scroll-target-user>
							<template v-for="(item, index) in items">
								<v-divider v-if="item.divider" :key="index" :inset="item.inset"></v-divider>
								<!--v-list-item v-else :key="item.title" @click=""-->
								<v-list-item v-else :key="item.title">
									<v-list-item-avatar>
										<v-img :src="item.avatar"></v-img>
									</v-list-item-avatar>
									<v-list-item-content>
										<v-list-item-title v-html="item.title"></v-list-item-title>
										<v-list-item-subtitle v-html="item.subtitle"></v-list-item-subtitle>
									</v-list-item-content>
								</v-list-item>
							</template>
						</v-list>
					</v-container>
				</v-sheet>
			</v-col>
			<v-col cols="8" sm="8">
				<v-toolbar flat>
					<v-toolbar-title>Inbox</v-toolbar-title>
				</v-toolbar>
				<v-divider class="mr-4 mb-2" />
				<v-sheet id="scrolling-techniques-8" class="overflow-y-auto" max-height="475">
					<v-container id="scroll-target-user" style="height: 550px;">
						<v-card flat v-for="n in 10" :key="n">
							<v-card class="d-flex flex-row mb-6" flat tile>
								<v-card class="pa-2" outlined tile max-width="500" color="grey lighten-3">
									<v-list-item>
										<v-list-item-content>
											<div class="overline mb-4 font-weight-black">Jannah Gate</div>
											<v-list-item-subtitle>Greyhound divisely hello coldly fonwderfully</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
								</v-card>
							</v-card>
							<v-card class="d-flex flex-row-reverse mb-6" flat tile>
								<v-card class="pa-2" outlined tile max-width="500" color="green lighten-3">
									<v-list-item>
										<v-list-item-content>
											<div class="overline mb-4 font-weight-black">Kiseki No Sedai</div>
											<v-list-item-subtitle>Greyhound divisely hello coldly fonwderfully</v-list-item-subtitle>
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
	export default {
		data: () => ({
			loading: true,
			items: [
				{
					avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
					title: 'Jason Oner',
					subtitle: "I'll be in your neighborhood doing errands this weekend. Do you want to hang out?",
				},
				{ divider: true, inset: true },
				{
					avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg',
					title: 'Ranee Carlson',
					subtitle: "Wish I could come, but I'm out of town this weekend.",
				},
				{ divider: true, inset: true },
				{
					avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
					title: 'Cindy Baker',
					subtitle: "Do you have Paris recommendations? Have you ever been?",
				},
				{ divider: true, inset: true },
				{
					avatar: 'https://cdn.vuetifyjs.com/images/lists/4.jpg',
					title: 'Ali Connors',
					subtitle: "Have any ideas about what we should get Heidi for her birthday?",
				},
				{ divider: true, inset: true },
				{
					avatar: 'https://cdn.vuetifyjs.com/images/lists/5.jpg',
					title: 'Travis Howard',
					subtitle: "We should eat this: Grate, Squash, Corn, and tomatillo Tacos.",
				},
				{ divider: true, inset: true },
				{
					avatar: 'https://cdn.vuetifyjs.com/images/lists/4.jpg',
					title: 'Ba-bakaa!!',
					subtitle: "Have any ideas about what we should get Heidi for her birthday?",
				},
				{ divider: true, inset: true },
				{
					avatar: 'https://cdn.vuetifyjs.com/images/lists/5.jpg',
					title: 'Onii-chan',
					subtitle: "We should eat this: Grate, Squash, Corn, and tomatillo Tacos.",
				},
			],
			message: '',
		}),
		computed: {
			icon () {
				return this.icons[this.iconIndex]
			},
		},
		methods: {
			sendMessage () {
				this.resetIcon()
				this.clearMessage()
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