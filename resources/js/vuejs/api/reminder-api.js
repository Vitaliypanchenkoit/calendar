import axios from "../api/axios";

const getReminder = (apiUrl, id) => {
	return axios.get(apiUrl, {
		params: {
			id: id
		}
	})
}

const createReminder = (apiUrl, title, content, date, time) => {
	let formData = new FormData();

	formData.append('title', title)
	formData.append('content', content)
  formData.append('date', date)
  formData.append('time', time)

	return axios.post(apiUrl, formData)
}

const updateReminder = (apiUrl, id, time, date) => {
	let formData = new FormData();
	console.log(time);

	formData.append('id', id)
	formData.append('time', time)
	formData.append('date', date)
	formData.append('_method', 'PUT')

	return axios.post(apiUrl, formData)
}

const holdReminder = (apiUrl, id, period) => {
		let formData = new FormData();

		formData.append('id', id)
		formData.append('period', period)
		formData.append('_method', 'PUT')

		return axios.post(apiUrl, formData)
}

const completeReminder = (apiUrl, id) => {
		let formData = new FormData();

		formData.append('id', id)
		formData.append('_method', 'PUT')

		return axios.post(apiUrl, formData)
}

export default {
	  getReminder,
	  createReminder,
	  updateReminder,
    holdReminder,
		completeReminder,
}
