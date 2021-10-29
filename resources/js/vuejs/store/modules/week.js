import weekApi from '../../api/week-api'

const apiUrl = '/week';

const state = {
		data: {},
		isLoading: false,
		errors: null
}

export const mutationTypes = {
		getDataStart: '[week] Get data start',
		getDataSuccess: '[week] Get data success',
		getDataFailure: '[week] Get data failure',
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
		getWeekData: '[week] Get data of each date of week'
}

const actions = {
		[actionTypes.getWeekData](context, {start, end}) {
				return new Promise(resolve => {
						context.commit(mutationTypes.getDataStart)
						weekApi.getData(apiUrl, start, end)
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
