<template>
	<v-app id="inspire">
		<v-card class="overflow-hidden">
			<v-progress-linear :active="loading" :indeterminate="loading" absolute top color="light-blue darken-1"></v-progress-linear>
			<v-row>
				<v-col cols="4" sm="4" outlined>
					<v-toolbar flat>
						<v-toolbar-title>Messages</v-toolbar-title>
					</v-toolbar>
					<v-sheet id="scrolling-techniques-7" class="overflow-y-auto" max-height="600">
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
					<v-sheet id="scrolling-techniques-8" class="overflow-y-auto" max-height="600">
						<v-container id="scroll-target-message" style="height: 550px;">
						</v-container>
					</v-sheet>
				</v-col>
			</v-row>
		</v-card>
	</v-app>
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
			],
		}),
	}
</script>
<style scoped></style>