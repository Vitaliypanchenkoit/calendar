import dateApi from '../../api/date-api'

const apiUrl = '/date';

const state = {
		data: {},
		isLoading: false,
		errors: null
}

export const mutationTypes = {
		getDataStart: '[date] Get data start',
		getDataSuccess: '[date] Get data success',
		getDataFailure: '[date] Get data failure',

		removeObjectStart: '[date] Remove object start',
		removeObjectSuccess: '[date] Remove object success',
		removeObjectFailure: '[date] Remove object failure',
}

const mutations = {
		/* Get Data */
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
		},

		/* Remove an Object */
		[mutationTypes.removeObjectStart](state) {
				state.isLoading = true
				state.errors = null
		},
		[mutationTypes.removeObjectSuccess](state, index) {
				state.isLoading = false
				delete state.data.reminders[index];
				state.data = {
						...state.data
				}

		},
		[mutationTypes.removeObjectFailure](state, payload) {
				state.isLoading = false
				state.errors = payload
		}

}

export const actionTypes = {
		getData: '[date] Get data of a certain date',
		removeObject: '[date] Remove an object',
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
		},
		[actionTypes.removeObject](context, {objectName, id, index}) {
				return new Promise(resolve => {
						context.commit(mutationTypes.removeObjectStart)
						dateApi.removeObject('/removeObject', objectName, id)
								.then(response => {
										context.commit(mutationTypes.removeObjectSuccess, index)
								})
								.catch((e) => {
										console.log(e);
										context.commit(mutationTypes.removeObjectFailure, e.response.data)
								})
				})
		}

}

export default {
		state,
		actions,
		mutations
}
