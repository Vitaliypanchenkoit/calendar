import newsApi from "../../api/news-api";

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
	},
	successMessage: '',
}

export const mutationTypes = {
	getSingleNewsStart: '[news] Get single news start',
	getSingleNewsSuccess: '[news] Get single news success',
	getSingleNewsFailure: '[news] Get single news failure',

	createNewsStart: '[news] Create news start',
	createNewsSuccess: '[news] Create news success',
	createNewsFailure: '[news] Create news failure',

	updateNewsStart: '[news] Update news start',
	updateNewsSuccess: '[news] Update news success',
	updateNewsFailure: '[news] Update news failure',

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
		}
	},
	[mutationTypes.getSingleNewsSuccess](state, payload) {
		state.isLoading = false
		state.singleNewsData = payload
		state.singleNewsData.dateTime = payload.date + ' ' + payload.time

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

	/* Create news */
	[mutationTypes.createNewsStart](state) {
		state.isLoading = true
		state.successMessage = '';
		state.errors = {
			title: '',
			content: '',
		}
	},
	[mutationTypes.createNewsSuccess](state) {
		state.isLoading = false
		state.successMessage = 'The News was created successfully';
		state.singleNewsData = {
			title: '',
			content: '',
			date: '',
			time: '',
		}

	},
	[mutationTypes.createNewsFailure](state, payload) {
			state.isLoading = false
			state.errors = payload
	},

	/* Update news */
	[mutationTypes.updateNewsStart](state) {
		state.isLoading = true
		state.successMessage = '';
		state.errors = {
			title: '',
			content: '',
		}
	},
	[mutationTypes.updateNewsSuccess](state) {
		state.isLoading = false
		state.successMessage = 'The News was updated successfully';
	},
	[mutationTypes.updateNewsFailure](state, payload) {
		state.isLoading = false
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
			newsApi.getSingleNews(apiUrl + '/edit', id)
				.then(response => {
					context.commit(mutationTypes.getSingleNewsSuccess, response.data)
					resolve(response.data)
				})
				.catch((e) => {
					context.commit(mutationTypes.getSingleNewsFailure, e.response.data)
				})
		})
	},

	[actionTypes.createNews](context, {title, content}) {
		return new Promise(resolve => {
			context.commit(mutationTypes.createNewsStart)
			newsApi.createNews(apiUrl, title, content)
				.then(response => {
					context.commit(mutationTypes.createNewsSuccess, response.data)
				})
				.catch((e) => {
					console.log(e.response.data);
					context.commit(mutationTypes.createNewsFailure, e.response.data.errors)
				})
		})
	},

	[actionTypes.updateNews](context, {id, title, content}) {
		return new Promise(resolve => {
			context.commit(mutationTypes.updateNewsStart)
			newsApi.updateNews(apiUrl, id, title, content)
				.then(response => {
						context.commit(mutationTypes.updateNewsSuccess, response.data)
				})
				.catch((e) => {
						context.commit(mutationTypes.updateNewsFailure, e.response.data.errors)
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
