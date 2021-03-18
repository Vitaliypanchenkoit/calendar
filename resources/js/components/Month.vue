<template>
    <div>
        <div class="calendar_nav">
            <div class="calendar_nav__current">
                <div class="calendar_nav__current-month">{{ this.months[currentMonth - 1] }}</div>
                <div class="calendar_nav__current-year">{{ currentYear }}</div>
            </div>
            <div class="calendar_nav__year">
                <select name="year">
                    <option v-for="year in this.years" :value="year">{{ year }}</option>
                </select>
            </div>
            <div class="calendar_nav__month"></div>
        </div>
        <div class="calendar_body"></div>
    </div>
</template>

<script>
export default {
    name: "Month",
    props: {
        'currentYear': Number,
        'currentMonth': Number,
    },
    data() {
        return {
            years: [],
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November',' December']
        }
    },
    mounted() {
        for (let i = (this.$props.currentYear - 20); i < (this.$props.currentYear + 20); i++) {
            this.years.push(i);
        }
    },
}
</script>

<style scoped>

</style>
