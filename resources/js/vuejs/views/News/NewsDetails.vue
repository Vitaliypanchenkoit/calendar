<template>
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<go-home-button></go-home-button>
				<div class="success mb-4">{{ successMessage }}</div>
				<div class="form-item mb-2">
						<label for="title">Title</label>
						<div id="title" class="flex-grow fake-input">{{ title }}</div>
				</div>
				<div class="form-item mb-2">
						<label>Date</label>
						<div id="date" class="flex-grow fake-input">{{ date }}</div>
				</div>
				<div class="form-item mb-2">
						<label>Time</label>
						<div id="time" class="flex-grow fake-input">{{ time }}</div>
				</div>
				<div class="form-item mb-2">
						<label for="content">Content</label>
						<div id="content" class="flex-grow fake-textarea">{{ content }}</div>
				</div>

				<div v-if="$parent.currentUser.id !== author_id" class="body-item__control">
						<label>
								<input type="checkbox" :checked="read.includes($parent.currentUser.id)" @change="markNews(id, 'read', !read.includes($parent.currentUser.id))">
								<span>Mark as read</span>
						</label>&#160;&#160;
						<label>
								<input type="checkbox" :checked="important.includes($parent.currentUser.id)" @change="markNews(id,'important', !important.includes($parent.currentUser.id))">
								<span>Mark as important</span>
						</label>
				</div>
		</div>

</template>

<script>
import GoHomeButton from "../../components/GoHomeButton";
import {mapState} from "vuex";
import {actionTypes} from "../../store/modules/news";
export default {
		name: "NewsDetails",
		props: {
				id: {
						type: Number,
						default: 0
				}
		},
		components: {
				GoHomeButton,
		},
		data() {
				return {
						prevRoute: {path: ''},
				}
		},
		computed: {
				...mapState({
						isLoading: state => state.news.isLoading,
						errors: state => state.news.errors,
						successMessage: state => state.news.successMessage,
				}),
				author_id: {
						get () {
								return this.$store.state.news.singleNewsData.author_id
						},
				},
				title: {
						get () {
								return this.$store.state.news.singleNewsData.title
						},
				},
				content: {
						get () {
								return this.$store.state.news.singleNewsData.content
						},
				},
				date: {
						get () {
								return this.$store.state.news.singleNewsData.date
						},
				},
				time: {
						get () {
								return this.$store.state.news.singleNewsData.time
						},
				},
				read: {
						get () {
								return this.$store.state.news.singleNewsData.read
						},
				},
				important: {
						get () {
								return this.$store.state.news.singleNewsData.important
						},
				},
		},
		created() {
				this.$store.dispatch(actionTypes.getSingleNews, {id: this.id});
		},
		beforeRouteEnter(to, from, next) {
				next(vm => {
						vm.prevRoute = from
				})
		},
		methods: {
				markNews(id, key, value) {
						this.$store.dispatch(actionTypes.markNews, {id, key, value})
				}
		}
}
</script>

<style scoped>

</style>
