import monthApi from '../../api/month-api'

const apiUrl = '/month';

const state = {
		data: {},
		prevMonthDates: [],
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
				console.log(1);
				state.isLoading = true
				state.data = {}
				state.prevMonthDates = []
				state.errors = null
		},
		[mutationTypes.getDataSuccess](state, payload) {
				console.log(2);
				state.isLoading = false
				state.data = payload

		},
		[mutationTypes.getDataFailure](state, payload) {
				console.log(3);
				state.isLoading = false
				state.data = {}
				state.prevMonthDates = []
				state.errors = payload
		}

}

export const actionTypes = {
		getData: '[month] Get data of each date'
}

const actions = {
		[actionTypes.getData](context, {year, month}) {

				// let daysInMonth = new Date(year, month + 1, 0).getDate();
				let daysInPrevMonth = new Date(year, month, 0).getDate();

				/* ??? */
				let weekDay = new Date(year, month, 1).getDay();
				let prevOffset = 0;
				if (weekDay === 0) {
						prevOffset = 6;
				} else {
						prevOffset = weekDay - 1;
				}
				for (let i = daysInPrevMonth; i > (daysInPrevMonth - prevOffset); i--) {
						state.prevMonthDates[i] = '';
				}

				/* ??? */

				// for (let i = 1; i <= daysInMonth ; i++) {
				// 		state.dates[i] = new Date(year, month, i);
				// }
				console.log(state.prevMonthDates);


				return new Promise(resolve => {
						context.commit(mutationTypes.getDataStart)
						monthApi.getData(apiUrl, year, month + 1)
								.then(response => {
										console.log(response);
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
