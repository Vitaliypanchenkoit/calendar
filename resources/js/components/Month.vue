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
                <div class="calendar_body__day" v-for="weekDay in this.days">{{ weekDay }}</div>
            </div>
            <div class="calendar_body__dates">
                <div class="calendar_body__date" v-for="date in this.dates"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Month",
    props: {

    },
    data() {
        return {
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November',' December'],
            days: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
            currentYear: '',
            currentMonth: '',
            currentDate: '',
            dates: {},
        }
    },
    mounted() {
        let now = new Date();
        this.currentYear = now.getFullYear();
        this.currentMonth = now.getMonth();
        this.currentDate = now.getDate();
        let daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
        let weekDayOfFirst = new Date(this.currentYear, this.currentMonth, 1).getDay();
        console.log(weekDayOfFirst);

    },

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
    justify-content: space-between;
}


</style>
