<template>
		<div class="">
				<div class="form-group"></div>

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
				this.$store.dispatch(actionTypes.getSingleReminder, {id: this.reminderId})
		},
}
</script>

<style scoped>

</style>
