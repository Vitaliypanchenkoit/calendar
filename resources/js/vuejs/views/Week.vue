<template>
		<div>
				<div class="calendar_nav mx-auto px-4 sm:px-6 lg:px-8">
						<div class="calendar_nav__current">
								<router-link
										class="mode"
										:to="{
										name: 'month', params: {year: selectedYear, month: selectedMonth}}"
								>Month mode</router-link>
						</div>

						<div class="arrow-nav">
								<div class="arrow-nav__item arrow-nav__left" @click="changeWeek('prev')">
										<div class="arrow arrow-left"></div>
										<div class="arrow-nav__text">Prev</div>
								</div>
								<div class="arrow-nav__item arrow-nav__right" @click="changeWeek('next')">
										<div class="arrow-nav__text">Next</div>
										<div class="arrow arrow-right"></div>
								</div>
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
										name: 'day', params: {year: selectedYear, month: selectedMonth, date: date}}"
												v-for="(date, index) in weekData.dates" :key="index"
										>
												<div class="calendar_body__date-number">{{ date }} {{ weekData.months[date] }}</div>
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
import {getMonthNumber} from "../helpers/monthHelper";

let now = new Date();
export default {
		name: "Week",
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

						selectedWeekStart: this.weekStart,
						selectedWeekEnd: this.weekEnd,
				}
		},
		computed: {
				...mapState({
						weekData: state => state.week.data,
						isLoading: state => state.week.isLoading,
						errors: state => state.week.errors
				}),

				selectedYear() {
						let date = new Date(this.selectedWeekStart)
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
				async changeWeek(to) {
						await this.$store.dispatch(actionTypes.getWeekData, {start: this.selectedWeekStart, end: this.selectedWeekEnd, shift: to})
						this.selectedWeekStart = this.weekData.start
						this.selectedWeekEnd = this.weekData.end

				},
				refreshCalendar: function (year, month, date) {
						let y = year ? year : this.selectedYear;
						let m = month ? getMonthNumber(month) : this.selectedMonth;

						this.$store.dispatch(actionTypes.getWeekData, {start: y + '-' + m + '1', end: y + '-' + m + '7'})
				}

		}
}
</script>

<style scoped>
.arrow-nav {
		display: flex;
		flex-wrap: nowrap;
		margin-top: 1rem;
}
.arrow-nav__item {
		display: flex;
		align-items: center;
		cursor: pointer;
}
.arrow-nav__left {
		margin-right: 4rem;
}
.arrow-nav__item:hover .arrow-nav__text {
		text-decoration: underline;
}
.arrow-nav__text {
		transition: all 0.5s;
}

</style>
