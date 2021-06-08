<template>
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex">
						<div class="flex-1">
								<label for="title">Title</label>
								<input id="title" name="title" :value="reminderData.title" />
						</div>
				</div>
				<div class="flex">
						<div class="flex-1">
								<label for="date">Date</label>
								<input id="date" name="date" :value="reminderData.date" />
						</div>
						<div class="flex-1">
								<label for="time">Time</label>
								<input id="time" name="date" :value="reminderData.time" />
						</div>
				</div>
				<div class="flex">
						<div class="flex-1">
								<label for="content">Content</label>
								<textarea id="content" name="date" :value="reminderData.content" ></textarea>
						</div>
				</div>

		</div>

</template>

<script>
import {actionTypes} from '../../store/modules/reminder'
import {mapState} from 'vuex'
export default {
		name: "CreateEditReminder",
		props: {
				reminderId: {
						type: Number,
						default: 0
				}
		},
		computed: {
				...mapState({
						reminderData: state => state.reminder.singleReminderData,
						isLoading: state => state.reminder.isLoading,
						errors: state => state.reminder.errors,
				}),
		},
		mounted() {
				console.log(this.$store.state);
				this.$store.dispatch(actionTypes.getSingleReminder, {id: this.reminderId})
		},
}
</script>

<style scoped>
.row {
		display: flex;
		justify-content: space-between;
		align-items: center;
}

</style>
