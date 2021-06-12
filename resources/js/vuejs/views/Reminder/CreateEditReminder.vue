<template>
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="form-item mb-2">
						<label for="title">Title</label>
						{{ title }}
						<input id="title" class="flex-grow" v-model="title" />
						<span class="text-red-600" v-if="errors.title">{{ errors.title[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<label>Date & Time</label>
						<VueCtkDateTimePicker class="form-item" v-model="dateTime" :no-label="true" />
						<span class="text-red-600" v-if="errors.dateTime">{{ errors.dateTime[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<label for="content">Content</label>
						<textarea id="content" class="flex-grow" rows="8" :v-model="content" ></textarea>
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
export default {
		name: "CreateEditReminder",
		props: {
				reminderId: {
						type: Number,
						default: 0
				}
		},
		components: {
				VueCtkDateTimePicker
		},
		data() {
				return {
						prevRoute: {path: ''},
						dateTime: '',
						content: ''
				}
		},
		computed: {
				...mapState({
						reminderData: state => state.reminder.singleReminderData,
						isLoading: state => state.reminder.isLoading,
						errors: state => state.reminder.errors,
				}),
				title: {
						get() {
								return this.value
						},
						set(value) {
								this.$emit('input', value)
						}
				}
		},
		mounted() {
				this.dateTime = this.prevRoute.path
				this.$store.dispatch(actionTypes.getSingleReminder, {id: this.reminderId}).then((reminder) => {
						if (null != reminder) {
								this.title = reminder.title
								this.content = reminder.content
								this.dateTime = reminder.dateTime
						}
				})
		},
		beforeRouteEnter(to, from, next) {
				next(vm => {
						vm.prevRoute = from
				})
		},
		methods: {
				submit() {
						console.log(this.title);
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
