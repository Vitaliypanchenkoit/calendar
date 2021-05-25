<template>
    <div>
        <div class="calendar_nav max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="calendar_nav__current">
                <div class="calendar_nav__current-month">
                    <span class="calendar_nav__prev-month arrow arrow-left"></span>
                    {{ this.months[this.currentMonth] }}
                    <span class="calendar_nav__next-month arrow arrow-right"></span>
                </div>
                <div class="calendar_nav__current-year">
                    <span class="calendar_nav__prev-year arrow arrow-left"></span>
                    {{ this.currentYear }}
                    <span class="calendar_nav__next-year arrow arrow-right"></span>
                </div>
            </div>
        </div>
        <div class="calendar_body">
            <div class="calendar_body__days">
<!--                <div class="calendar_body__day" v-for="weekDay in this.days">{{ // weekDay }}</div>-->
                <div class="calendar_body__day">Mo</div>
                <div class="calendar_body__day">Tu</div>
                <div class="calendar_body__day">We</div>
                <div class="calendar_body__day">Th</div>
                <div class="calendar_body__day">Fr</div>
                <div class="calendar_body__day">Sa</div>
                <div class="calendar_body__day">Su</div>
            </div>
            <div class="calendar_body__dates">
								{{dates}}
                <div class="calendar_body__date" v-for="(dates, index) in this.prevMonthDates">{{ index }}</div>
								<router-link
										class="calendar_body__date"
										:to="{name: 'day', params: {year: date[index]}}"
										v-for="(date, index) in this.dates" :key="index" :weekDay="date.weekDay"
								>
										{{ index }}
								</router-link>
<!--                <div class="calendar_body__date" v-for="(date, index) in this.dates" :weekDay="date.weekDay" >{{ index }}</div>-->
            </div>
        </div>
    </div>
</template>

<script>
import {actionTypes} from '../store/modules/month'
export default {
    name: "Month",
    props: {
    		year: Number,
    		month: Number,
    },
    data() {
        return {
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November',' December'],
            days: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            currentYear: '',
            currentMonth: '',
            currentDate: '',
            dates: {},
            prevMonthDates: {},
        }
    },
    mounted() {
        let now = new Date();
        this.currentYear = now.getFullYear();
        this.currentMonth = now.getMonth();
        this.currentDate = now.getDate();

				this.$store.dispatch(actionTypes.getDates, {year: this.year, month: this.month})
        this.generateMonthDates(this.currentYear, this.currentMonth);

    },
    methods: {
        generateMonthDates(year, month) {
            let daysInMonth = new Date(year, month + 1, 0).getDate();
            let daysInPrevMonth = new Date(year, month, 0).getDate();
            let weekDay = new Date(year, month, 1).getDay();
            let prevOffset = 0;
            if (weekDay === 0) {
                prevOffset = 6;
            } else {
                prevOffset = weekDay - 1;
            }
            for (let i = daysInPrevMonth; i > (daysInPrevMonth - prevOffset); i--) {
                this.prevMonthDates[i] = '';
            }

            for (let i = 1; i <= daysInMonth ; i++) {
                this.dates[i] = {'weekDay': weekDay};
                weekDay = weekDay === 6 ? 0 : weekDay + 1;
            }
            console.log(this.dates);
        }

    }

}
</script>

<style scoped>
.calendar_nav__current {
    display: flex;
    flex-wrap: wrap;
    font-size: 32px;
}
.calendar_nav__current-month {
    margin-right: 1em;
}
.arrow {
    display: inline-block;
    margin-left: 8px;
    width: 20px;
    height: 20px;
    background: transparent;
    border-top: 2px solid gray;
    border-left: 2px solid gray;
    transition: all .4s ease;
    text-decoration: none;
    color: transparent;
    cursor: pointer;
    vertical-align: middle;
}
.arrow-right {
    position: relative;
    transform: rotate(135deg);
    right: 8px;
}
.arrow-left {
    transform: rotate(-45deg);
    left: 0;
}
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

.calendar_body__date:hover {
  cursor: pointer;
}


</style>
