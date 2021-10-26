import dateApi from '../../api/date-api'
import newsApi from '../../api/news-api'

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

		markNewsStart: '[date] Mark/unmark news start',
		markNewsSuccess: '[date] Mark/unmark news success',
		markNewsFailed: '[date] Mark/unmark news as read or important',
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
		[mutationTypes.removeObjectSuccess](state, payload) {
				state.isLoading = false
				let objectName = payload.objectName.toLowerCase();
				objectName = objectName === 'event' ? 'events' : objectName;
				state.data[objectName].splice(payload.index, 1);
				state.data = {
						...state.data
				}

		},
		[mutationTypes.removeObjectFailure](state, payload) {
				state.isLoading = false
				state.errors = payload
		},

		/* Mark/unmark news as read or important */
		[mutationTypes.markNewsStart](state) {
				state.isLoading = true
		},
		[mutationTypes.markNewsSuccess](state, payload) {
				state.isLoading = false
		},
		[mutationTypes.markNewsFailed](state, payload) {
				state.isLoading = false
		},


}

export const actionTypes = {
		getData: '[date] Get data of a certain date',
		removeObject: '[date] Remove an object',
		markNews: '[date] Mark/unmark news as read or important',
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
										context.commit(mutationTypes.removeObjectSuccess, {objectName: objectName, index: index})
								})
								.catch((e) => {
										console.log(e);
										context.commit(mutationTypes.removeObjectFailure, e.response.data)
								})
				})
		},
		[actionTypes.markNews](context, {id, key, value}) { // key may be "read" or "important"; value may be true or false
				return new Promise(resolve => {
						context.commit(mutationTypes.markNewsStart)
						newsApi.markNews('/news/mark', id, key, value)
								.then(response => {
										context.commit(mutationTypes.markNewsSuccess, {})
								})
								.catch((e) => {
										console.log(e);
										context.commit(mutationTypes.markNewsFailed, e.response.data)
								})
				})
		},
}

export default {
		state,
		actions,
		mutations
}
