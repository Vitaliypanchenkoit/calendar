import newsApi from '../../api/news-api'
import reminderApi from "../../api/reminder-api";

const apiUrl = '/news';

const state = {
		news: {},
		singleNewsData: {
				title: '',
				content: '',
				date: '',
				time: '',
		},
		isLoading: false,
		errors: {
				title: '',
				content: '',
				date: '',
				time: '',
		},
		successMessage: '',
}

export const mutationTypes = {
		getSingleNewsStart: '[news] Get single news start',
		getSingleNewsSuccess: '[news] Get single news success',
		getSingleNewsFailure: '[news] Get single news failure',

		saveNewsStart: '[news] Save news start',
		saveNewsSuccess: '[news] Save news success',
		saveNewsFailure: '[news] Save news failure',

		getInputValue: '[news] Get value from input',
}

const mutations = {
		[mutationTypes.getSingleNewsStart](state) {
				state.isLoading = true
				state.singleNewsData = {
						title: '',
						content: '',
						date: '',
						time: '',
				}
				state.errors = {
						title: '',
						content: '',
						date: '',
						time: '',
				}
		},
		[mutationTypes.getSingleNewsSuccess](state, payload) {
				state.isLoading = false
				state.singleNewsData = payload
				state.singleNewsData.dateTime = payload.date + ' ' + payload.time

		},

		/* Save reminder */
		[mutationTypes.saveNewsStart](state) {
				state.isLoading = true
				state.successMessage = '';
				state.errors = {
						title: '',
						content: '',
						date: '',
						time: '',
				}
		},
		[mutationTypes.saveNewsSuccess](state) {
				state.isLoading = false
				state.successMessage = 'The News was created successfully';
				state.singleNewsData = {
						title: '',
						content: '',
						date: '',
						time: '',
				}

		},
		[mutationTypes.saveNewsFailure](state, payload) {
				state.isLoading = false
				state.errors = payload
		},

		[mutationTypes.getSingleNewsFailure](state, payload) {
				state.isLoading = false
				state.singleNewsData = {
						title: '',
						content: '',
						date: '',
						time: '',
				}
				state.errors = payload
		},

		/* Input data */
		[mutationTypes.getInputValue](state, payload) {
				state.singleNewsData = {
						...state.singleNewsData,
						[payload.name]: payload.value
				}
		},

}

export const actionTypes = {
		getSingleNews: '[news] Get single news data',
		createNews: '[news] Create news',
		updateNews: '[news] Update news',
		deleteNews: '[news] Delete news',
		getInputValue: '[news] Get input value',
}

const actions = {
		[actionTypes.getSingleNews](context, {id}) {
				if (!id) {
						return;
				}
				return new Promise(resolve => {
						context.commit(mutationTypes.getSingleNewsStart)
						newsApi.getSingleNews(apiUrl, id)
								.then(response => {
										context.commit(mutationTypes.getSingleNewsSuccess, response.data)
										resolve(response.data)
								})
								.catch((e) => {
										context.commit(mutationTypes.getSingleNewsFailure, e.response.data)
								})
				})
		},

		[actionTypes.createNews](context, {title, content, date, time}) {
				return new Promise(resolve => {
						context.commit(mutationTypes.saveNewsStart)
						reminderApi.createNews(apiUrl, title, content, date, time)
								.then(response => {
										context.commit(mutationTypes.saveNewsSuccess, response.data)
								})
								.catch((e) => {
										console.log(e.response.data);
										context.commit(mutationTypes.saveNewsFailure, e.response.data.errors)
								})
				})
		},

		[actionTypes.updateNews](context, {id, time, date}) {
				return new Promise(resolve => {
						context.commit(mutationTypes.saveNewsStart)
						reminderApi.updateNews(apiUrl, id, time, date)
								.then(response => {
										context.commit(mutationTypes.saveNewsSuccess, response.data)
								})
								.catch((e) => {
										context.commit(mutationTypes.saveNewsFailure, e.response.data.errors)
								})
				})
		},

		[actionTypes.getInputValue](context, {name, value}) {
				context.commit(mutationTypes.getInputValue, {name, value})

		},

}

export default {
		state,
		actions,
		mutations,
		// getters: {
		// 		date: function (state) {
		// 				return state.singleNewsData.date
		// 		},
		// 		time: function (state) {
		// 				return state.singleNewsData.time
		// 		}
		// }
}
