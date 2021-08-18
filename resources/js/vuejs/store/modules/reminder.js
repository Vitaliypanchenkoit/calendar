import reminderApi from '../../api/reminder-api'

const apiUrl = '/reminders';

const state = {
		reminders: {},
		singleReminderData: {
				title: '',
				content: '',
				dateTime: '',
		},
		isLoading: false,
		errors: {
				title: '',
				content: '',
				dateTime: '',
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
}

const mutations = {
		[mutationTypes.getSingleReminderStart](state) {
				state.isLoading = true
				state.successMessage = '';
				state.singleReminderData = {
						title: '',
						content: '',
						dateTime: '',
				}
				state.errors = {
						title: '',
						content: '',
						dateTime: '',
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
						dateTime: '',
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
						dateTime: '',
				}
		},
		[mutationTypes.saveReminderSuccess](state, payload) {
				state.isLoading = false
				state.successMessage = 'The Reminder was created successfully';
				state.singleReminderData = {
						title: '',
						content: '',
						dateTime: '',
				}

		},
		[mutationTypes.saveReminderFailure](state, payload) {
				state.isLoading = false
				state.singleReminderData = {
						title: '',
						content: '',
						dateTime: '',
				}
				state.errors = payload
		},

		/* Input data */
		[mutationTypes.getInputValue](state, payload) {
			console.log('--------');
			console.log(payload);
				state.singleReminderData[payload.name] = payload.value;
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

		[actionTypes.createReminder](context, {title, content, dateTime}) {
				return new Promise(resolve => {
						context.commit(mutationTypes.saveReminderStart)
						reminderApi.createReminder(apiUrl, title, content, dateTime)
								.then(response => {
										context.commit(mutationTypes.saveReminderSuccess, response.data)
								})
								.catch((e) => {
										context.commit(mutationTypes.saveReminderFailure, e.response.data.errors)
								})
				})
		},

		[actionTypes.getInputValue](context, {name, value}){
			console.log(name	);
			console.log(value	);
				context.commit(mutationTypes.getInputValue, {name, value})
		},


}

export default {
		state,
		actions,
		mutations
}
