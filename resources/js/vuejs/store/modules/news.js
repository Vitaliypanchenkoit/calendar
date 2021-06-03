import newsApi from '../../api/news-api'

const apiUrl = '/news';

const state = {
		news: {},
		singleNewsData: {},
		isLoading: false,
		errors: null
}

export const mutationTypes = {
		getSingleNewsStart: '[news] Get single news start',
		getSingleNewsSuccess: '[news] Get single news success',
		getSingleNewsFailure: '[news] Get single news failure',
}

const mutations = {
		[mutationTypes.getSingleNewsStart](state) {
				state.isLoading = true
				state.singleNewsData = {}
				state.errors = null
		},
		[mutationTypes.getSingleNewsSuccess](state, payload) {
				state.isLoading = false
				state.singleNewsData = payload

		},
		[mutationTypes.getSingleNewsFailure](state, payload) {
				state.isLoading = false
				state.singleNewsData = {}
				state.errors = payload
		}

}

export const actionTypes = {
		getSingleNews: '[news] Get single news data'
}

const actions = {
		[actionTypes.getSingleNews](context, {id}) {
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
		}

}

export default {
		state,
		actions,
		mutations
}
