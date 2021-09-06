<template>
    <div>
        <div class="calendar_nav mx-auto px-4 sm:px-6 lg:px-8">
            <div class="calendar_nav__current">
								<navigation :year="year" :month="month" :hide="['date']"></navigation>
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
		},
    created() {
				this.$store.dispatch(actionTypes.getData, {year: this.selectedYear, month: this.selectedMonth})
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

.calendar_body {
    margin: 20px 10px;
}
.calendar_body__days {
    display: flex;
}

.calendar_body__dates {
    display: flex;
    flex-wrap: wrap;
}
.calendar_body__date,
.calendar_body__day {
    width: 14%;
    text-align: center;
}

.calendar_body__date {
  border: 1px solid #000000;
  margin: 0.1em;
  padding: 0.2em;
}
.calendar_body__date.prev_month {
		border: none;
}

.calendar_body__date:not(.prev_month):hover {
  	cursor: pointer;
		background: #ffffff;
}

.calendar_body__date-item {
		display: flex;
		justify-content: space-between;
		padding: 0 0.6rem;
}


</style>
