<template>
		<div>
				<div class="calendar_nav mx-auto px-4 sm:px-6 lg:px-8">
						<div class="calendar_nav__current">
								<navigation :year="selectedYear" :month="selectedMonth" :hide="['date']"></navigation>
								<router-link
										class="mode"
										:to="{
										name: 'month', params: {year: selectedYear, month: selectedMonth}}"
								>Month mode</router-link>
						</div>

						<div class="calendar_body">
								<div class="calendar_body__days">
										<div class="calendar_body__day">Mo</div>
										<div class="calendar_body__day">Tu</div>
										<div class="calendar_body__day">We</div>
										<div class="calendar_body__day">Th</div>
										<div class="calendar_body__day">Fr</div>
										<div class="calendar_body__day">Sa</div>
										<div class="calendar_body__day">Su</div>
								</div>
								<div class="calendar_body__dates">
										<router-link
												class="calendar_body__date"
												:to="{
										name: 'day', params: {year: selectedYear, month: selectedMonth + 1, date: date}}"
												v-for="(date, index) in monthData.dates" :key="index"
										>
												<div class="calendar_body__date-number">{{ date }}</div>
												<div class="event calendar_body__date-item"><span>Events: </span><span>{{ 'object' === typeof(weekData.events[date]) ? Object.keys(weekData.events[date]).length : 0 }}</span></div>
												<div class="news calendar_body__date-item"><span>News: </span><span>{{ 'object' === typeof(weekData.news[date]) ? Object.keys( weekData.news[date]).length : 0}}</span></div>
												<div class="reminder calendar_body__date-item"><span>Reminders: </span><span>{{ 'object' === typeof(weekData.reminders[date]) ? Object.keys( weekData.reminders[date]).length : 0 }}</span></div>
										</router-link>
								</div>
						</div>
				</div>
		</div>

</template>

<script>
import {mapState} from "vuex";
import {actionTypes} from "../store/modules/week";
import Navigation from "../components/Navigation";
import {getMonthNumber} from "../helpers/monthHelper";

let now = new Date();
export default {
		name: "Week",
		components: {Navigation},
		props: {
				weekStart: {
						type: String,
				},
				weekEnd: {
						type: String,
				},
		},
		data() {
				return {
						currentYear: now.getFullYear(),
						currentMonth: now.getMonth(),
						currentDate: now.getDate(),

						selectedWeekStart: new Date(this.weekStart),
						selectedWeekEnd: new Date(this.weekEnd),
				}
		},
		computed: {
				...mapState({
						weekData: state => state.week.data,
						isLoading: state => state.week.isLoading,
						errors: state => state.week.errors,
				}),

				nextStart() {
						let current = new Date(this.selectedWeekStart);
						let next = new Date(current.getFullYear(), current.getMonth() + 1, current.getDate()+7);
						return next.getFullYear() + '-' + next.getMonth() + '-' + next.getDate()
				},
				nextEnd() {
						let current = new Date(this.selectedWeekEnd);
						let next = new Date(current.getFullYear(), current.getMonth() + 1, current.getDate()+7);
						return next.getFullYear() + '-' + next.getMonth() + '-' + next.getDate()
				},

				prevStart() {
						let current = new Date(this.selectedWeekStart);
						let next = new Date(current.getFullYear(), current.getMonth() + 1, current.getDate()-7);
						return next.getFullYear() + '-' + next.getMonth() + '-' + next.getDate()
				},
				prevEnd() {
						let current = new Date(this.selectedWeekEnd);
						let next = new Date(current.getFullYear(), current.getMonth() + 1, current.getDate()-7);
						return next.getFullYear() + '-' + next.getMonth() + '-' + next.getDate()
				},

				selectedYear() {
						let date = new Date(this.selectedWeekStart)
						console.log(this.selectedWeekStart);
						console.log(date);
						return date.getFullYear();
				},
				selectedMonth() {
						let date = new Date(this.selectedWeekStart)
						return date.getMonth() + 1;
				},

				weekDates() {
						let dates = [];
						for (let i = 0; i < 7; i++) {
								dates.push(new Date(this))
						}
				}
		},
		async created() {
				await this.$store.dispatch(actionTypes.getWeekData, {start: this.selectedWeekStart, end: this.selectedWeekEnd})
		},
		methods: {
				// changeWeek: function () {
				//
				// 		this.$store.dispatch(actionTypes.getWeekData, {year: this.selectedStart, month: this.selectedWeekEnd})
				// },
				// refreshCalendar: function (year, month, date) {
				// 		this.selectedYear = year ? year : this.selectedYear;
				// 		this.selectedMonth = month ? getMonthNumber(month) : this.selectedMonth;
				//
				// 		this.$store.dispatch(actionTypes.getWeekData, {year: this.selectedYear, month: this.selectedMonth})
				// }

		}
}
</script>

<style scoped>

</style>
