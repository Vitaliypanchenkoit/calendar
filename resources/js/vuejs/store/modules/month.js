import monthApi from '../../api/month'
const state = {
		dates: null,
		isLoading: false,
		error: null
}

export const mutationTypes = {
		getDatesStart: '[month] Get dates start',
		getDatesSuccess: '[month] Get dates success',
		getDatesFailure: '[month] Get feed failure',
}

const mutations = {
		[mutationTypes.getDatesStart](state) {
				state.isLoading = true
				state.dates = null
		},
		[mutationTypes.getDatesSuccess](state, payload) {
				state.isLoading = false
				state.dates = payload
		},
		[mutationTypes.getDatesFailure](state) {
				state.isLoading = false
				state.dates = null
		}

}

export const actionTypes = {
		getDates: '[month] Get dates'
}

const actions = {
		[actionTypes.getDates](context, {apiUrl}) {
				return new Promise(resolve => {
						context.commit(mutationTypes.getDatesStart)
						monthApi.getDates(apiUrl)
								.then(response => {
										context.commit(mutationTypes.getDatesSuccess, response.data)
										resolve(response.data)
								})
								.catch(() => {
										context.commit(mutationTypes.getDatesFailure)
								})
				})
		}

}

export default {
		state,
		actions,
		mutations
}
