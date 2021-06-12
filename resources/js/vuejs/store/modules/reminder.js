import reminderApi from '../../api/reminder-api'

const apiUrl = '/reminders';

const state = {
		reminders: {},
		singleReminderData: {},
		isLoading: false,
		errors: {
				title: '',
				content: '',
				dateTime: '',
		}
}

export const mutationTypes = {
		getSingleReminderStart: '[reminder] Get single reminder start',
		getSingleReminderSuccess: '[reminder] Get single reminder success',
		getSingleReminderFailure: '[reminder] Get single reminder failure',

		saveReminderStart: '[reminder] Save reminder start',
		saveReminderSuccess: '[reminder] Save reminder success',
		saveReminderFailure: '[reminder] Save reminder failure',
}

const mutations = {
		[mutationTypes.getSingleReminderStart](state) {
				state.isLoading = true
				state.singleReminderData = {}
				state.errors = {
						title: '',
						content: '',
						dateTime: '',
				}
		},
		[mutationTypes.getSingleReminderSuccess](state, payload) {
				state.isLoading = false
				state.singleReminderData = payload

		},
		[mutationTypes.getSingleReminderFailure](state, payload) {
				state.isLoading = false
				state.singleReminderData = {}
				state.errors = payload
		},

		/* Save reminder */
		[mutationTypes.saveReminderStart](state) {
				state.isLoading = true
				state.errors = {
						title: '',
						content: '',
						dateTime: '',
				}
		},
		[mutationTypes.saveReminderSuccess](state, payload) {
				state.isLoading = false
				state.singleReminderData = payload

		},
		[mutationTypes.saveReminderFailure](state, payload) {
				state.isLoading = false
				state.singleReminderData = {}
				state.errors = payload
		}

}

export const actionTypes = {
		getSingleReminder: '[reminder] Get single reminder data',
		createReminder: '[reminder] Create reminder',
		updateReminder: '[reminder] Update reminder',
		deleteReminder: '[reminder] Delete reminder',
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

		[actionTypes.createReminder](context, {title, content, dateTime}) {
				console.log(dateTime);
				return new Promise(resolve => {
						context.commit(mutationTypes.saveReminderStart)
						reminderApi.createReminder(apiUrl, title, content, dateTime)
								.then(response => {
										context.commit(mutationTypes.saveReminderSuccess, response.data)
										resolve(response.data)
								})
								.catch((e) => {
										context.commit(mutationTypes.saveReminderFailure, e.response.data.errors)
								})
				})
		},

}

export default {
		state,
		actions,
		mutations
}
