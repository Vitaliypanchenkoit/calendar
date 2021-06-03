import reminderApi from '../../api/reminder-api'

const apiUrl = '/reminders';

const state = {
		reminders: {},
		singleReminderData: {},
		isLoading: false,
		errors: null
}

export const mutationTypes = {
		getSingleReminderStart: '[reminder] Get single reminder start',
		getSingleReminderSuccess: '[reminder] Get single reminder success',
		getSingleReminderFailure: '[reminder] Get single reminder failure',
}

const mutations = {
		[mutationTypes.getSingleReminderStart](state) {
				state.isLoading = true
				state.singleReminderData = {}
				state.errors = null
		},
		[mutationTypes.getSingleReminderSuccess](state, payload) {
				state.isLoading = false
				state.singleReminderData = payload

		},
		[mutationTypes.getSingleReminderFailure](state, payload) {
				state.isLoading = false
				state.singleReminderData = {}
				state.errors = payload
		}

}

export const actionTypes = {
		getSingleReminder: '[reminder] Get single reminder data'
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
		}

}

export default {
		state,
		actions,
		mutations
}
