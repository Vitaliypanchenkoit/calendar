import axios from "../api/axios";

const getEvent = (apiUrl, id) => {
		return axios.get(apiUrl, {
				params: {
						id: id
				}
		})
}

const createEvent = (apiUrl, title, content, date, time) => {
		let formData = new FormData();

		formData.append('title', title)
		formData.append('content', content)
		formData.append('date', date)
		formData.append('time', time)

		return axios.post(apiUrl, formData)
}

const updateEvent = (apiUrl, id, time, date) => {
		let formData = new FormData();

		formData.append('id', id)
		formData.append('time', time)
		formData.append('date', date)
		formData.append('_method', 'PUT')

		return axios.post(apiUrl, formData)
}

export default {
		getEvent,
		createEvent,
		updateEvent
}
