<template>
		<div>
				<div class="calendar_nav max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
						<div class="calendar_nav__current">
								<navigation :year="this.$route.params.year" :month="this.$route.params.month - 1" :date=this.$route.params.date></navigation>
						</div>
						<div class="date-content">
								<div class="date-element reminders">
										<div class="date-element__head">
												<div class="date-element__head-title">Reminders</div>
												<div class="arrow-container" @click="toggleElementBody('reminders')">
														<div class="arrow" :class="[isVisible.reminders ? 'arrow-up' : 'arrow-down']"></div>
												</div>
										</div>
										<div class="date-element__body" :class="{visible: isVisible.reminders}">
												<div v-for="reminder in reminders" class="date-element__body-item body-item relative">
														<div class="body-item__time">{{ reminder.time }}</div>
														<div class="body-item__title">{{ reminder.title }}</div>
														<div class="body-item__content">{{ reminder.title }}</div>
														<router-link
																v-if="new Date(reminder.date + ' ' + reminder.time).getTime() >= (Date.now() + 1000 * 120 * 60)"
																class="body-item__edit absolute"
																:to="{name: 'editReminder', params: {id:  reminder.id}, props: {id:  reminder.id}}"
														>
																<<<< Edit time
														</router-link>
												</div>
										</div>
								</div>
								<div class="date-element news">
										<div class="date-element__head">
												<div class="date-element__head-title">News</div>
												<div class="arrow-container" @click="toggleElementBody('news')">
														<div class="arrow" :class="[isVisible.news ? 'arrow-up' : 'arrow-down']"></div>
												</div>
										</div>
										<div class="date-element__body" :class="{visible: isVisible.news}">sdfsdf</div>
								</div>
								<div class="date-element events">
										<div class="date-element__head">
												<div class="date-element__head-title">Events</div>
												<div class="arrow-container" @click="toggleElementBody('events')">
														<div class="arrow" :class="[isVisible.events ? 'arrow-up' : 'arrow-down']"></div>
												</div>
										</div>
										<div class="date-element__body" :class="{visible: isVisible.events}">dfgdfg</div>
								</div>
						</div>
				</div>
		</div>

</template>

<script>
import {mapState} from 'vuex'
import Navigation from "../components/Navigation";
import {actionTypes} from "../store/modules/date";
import {getMonthNumber} from "../helpers/monthHelper";

let now = new Date();
export default {
    name: "Date",
		components: {Navigation},
		data() {
				return {
						isVisible: {
								reminders: true,
								news: true,
								events: true,
						},
						nowDate: now.getFullYear() + '-' + now.getMonth() + '-' + now.getDate(),
						nowTime: now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds(),
						selectedYear: this.$route.params.year,
						selectedMonth: this.$route.params.month - 1,
						selectedDate: this.$route.params.date,
				}
		},
		computed: {
				...mapState({
						dateData: state => state.date.data,
						isLoading: state => state.date.isLoading,
						errors: state => state.date.errors,
				}),
				events: function () {
						return (undefined !== this.dateData.events && this.dateData.events.length) ? this.dateData.events.sort(function (a, b) {
								if (a['time'] < b['time']) {
										return -1;
								}
								if (a['time'] > b['time']) {
										return 1;
								}
								return 0;
						}) : [];
				},
				news: function () {
						return (undefined !== this.dateData.news && this.dateData.news.length) ? this.dateData.news.sort(function (a, b) {
								if (a['time'] < b['time']) {
										return -1;
								}
								if (a['time'] > b['time']) {
										return 1;
								}
								return 0;
						}) : [];
				},
				reminders: function () {
						return (undefined !== this.dateData.reminders && this.dateData.reminders.length) ? this.dateData.reminders.sort(function (a, b) {
								if (a['time'] < b['time']) {
										return -1;
								}
								if (a['time'] > b['time']) {
										return 1;
								}
								return 0;
						}) : [];
				},
		},
		created() {
				this.$store.dispatch(actionTypes.getData, {year: this.selectedYear, month: this.selectedMonth, date: this.selectedDate})
		},
		methods: {
    		toggleElementBody: function(element) {
    				this.isVisible[element] = !this.isVisible[element]
				},
				refreshCalendar: function (year, month, date) {
						this.selectedYear = year ? year : this.selectedYear;
						this.selectedMonth = month ? getMonthNumber(month) : this.selectedMonth;
						this.selectedDate = date ? date : this.selectedDate;

						this.$store.dispatch(actionTypes.getData, {year: this.selectedYear, month: this.selectedMonth, date: this.selectedDate})
				}
		}
}
</script>

<style scoped>
.date-content {
		margin-top: 1em;
}

.date-element {
		margin-bottom: 1em;
		background: #ffffff;
}
.date-element__head {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 0.5em 1em;
		border: 1px solid #000000;
}

.date-element__body {
		display: none;
		padding: 0.5em 1em;
		border: 1px solid #000000;
		border-top: none;
}

.date-element__body-item {
		padding: 0.5rem 0 2rem 0;
		border-bottom: 1px dotted grey;
}
.body-item__time {
		font-size: 20px;
		font-weight: bold;
}
.body-item__title {
		font-weight: bold;
		margin-bottom: 1rem;
}

.date-element__body.visible {
		display: block;
}

.date-element__head-title {
		font-size: 24px;
		font-weight: bold;
}
.date-element__head-create-new {
		cursor: pointer;
}
.date-element__head-create-new:hover {
		text-decoration: underline;
}

.arrow-container {
		height: 100%;
		width: 30px;
		cursor: pointer;
}
.body-item__edit {
		top: 0.5rem;
		right: 0;
}

.arrow-down,
.arrow-up {
		width: 10px;
		height: 10px;
}


</style>
