<template>
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<go-home-button></go-home-button>
				<div class="success mb-4">{{ successMessage }}</div>
				<div class="form-item mb-2">
						<label for="title">Title</label>
						<input id="title" class="flex-grow" v-model="title" v-if="!id"/>
						<div class="disabled-input" v-else>{{ title }}</div>
						<span class="text-red-600" v-if="errors.title">{{ errors.title[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<label for="content">Content</label>
						<textarea id="content" class="flex-grow" rows="8" v-model="content" v-if="!id"></textarea>
						<div class="disabled-textarea" v-else>{{ content }}</div>
						<span class="text-red-600" v-if="errors.content">{{ errors.content[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<div v-if="!id" class="save-button" @click="submit()">Create</div>
						<div v-else class="save-button" @click="submit()">Update</div>
				</div>
		</div>

</template>

<script>
import GoHomeButton from "../../components/GoHomeButton";
import {mapState} from "vuex";
import {actionTypes} from "../../store/modules/news";

export default {
		name: "CreateEditNews",
		props: {
				id: {
						type: Number,
						default: 0
				}
		},
		components: {
				GoHomeButton
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
				title: {
						get () {
								return this.$store.state.news.singleNewsData.title
						},
						set (value) {
								this.$store.dispatch(actionTypes.getInputValue, {name: 'title', value: value})
						}
				},
				content: {
						get () {
								return this.$store.state.news.singleNewsData.content
						},
						set (value) {
								this.$store.dispatch(actionTypes.getInputValue, {name: 'content', value: value})
						}
				},
				date: {
						get () {
								return this.$store.state.news.singleNewsData.date
						},
						set (value) {
								this.$store.dispatch(actionTypes.getInputValue, {name: 'date', value: value})
						}
				},
				time: {
						get () {
								return this.$store.state.news.singleNewsData.time
						},
						set (value) {
								this.$store.dispatch(actionTypes.getInputValue, {name: 'time', value: value})
						}
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
				submit() {
						if (this.$route.name === 'createNews') {
								this.$store.dispatch(actionTypes.createNews, {
										title: this.title,
										content: this.content,
										date: this.date,
										time: this.time,
								})
						} else if (this.$route.name === 'editNews') {
								this.$store.dispatch(actionTypes.updateNews, {
										id: this.id,
										time: this.time,
										date: this.date,
								})
						}
				},
		}
}
</script>

<style scoped>

</style>
