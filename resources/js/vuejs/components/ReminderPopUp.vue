<template>
		<div class="pop-up">
				<div class="pop-up__pre-title">!!!!  Reminder  !!!!</div>
				<div class="pop-up__time">
						<span>{{ reminder.time }}</span>
						<span class="pop-up__time-hold" v-if="reminder.time_hold && reminder.time_hold !== '00:00:00'">(Time hold: {{ reminder.time_hold }})</span>
				</div>
				<div class="pop-up__title">{{ reminder.title }}</div>
				<div class="pop-up__content">{{ reminder.content }}</div>
				<div class="pop-up__control">
						<div class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full" @click="complete()">Ok</div>
						<div class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-full" @click="hold(30)">Hold 30m</div>
						<div class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full" @click="hold(60)">Hold 1h</div>
				</div>
		</div>

</template>

<script>
import {actionTypes} from '../store/modules/reminder'
import {mapState} from "vuex";
export default {
		name: "ReminderPopUp",
		props: {
				reminder: {
						type: Object,
						default: {
								id: 0,
								time: '',
								time_hold: '00:00:00',
								title: '',
								content: ''
						}
				},
		},
		computed: {
				closePopUp: {
						get() {
								return this.$store.state.reminder.closePopUp
						},
				},
		},
		watch: {
				// whenever question changes, this function will run
				closePopUp: function (newQvalue, oldvalue) {
						if (newQvalue) {
								this.ok()
						}
				}
		},
		methods: {
				hold(period) {
						this.$store.dispatch(actionTypes.holdReminder, {id: this.reminder.id, period: period})
				},
				complete() {
						this.$store.dispatch(actionTypes.completeReminder, {id: this.reminder.id})
				},
				ok() {
						this.$parent.showReminderPopUp = false;
						this.$parent.reminder = {};
				}
		}
}
</script>

<style scoped>
.pop-up {
		position: absolute;
		left: 50%;
		padding: 1.5rem 2rem;
		width: 100%;
		transform: translate(-50%);
		background: #ffffff;
		border-radius: 5px;
		border: 1px solid rgba(60, 60, 60, .26);
		z-index: 2;
}
.pop-up__time {
		text-align: center;
		font-size: 2rem;
}
.pop-up__time-hold {
		display: block;
		font-size: 1.5rem;
}
.pop-up__pre-title {
		margin-bottom: 0.5rem;
		color: orangered;
		text-align: center;
		font-size: 1.5rem;
		font-weight: bold;
}
.pop-up__title {
		margin-bottom: 1rem;
		text-align: center;
		font-size: 1.5rem;
		font-weight: bold;
}
.pop-up__control {
		display: block;
}
.pop-up__control div {
		min-width: 100%;
		text-align: center;
		margin-bottom: 1rem;
		cursor: pointer;
}
@media all and (min-width: 420px) {
		.pop-up {
				width: 400px;
		}
		.pop-up__control {
				display: flex;
				flex-wrap: wrap;
				justify-content: space-between;
				margin-top: 1rem;
		}
		.pop-up__control div {
				min-width: 80px;
				margin-bottom: 0;
		}

}

</style>
