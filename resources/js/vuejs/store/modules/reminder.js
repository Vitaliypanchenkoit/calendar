import reminderApi from '../../api/reminder-api'
import Vue from "vue";

const apiUrl = '/reminders';

const state = {
		reminders: {},
		singleReminderData: {
				title: '',
				content: '',
				date: '',
				time: '',
		},
		isLoading: false,
		errors: {
				title: '',
				content: '',
				date: '',
				time: '',
		},
		successMessage: '',
}

export const mutationTypes = {
		getSingleReminderStart: '[reminder] Get single reminder start',
		getSingleReminderSuccess: '[reminder] Get single reminder success',
		getSingleReminderFailure: '[reminder] Get single reminder failure',

		saveReminderStart: '[reminder] Save reminder start',
		saveReminderSuccess: '[reminder] Save reminder success',
		saveReminderFailure: '[reminder] Save reminder failure',

		getInputValue: '[reminder] Get value from input',

		holdStart: '[reminder] Hold start',
		holdSuccess: '[reminder] Hold success',
		holdFailure: '[reminder] Hold failure',
}

const mutations = {
		[mutationTypes.getSingleReminderStart](state) {
				state.isLoading = true
				state.successMessage = '';
				state.singleReminderData = {
						title: '',
						content: '',
						date: '',
						time: '',
				}
				state.errors = {
						title: '',
						content: '',
						date: '',
						time: '',
				}
		},
		[mutationTypes.getSingleReminderSuccess](state, payload) {
			state.isLoading = false
			state.singleReminderData = payload
			state.singleReminderData.dateTime = payload.date + ' ' + payload.time
		},
		[mutationTypes.getSingleReminderFailure](state, payload) {
				state.isLoading = false
				state.singleReminderData = {
						title: '',
						content: '',
						date: '',
						time: '',
				}
				state.errors = payload
		},

		/* Save reminder */
		[mutationTypes.saveReminderStart](state) {
				state.isLoading = true
				state.successMessage = '';
				state.errors = {
						title: '',
						content: '',
						date: '',
						time: '',
				}
		},
		[mutationTypes.saveReminderSuccess](state) {
				state.isLoading = false
				state.successMessage = 'The Reminder was created successfully';
				state.singleReminderData = {
						title: '',
						content: '',
						date: '',
						time: '',
				}

		},
		[mutationTypes.saveReminderFailure](state, payload) {
				state.isLoading = false
				state.errors = payload
		},

		/* Input data */
		[mutationTypes.getInputValue](state, payload) {
				state.singleReminderData = {
						...state.singleReminderData,
						[payload.name]: payload.value
				}
		},

		/* Hold reminder */
		[mutationTypes.holdStart](state) {

		},
		[mutationTypes.holdSuccess](state) {

		},
		[mutationTypes.holdFailure](state, payload) {
				state.errors = payload
		},
}

export const actionTypes = {
		getSingleReminder: '[reminder] Get single reminder data',
		createReminder: '[reminder] Create reminder',
		updateReminder: '[reminder] Update reminder',
		deleteReminder: '[reminder] Delete reminder',
		getInputValue: '[reminder] Get input value',
}

const actions = {
		[actionTypes.getSingleReminder](context, {id}) {
				if (!id) {
						return;
				}
				return new Promise(resolve => {
						context.commit(mutationTypes.getSingleReminderStart)
						reminderApi.getReminder(apiUrl + '/edit', id)
								.then(response => {
										context.commit(mutationTypes.getSingleReminderSuccess, response.data)
										resolve(response.data)
								})
								.catch((e) => {
										context.commit(mutationTypes.getSingleReminderFailure, e.response.data)
								})
				})
		},

		[actionTypes.createReminder](context, {title, content, date, time}) {
				return new Promise(resolve => {
						context.commit(mutationTypes.saveReminderStart)
						reminderApi.createReminder(apiUrl, title, content, date, time)
								.then(response => {
										context.commit(mutationTypes.saveReminderSuccess, response.data)
								})
								.catch((e) => {
										console.log(e.response.data);
										context.commit(mutationTypes.saveReminderFailure, e.response.data.errors)
								})
				})
		},

		[actionTypes.updateReminder](context, {id, time, date}) {
				return new Promise(resolve => {
						context.commit(mutationTypes.saveReminderStart)
						reminderApi.updateReminder(apiUrl, id, time, date)
								.then(response => {
										context.commit(mutationTypes.saveReminderSuccess, response.data)
								})
								.catch((e) => {
										context.commit(mutationTypes.saveReminderFailure, e.response.data.errors)
								})
				})
		},

		[actionTypes.getInputValue](context, {name, value}) {
				context.commit(mutationTypes.getInputValue, {name, value})

		},


}

export default {
		state,
		actions,
		mutations,
		getters: {
				date: function (state) {
						return state.singleReminderData.date
				},
				time: function (state) {
						return state.singleReminderData.time
				}
		}
}
