<template>
		<div class="nav-container">
				<v-select v-if="!hide.includes('date')" :options="dates" v-model="selectedDate" :clearable="false" @input="$parent.refreshCalendar(false, false, selectedDate)" class="nav-select"></v-select>
				<v-select v-if="!hide.includes('month')" :options="months" v-model="selectedMonth" :clearable="false" @input="$parent.refreshCalendar(false, selectedMonth, false)" class="nav-select"></v-select>
				<v-select v-if="!hide.includes('year')" :options="years" v-model="selectedYear" :clearable="false" @input="$parent.refreshCalendar(selectedYear, false, false)" class="nav-select"></v-select>
		</div>

</template>

<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import {months, getMonthNumber} from "../helpers/monthHelper";
export default {
		name: "Navigation",
		components: {
				vSelect
		},
		props: {
				year: {
						type: Number,
				},
				month: {
						type: Number,
				},
				date: {
						type: Number,
						default: 0
				},
				hide: {
						type: Array,
						default: function () {
								return []
						}
				}
		},
		data() {
				return {
						selectedYear: this.year,
						selectedMonth: months[this.month],
						selectedDate: this.date,
						months: months
				}
		},
		computed: {
				years: {
						get: function () {
								let arr = [];
								for (let i = 2020; i < 2040; i++) {
										arr.push(i);
								}
								return arr;
						}
				},
				dates() {
						let dates = [];
						let datesNumber = new Date(this.selectedYear, getMonthNumber(this.selectedMonth) + 1, 0).getDate();
						console.log(datesNumber);
						for (let j = 1; j <= datesNumber; j++) {
								dates.push(j);
						}
						return dates;
				}
		},

}
</script>

<style scoped>
.nav-container {
		display: flex;
		flex-wrap: wrap;
}
.nav-select {
		width: 200px;
		margin: 0 1rem 1rem 0;
}

</style>
