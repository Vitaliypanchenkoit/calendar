<template>
    <div>
        <div class="calendar_nav max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="calendar_nav__current">
								<nav-month :month="month" />
								<nav-year :year="year" />
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
										name: 'day', params: {year: year, month: month + 1, date: date, events: monthData.events[date], news: monthData.news[date], reminders: monthData.reminders[date]}}"
										v-for="(date, index) in monthData.dates" :key="index"
								>
										<div class="calendar_body__date-number">{{ date }}</div>
										<div class="event calendar_body__date-item"><span>Events: </span><span>{{ monthData.events[date].length }}</span></div>
										<div class="news calendar_body__date-item"><span>News: </span><span>{{ monthData.news[date].length }}</span></div>
										<div class="reminder calendar_body__date-item"><span>Reminders: </span><span>{{ monthData.reminders[date].length }}</span></div>
								</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import {actionTypes} from '../store/modules/month'
import {mapState} from 'vuex'
import NavYear from '../components/NavYear'
import NavMonth from '../components/NavMonth'

let now = new Date();
export default {
    name: "Month",
		components: {NavYear, NavMonth},
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
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November',' December'],
            days: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            currentYear: now.getFullYear(),
            currentMonth: now.getMonth(),
            currentDate: now.getDate(),
        }
    },
		computed: {
				...mapState({
						monthData: state => state.month.data,
						isLoading: state => state.month.isLoading,
						errors: state => state.month.errors,
				}),
		},
    mounted() {
				this.$store.dispatch(actionTypes.getData, {year: this.year, month: this.month})
    },
    methods: {
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
