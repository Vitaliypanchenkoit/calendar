import axios from "../api/axios";

const getReminder = (apiUrl, id) => {
	return axios.get(apiUrl, {
		params: {
			id: id
		}
	})
}

const createReminder = (apiUrl, title, content, dateTime) => {
	let formData = new FormData();

	formData.append('title', title)
	formData.append('content', content)
	formData.append('dateTime', dateTime)

	return axios.post(apiUrl, formData)
}

const updateReminder = (apiUrl, id, title, content, dateTime) => {
	let formData = new FormData();

	formData.append('id', id)
	formData.append('title', title)
	formData.append('content', content)
	formData.append('dateTime', dateTime)
	formData.append('_method', 'PUT')

	return axios.post(apiUrl, formData)
}

export default {
	getReminder,
	createReminder,
	updateReminder
}
