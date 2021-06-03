import eventApi from '../../api/event-api'

const apiUrl = '/events';

const state = {
		events: {},
		singleEventData: {},
		isLoading: false,
		errors: null
}

export const mutationTypes = {
		getSingleEventStart: '[event] Get single event start',
		getSingleEventSuccess: '[event] Get single event success',
		getSingleEventFailure: '[event] Get single event failure',
}

const mutations = {
		[mutationTypes.getSingleEventStart](state) {
				state.isLoading = true
				state.singleEventData = {}
				state.errors = null
		},
		[mutationTypes.getSingleEventSuccess](state, payload) {
				state.isLoading = false
				state.singleEventData = payload

		},
		[mutationTypes.getSingleEventFailure](state, payload) {
				state.isLoading = false
				state.singleEventData = {}
				state.errors = payload
		}

}

export const actionTypes = {
		getSingleEvent: '[event] Get single event data'
}

const actions = {
		[actionTypes.getSingleEvent](context, {id}) {
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
		}

}

export default {
		state,
		actions,
		mutations
}
