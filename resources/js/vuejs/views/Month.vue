<template>
    <div>
        <div class="calendar_nav mx-auto px-4 sm:px-6 lg:px-8">
            <div class="calendar_nav__current">
								<navigation :year="year" :month="month" :hide="['date']"></navigation>
								<router-link
										class="mode"
										:to="{
										name: 'week', params: {weekStart: weekStart, weekEnd: weekEnd}}"
								>Week mode</router-link>
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
                <div class="calendar_body__date prev_month" v-for="(prevMonth) in monthData.prevMonthOffset"></div>
								<router-link
										class="calendar_body__date"
										:to="{
										name: 'day', params: {year: selectedYear, month: selectedMonth + 1, date: date}}"
										v-for="(date, index) in monthData.dates" :key="index"
								>
										<div class="calendar_body__date-number">{{ date }}</div>
										<div class="event calendar_body__date-item"><span>Events: </span><span>{{ 'object' === typeof(monthData.events[date]) ? Object.keys(monthData.events[date]).length : 0 }}</span></div>
										<div class="news calendar_body__date-item"><span>News: </span><span>{{ 'object' === typeof(monthData.news[date]) ? Object.keys( monthData.news[date]).length : 0}}</span></div>
										<div class="reminder calendar_body__date-item"><span>Reminders: </span><span>{{ 'object' === typeof(monthData.reminders[date]) ? Object.keys( monthData.reminders[date]).length : 0 }}</span></div>
								</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import {actionTypes} from '../store/modules/month'
import {mapState} from 'vuex'
import Navigation from "../components/Navigation";
import {getMonthNumber} from "../helpers/monthHelper";

let now = new Date();
export default {
    name: "Month",
		components: {Navigation},
		props: {
    		year: {
    				type: Number,
						default: now.getFullYear()
				},
				month: {
						type: Number,
						default: now.getMonth()
				},
    },
    data() {
        return {
            days: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            currentYear: now.getFullYear(),
            currentMonth: now.getMonth(),
            currentDate: now.getDate(),
						selectedMonth: this.month,
						selectedYear: this.year,
        }
    },
		computed: {
				...mapState({
						monthData: state => state.month.data,
						isLoading: state => state.month.isLoading,
						errors: state => state.month.errors,
				}),
				weekStart() {
						let date = new Date(this.selectedYear, this.selectedMonth)
						let firstday = new Date(date.setDate(date.getDate() - date.getDay() + 1));
						return firstday.getFullYear() + '-' + (firstday.getMonth() + 1) + '-' + firstday.getDate();
				},
				weekEnd() {
						let date = new Date(this.selectedYear, this.selectedMonth)
						let last = new Date(date.setDate(date.getDate() - date.getDay() + 7));
						return last.getFullYear() + '-' + (last.getMonth() + 1) + '-' + last.getDate();

				},
		},
    async created() {
				await this.$store.dispatch(actionTypes.getData, {year: this.selectedYear, month: this.selectedMonth})
				for ( let i = 0; i < this.monthData.remindersForToday.length; i++) {
						window.Echo.private(`reminders.${this.monthData.remindersForToday[i].id}`)
								.listen('TimeToRemindEvent', (e) => {
										this.$parent.reminder = e.reminder;
										this.$parent.showReminderPopUp = true;
								});

				}
    },
    methods: {
				refreshCalendar: function (year, month, date) {
						this.selectedYear = year ? year : this.selectedYear;
						this.selectedMonth = month ? getMonthNumber(month) : this.selectedMonth;

						this.$store.dispatch(actionTypes.getData, {year: this.selectedYear, month: this.selectedMonth})
				}
    }

}
</script>

<style scoped>
</style>
