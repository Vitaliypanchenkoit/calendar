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
										<div class="date-element__body" :class="{visible: isVisible.reminders}">
												<div v-for="reminder in reminders" class="date-element__body-item body-item relative">
														<div class="body-item__time">{{ reminder.time }}</div>
														<div class="body-item__title">{{ reminder.title }}</div>
														<div class="body-item__content">{{ reminder.title }}</div>
														<router-link
																v-if="new Date(reminder.date + ' ' + reminder.time).getTime() >= (Date.now() + 1000 * 120 * 60)"
																class="body-item__edit absolute"
																:to="{name: 'createEditReminder', props: {reminderId:  reminder.id}}"
														>
																<<<< Edit
														</router-link>
												</div>
										</div>
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
								reminders: true,
								news: true,
								events: true,
						},
						nowDate: now.getFullYear() + '-' + now.getMonth() + '-' + now.getDate(),
						nowTime: now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds(),
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
				},
				events: function () {
						return this.$route.params.events.length ? this.$route.params.events.sort(function (a, b) {
								if (a['time'] < b['time']) {
										return -1;
								}
								if (a['time'] > b['time']) {
										return 1;
								}
								return 0;
						}) : [];
						return this.$route.params.events
				},
				news: function () {
						return this.$route.params.news.length ? this.$route.params.news.sort(function (a, b) {
								if (a['time'] < b['time']) {
										return -1;
								}
								if (a['time'] > b['time']) {
										return 1;
								}
								return 0;
						}) : [];
				},
				reminders: function () {
						return this.$route.params.reminders.length ? this.$route.params.reminders.sort(function (a, b) {
								if (a['time'] < b['time']) {
										return -1;
								}
								if (a['time'] > b['time']) {
										return 1;
								}
								return 0;
						}) : [];
				},
		},
		mounted() {
    		console.log(this.$route.params);
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

.date-element__body-item {
		padding: 0.5rem 0 2rem 0;
		border-bottom: 1px dotted grey;
}
.body-item__time {
		font-size: 20px;
		font-weight: bold;
}
.body-item__title {
		font-weight: bold;
		margin-bottom: 1rem;
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
.body-item__edit {
		top: 0.5rem;
		right: 0;
}

.arrow-down,
.arrow-up {
		width: 10px;
		height: 10px;
}


</style>
