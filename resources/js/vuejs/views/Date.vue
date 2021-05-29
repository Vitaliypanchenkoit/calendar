<template>
		<div>
				<div class="calendar_nav max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
						<div class="calendar_nav__current">
								<nav-date :date="date" />
								<nav-month :month="month" />
								<nav-year :year="year" />
						</div>
						<badger-accordion>
								<badger-accordion-item>
										<template slot="header">
												<div class="date-info__events-title">Events</div>
												<router-link
														class="date-info__events-create"
														:to="{name: 'createEvent'}"
												>
														<button type="button">Create new</button>
												</router-link></template>

										<template slot="content">First Accordion Content</template>
								</badger-accordion-item>

								<badger-accordion-item>
										<template slot="header">
												<div class="date-info__events-title">News</div>
												<router-link
														class="date-info__events-create"
														:to="{name: 'createEvent'}"
												>
														<button type="button">Create new</button>
												</router-link></template>

										<template slot="content">Second Accordion Content</template>
								</badger-accordion-item>

								<badger-accordion-item>
										<template slot="header">
												<div class="date-info__events-title">Reminders</div>
												<router-link
														class="date-info__events-create"
														:to="{name: 'createEvent'}"
												>
														<button type="button">Create new</button>
												</router-link></template>

										<template slot="content">Second Accordion Content</template>
								</badger-accordion-item>
						</badger-accordion>
				</div>
		</div>

</template>

<script>
import {mapState} from 'vuex'
import NavYear from '../components/NavYear'
import NavMonth from '../components/NavMonth'
import NavDate from '../components/NavDate'
import {BadgerAccordion, BadgerAccordionItem} from 'vue-badger-accordion'


let now = new Date();
export default {
    name: "Date",
		components: {
    		NavYear,
				NavMonth,
				NavDate,
				BadgerAccordion,
				BadgerAccordionItem
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
    		console.log(this.$route.params);
		},
}
</script>

<style scoped>

</style>
