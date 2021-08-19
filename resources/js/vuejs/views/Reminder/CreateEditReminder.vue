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
						<label>Date & Time</label>
						<VueCtkDateTimePicker class="form-item" v-model="dateTime" :no-label="true" />
						<span class="text-red-600" v-if="errors.dateTime">{{ errors.dateTime[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<label for="content">Content</label>
						<textarea id="content" class="flex-grow" rows="8" v-model="content" v-if="!id"></textarea>
						<div class="disabled-textarea" v-else>{{ content }}</div>
						<span class="text-red-600" v-if="errors.content">{{ errors.content[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<div class="save-button" @click="submit()">Save</div>
				</div>
		</div>

</template>

<script>
import {actionTypes} from '../../store/modules/reminder'
import {mapState} from 'vuex'
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
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
				VueCtkDateTimePicker,
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
				dateTime: {
						get () {
								console.log(this.$store.state.reminder.singleReminderData.dateTime);
								return this.$store.state.reminder.singleReminderData.dateTime
						},
						set (value) {
								this.$store.dispatch(actionTypes.getInputValue, {name: 'dateTime', value: value})
						}
				},
		},
		mounted() {
				this.$store.dispatch(actionTypes.getSingleReminder, {id: this.id});
		},
		beforeRouteEnter(to, from, next) {
				next(vm => {
						vm.prevRoute = from
				})
		},
		methods: {
				submit() {
						this.$store.dispatch(actionTypes.createReminder, {
								title: this.title,
								content: this.content,
								dateTime: this.dateTime,
						})
				}
		}
}
</script>

<style scoped>

</style>
