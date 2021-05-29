import monthApi from '../../api/month-api'

const apiUrl = '/month';

const state = {
		data: {},
		isLoading: false,
		errors: null
}

export const mutationTypes = {
		getDataStart: '[month] Get data start',
		getDataSuccess: '[month] Get data success',
		getDataFailure: '[month] Get data failure',
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
		getData: '[month] Get data of each date'
}

const actions = {
		[actionTypes.getData](context, {year, month}) {
				let weekDay = new Date(year, month, 1).getDay();

				let prevMonthOffset = weekDay === 0 ? 6 : weekDay - 1;

				let prevMonth = [];
				for (let i = prevMonthOffset; i > 0; i--) {
						prevMonth.push(i);
				}

				return new Promise(resolve => {
						context.commit(mutationTypes.getDataStart)
						monthApi.getData(apiUrl, year, month + 1)
								.then(response => {
										response.data.prevMonthOffset = prevMonth;
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
