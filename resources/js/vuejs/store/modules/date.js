import dateApi from '../../api/date-api'

const apiUrl = '/month';

const state = {
		data: {},
		isLoading: false,
		errors: null
}

export const mutationTypes = {
		getDataStart: '[date] Get data start',
		getDataSuccess: '[date] Get data success',
		getDataFailure: '[date] Get data failure',
}

const mutations = {
		[mutationTypes.getDataStart](state) {
				state.isLoading = true
				state.data = {}
				state.errors = null
		},
		[mutationTypes.getDataSuccess](state, payload) {
				state.isLoading = false
				state.data = payload

		},
		[mutationTypes.getDataFailure](state, payload) {
				state.isLoading = false
				state.data = {}
				state.errors = payload
		}

}

export const actionTypes = {
		getData: '[date] Get data of a certain date'
}

const actions = {
		[actionTypes.getData](context, {year, month, date}) {
				return new Promise(resolve => {
						context.commit(mutationTypes.getDataStart)
						dateApi.getData(apiUrl, year, month + 1, date)
								.then(response => {
										context.commit(mutationTypes.getDataSuccess, response.data)
										resolve(response.data)
								})
								.catch((e) => {
										context.commit(mutationTypes.getDataFailure, e.response.data)
								})
				})
		}

}

export default {
		state,
		actions,
		mutations
}
