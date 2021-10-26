<template>
		<div>
				<div class="calendar_nav max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
						<div class="calendar_nav__current">
								<navigation :year="this.$route.params.year" :month="this.$route.params.month - 1" :date=this.$route.params.date></navigation>
						</div>
						<div class="date-content">
								<div class="date-element reminders">
										<div class="date-element__head">
												<div class="date-element__head-title">Reminders</div>
												<div class="arrow-container" @click="toggleElementBody('reminders')">
														<div class="arrow" :class="[isVisible.reminders ? 'arrow-up' : 'arrow-down']"></div>
												</div>
										</div>
										<div class="date-element__body" :class="{visible: isVisible.reminders}">
												<div v-for="(reminder, index) in dateData['reminders']" class="date-element__body-item body-item relative">
														<div class="body-item__time">{{ reminder.time }}</div>
														<div class="body-item__title">{{ reminder.title }}</div>
														<div class="body-item__content">{{ reminder.content }}</div>
														<router-link
																v-if="new Date(reminder.date + ' ' + reminder.time).getTime() >= (Date.now() + 1000 * 120 * 60) && $parent.currentUser.id === reminder.author_id"
																class="body-item__edit absolute"
																:to="{name: 'editReminder', params: {id:  reminder.id}, props: {id:  reminder.id}}"
														>
																<<<< Edit time
														</router-link>
														<div v-if="$parent.currentUser.id === reminder.author_id" class="remove" title="Remove" @click="removeObject('Reminder', reminder.id, index)">&#10060;</div>
												</div>
										</div>
								</div>
								<div class="date-element news">
										<div class="date-element__head">
												<div class="date-element__head-title">News</div>
												<div class="arrow-container" @click="toggleElementBody('news')">
														<div class="arrow" :class="[isVisible.news ? 'arrow-up' : 'arrow-down']"></div>
												</div>
										</div>
										<div class="date-element__body" :class="{visible: isVisible.news}">
												<div v-for="(item, index) in dateData['news']" class="date-element__body-item body-item relative">
																<div class="body-item__title">{{ item.title }}</div>
														<div class="body-item__meta">
																<div v-if="$parent.currentUser.id === item.author_id" class="body-item__created_by">Created by you</div>
																<div v-else class="body-item__created_by">Created by {{ item.author_name }}</div>
																<div>
																		<span>Was read by: {{ item.read.length }}</span>&#160;&#160;
																		<span>Marked as important: {{ item.important.length }}</span>
																</div>
														</div>

														<div class="body-item__time">{{ item.time }}</div>
														<div class="body-item__content">{{ item.content }}</div>
														<router-link
																		v-if="$parent.currentUser.id === item.author_id"
																		class="body-item__edit absolute"
																		:to="{name: 'editNews', params: {id:  item.id}, props: {id:  item.id}}"
														>
																		<<<< Edit News
														</router-link>
														<div v-if="$parent.currentUser.id === item.author_id" class="remove" title="Remove" @click="removeObject('News', item.id, index)">&#10060;</div>
														<div v-if="$parent.currentUser.id !== item.author_id" class="body-item__control">
																<label>
																		<input type="checkbox" :checked="item.read.includes($parent.currentUser.id)" @change="markNews(item.id, 'read', !item.read.includes($parent.currentUser.id))">
																		<span>Mark as read</span>
																</label>&#160;&#160;
																<label>
																		<input type="checkbox" :checked="item.important.includes($parent.currentUser.id)" @change="markNews(item.id,'important', !item.important.includes($parent.currentUser.id))">
																		<span>Mark as important</span>
																</label>
														</div>
												</div>
										</div>
								</div>
								<div class="date-element events">
										<div class="date-element__head">
												<div class="date-element__head-title">Events</div>
												<div class="arrow-container" @click="toggleElementBody('events')">
														<div class="arrow" :class="[isVisible.events ? 'arrow-up' : 'arrow-down']"></div>
												</div>
										</div>
										<div class="date-element__body" :class="{visible: isVisible.events}">
												<div v-for="(item, index) in dateData['events']" class="date-element__body-item body-item relative" :id="'event-' + item.id">
														<div class="body-item__title">{{ item.title }}</div>
														<div class="body-item__meta">
																<div v-if="$parent.currentUser.id === item.author_id" class="body-item__created_by">Created by you</div>
																<div v-else class="body-item__created_by">Created by {{ item.author_name }}</div>
																<div>
																		<span>participants: {{ item.take_part.length }}</span>&#160;&#160;
																		<span>Marked as not interesting: {{ item.not_interesting.length }}</span>
																</div>
														</div>

														<div class="body-item__time">{{ item.time }}</div>
														<div class="body-item__content">{{ item.content }}</div>
														<router-link
																v-if="$parent.currentUser.id === item.author_id"
																class="body-item__edit absolute"
																:to="{name: 'editEvent', params: {id:  item.id}}"
														>
																<<<< Edit Event
														</router-link>
														<router-link
																class="body-item__details absolute"
																:to="{name: 'eventDetails', params: {id:  item.id}}"
														>
																<<<< Details
														</router-link>
														<div v-if="$parent.currentUser.id === item.author_id" class="remove" title="Remove" @click="removeObject('Event', item.id, index)">&#10060;</div>
												</div>
										</div>
								</div>
						</div>
				</div>
		</div>

</template>

<script>
import {mapState} from 'vuex'
import Navigation from "../components/Navigation";
import {actionTypes} from "../store/modules/date";
import {getMonthNumber} from "../helpers/monthHelper";

let now = new Date();
export default {
    name: "Date",
		components: {Navigation},
		data() {
				return {
						isVisible: {
								reminders: true,
								news: true,
								events: true,
						},
						nowDate: now.getFullYear() + '-' + now.getMonth() + '-' + now.getDate(),
						nowTime: now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds(),
						selectedYear: this.$route.params.year,
						selectedMonth: this.$route.params.month - 1,
						selectedDate: this.$route.params.date,
				}
		},
		computed: {
				...mapState({
						dateData: state => state.date.data,
						isLoading: state => state.date.isLoading,
						errors: state => state.date.errors,
				}),
		},
		created() {
				this.$store.dispatch(actionTypes.getData, {year: this.selectedYear, month: this.selectedMonth, date: this.selectedDate})
		},
		methods: {
    		toggleElementBody: function(element) {
    				this.isVisible[element] = !this.isVisible[element]
				},
				refreshCalendar: function (year, month, date) {
						this.selectedYear = year ? year : this.selectedYear;
						this.selectedMonth = month ? getMonthNumber(month) : this.selectedMonth;
						this.selectedDate = date ? date : this.selectedDate;

						this.$store.dispatch(actionTypes.getData, {year: this.selectedYear, month: this.selectedMonth, date: this.selectedDate})
				},
				removeObject(objectName, id, index) {
						this.$store.dispatch(actionTypes.removeObject, {objectName, id, index})
				},

		},
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
		color: #000000;
}

.date-element__body-item {
		padding: 0.5rem 0 2rem 0;
		border-bottom: 1px dotted grey;
}
.body-item__time {
		font-weight: bold;
}
.body-item__title {
		font-size: 20px;
		font-weight: bold;
}
.body-item__meta {
		margin-bottom: 1rem;
		color: grey;
		font-style: italic;
		font-size: 14px;
}

.date-element__body.visible {
		display: block;
}

.date-element__head-title {
		font-size: 24px;
		font-weight: bold;
}

.arrow-container {
		height: 100%;
		width: 30px;
		cursor: pointer;
}
.body-item__edit {
		top: 0.5rem;
		right: 175px;
}

.body-item__details {
		top: 0.5rem;
		right: 55px;
}

.remove {
		position: absolute;
		top: 10px;
		right: 5px;
		cursor: pointer;
}

</style>
