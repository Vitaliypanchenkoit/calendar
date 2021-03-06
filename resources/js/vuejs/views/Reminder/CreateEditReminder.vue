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
						<label>Date</label>
						<datetime v-if="!id" v-model="date" :value-zone="'local'" :format="{ year: 'numeric', month: 'long', day: 'numeric' }"></datetime>
						<div class="disabled-input" v-else>{{ date }}</div>
						<span class="text-red-600" v-if="errors.date">{{ errors.date[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<label>Time</label>
						<datetime type="time" :value-zone="'local'" v-model="time"></datetime>
						<span class="text-red-600" v-if="errors.time">{{ errors.time[0] }}</span>
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
import {actionTypes} from '../../store/modules/reminder'
import {mapState} from 'vuex'
import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
import GoHomeButton from "../../components/GoHomeButton";
export default {
		name: "CreateEditReminder",
		props: {
				id: {
						type: Number,
						default: 0
				}
		},
		components: {
				datetime: Datetime,
				GoHomeButton
		},
		data() {
				return {
						prevRoute: {path: ''},
				}
		},
		computed: {
				...mapState({
						isLoading: state => state.reminder.isLoading,
						errors: state => state.reminder.errors,
						successMessage: state => state.reminder.successMessage,
				}),
				title: {
						get () {
								return this.$store.state.reminder.singleReminderData.title
						},
						set (value) {
								this.$store.dispatch(actionTypes.getInputValue, {name: 'title', value: value})
						}
				},
				content: {
						get () {
								return this.$store.state.reminder.singleReminderData.content
						},
						set (value) {
								this.$store.dispatch(actionTypes.getInputValue, {name: 'content', value: value})
						}
				},
				date: {
						get () {
								return this.$store.state.reminder.singleReminderData.date
						},
						set (value) {
								this.$store.dispatch(actionTypes.getInputValue, {name: 'date', value: value})
						}
				},
				time: {
						get () {
								return this.$store.state.reminder.singleReminderData.time
						},
						set (value) {
								this.$store.dispatch(actionTypes.getInputValue, {name: 'time', value: value})
						}
				},
		},
		created() {
				this.$store.dispatch(actionTypes.getSingleReminder, {id: this.id});
		},
		beforeRouteEnter(to, from, next) {
				next(vm => {
						vm.prevRoute = from
				})
		},
		methods: {
				submit() {
						if (this.$route.name === 'createReminder') {
								this.$store.dispatch(actionTypes.createReminder, {
										title: this.title,
										content: this.content,
										date: this.date,
										time: this.time,
								})
						} else if (this.$route.name === 'editReminder') {
								this.$store.dispatch(actionTypes.updateReminder, {
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
