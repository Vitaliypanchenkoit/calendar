import eventApi from '../../api/event-api'
import router from '../../router/router'
const apiUrl = '/events';

const state = {
		events: {},
		singleEventData: {
				title: '',
				content: '',
				date: '',
				time: '',
				participants: []
		},
		isLoading: false,
		errors: {
				title: '',
				content: '',
				date: '',
				time: '',
				participants: ''
		},
		successMessage: '',
}

export const mutationTypes = {
		getSingleEventStart: '[event] Get single event start',
		getSingleEventSuccess: '[event] Get single event success',
		getSingleEventFailure: '[event] Get single event failure',

		saveEventStart: '[event] Save event start',
		saveEventSuccess: '[event] Save event success',
		saveEventFailure: '[event] Save event failure',

		getInputValue: '[event] Get value from input',

		addParticipant: '[event] Add a participant',
		removeParticipant: '[event] Remove a participant',
}

const mutations = {
		[mutationTypes.getSingleEventStart](state) {
				state.isLoading = true
				state.singleEventData = {
						title: '',
						content: '',
						date: '',
						time: '',
						participants: []
				}

				state.errors = {
						title: '',
						content: '',
						date: '',
						time: '',
						participants: '',
				}

		},
		[mutationTypes.getSingleEventSuccess](state, payload) {
				state.isLoading = false
				state.singleEventData = payload
		},
		[mutationTypes.getSingleEventFailure](state, payload) {
				state.isLoading = false
				state.singleEventData = {
						title: '',
						content: '',
						date: '',
						time: '',
						participants: [],
				}
				state.errors = payload
		},

		/* Save event */
		[mutationTypes.saveEventStart](state) {
				state.isLoading = true
				state.successMessage = '';
				state.errors = {
						title: '',
						content: '',
						date: '',
						time: '',
						participants: ''
				}

		},
		[mutationTypes.saveEventSuccess](state, payload) {
				console.log(payload);
				state.isLoading = false
				state.successMessage = 'The Event was created successfully';
				router.push({path: `/events/edit/${payload.id}`})
		},
		[mutationTypes.saveEventFailure](state, payload) {
				state.isLoading = false
				state.errors = payload
		},

		/* Input data */
		[mutationTypes.getInputValue](state, payload) {
				state.singleEventData = {
						...state.singleEventData,
						[payload.name]: payload.value
				}
		},

		[mutationTypes.addParticipant](state, email) {
				state.singleEventData.participants.push(email);
				state.singleEventData = {
						...state.singleEventData
				}
		},

		[mutationTypes.removeParticipant](state, index) {
				state.singleEventData.participants.splice(index, 1);
				state.singleEventData = {
						...state.singleEventData,
				}
		},

}

export const actionTypes = {
		getSingleEvent: '[event] Get single event data',
		createEvent: '[event] Create event',
		updateEvent: '[event] Update event',
		getInputValue: '[event] Get input value',
		addParticipant: '[event] Add participant',
		removeParticipant: '[event] Remove participant',
}

const actions = {
		[actionTypes.getSingleEvent](context, {id}) {
				if (!id) {
						return;
				}
				return new Promise(resolve => {
						context.commit(mutationTypes.getSingleEventStart)
						eventApi.getEvent(apiUrl, id)
								.then(response => {
										context.commit(mutationTypes.getSingleEventSuccess, response.data)
										resolve(response.data)
								})
								.catch((e) => {
										context.commit(mutationTypes.getSingleEventFailure, e.response.data)
								})
				})
		},

		[actionTypes.createEvent](context, {title, content, date, time, participants}) {
				return new Promise(resolve => {
						context.commit(mutationTypes.saveEventStart)
						eventApi.createEvent(apiUrl, title, content, date, time, participants)
								.then(response => {
										console.log(response);
										console.log(response.data);
										console.log(JSON.parse(response.data));
										context.commit(mutationTypes.saveEventSuccess, response.data.data)
								})
								.catch((e) => {
										console.log(e);
										context.commit(mutationTypes.saveEventFailure, e.response.data.errors)
								})
				})
		},

		[actionTypes.updateEvent](context, {id, title, content, date, time, participants}) {
				return new Promise(resolve => {
						context.commit(mutationTypes.saveEventStart)
						eventApi.updateEvent(apiUrl, id, title, content, date, time, participants)
								.then(response => {
										console.log(response.data);
										context.commit(mutationTypes.saveEventSuccess, response.data)
								})
								.catch((e) => {
										context.commit(mutationTypes.saveEventFailure, e.response.data.errors)
								})
				})
		},

		[actionTypes.getInputValue](context, {name, value}) {
				context.commit(mutationTypes.getInputValue, {name, value})

		},

		[actionTypes.addParticipant](context, email) {
				context.commit(mutationTypes.addParticipant, email)
		},

		[actionTypes.removeParticipant](context, index) {
				context.commit(mutationTypes.removeParticipant, index)
		},




}

export default {
		state,
		actions,
		mutations
}
