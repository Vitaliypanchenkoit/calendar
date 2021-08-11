<template>
		<div>
				<div class="calendar_nav max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
						<div class="calendar_nav__current">
								<nav-date :date=date />
								<nav-month :month=month />
								<nav-year :year=year />
						</div>
						<div class="date-content">
								<div class="date-element reminders">
										<div class="date-element__head">
												<router-link
														class="date-element__head-create-new"
														:to="{name: 'createReminder', props: {year: year, month: month, date: date}}"
												>
														Create new
												</router-link>
												<div class="date-element__head-title">Reminders</div>
												<div class="arrow-container" @click="toggleElementBody('reminders')">
														<div class="arrow" :class="[isVisible.reminders ? 'arrow-up' : 'arrow-down']"></div>
												</div>
										</div>
										<div class="date-element__body" :class="{visible: isVisible.reminders}">dfgdfg</div>
								</div>
								<div class="date-element news">
										<div class="date-element__head">
												<router-link
														class="date-element__head-create-new"
														:to="{name: 'createEvent'}"
												>
														Create new
												</router-link>
												<div class="date-element__head-title">News</div>
												<div class="arrow-container" @click="toggleElementBody('news')">
														<div class="arrow" :class="[isVisible.news ? 'arrow-up' : 'arrow-down']"></div>
												</div>
										</div>
										<div class="date-element__body" :class="{visible: isVisible.news}">sdfsdf</div>
								</div>
								<div class="date-element events">
										<div class="date-element__head">
												<router-link
														class="date-element__head-create-new"
														:to="{name: 'createNews'}"
												>
														Create new
												</router-link>
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
import NavYear from '../components/NavYear'
import NavMonth from '../components/NavMonth'
import NavDate from '../components/NavDate'

let now = new Date();
export default {
    name: "Date",
		components: {
    		NavYear,
				NavMonth,
				NavDate,
		},
		data() {
				return {
						isVisible: {
								reminders: false,
								news: false,
								events: false,
						},
				}
		},
		computed: {
    		year: function () {
    				return this.$route.params.year
				},
				month: function () {
						return this.$route.params.month - 1
				},
				date: function () {
						return this.$route.params.date
				}
		},
		mounted() {
		},
		methods: {
    		toggleElementBody: function(element) {
    				this.isVisible[element] = !this.isVisible[element]
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

.arrow-down,
.arrow-up {
		width: 10px;
		height: 10px;
}


</style>
