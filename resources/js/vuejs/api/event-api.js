import axios from "../api/axios";

const getEvent = (apiUrl, id) => {
		return axios.get(apiUrl, {
				params: {
						id: id
				}
		})
}

const createEvent = (apiUrl, title, content, date, time, participants) => {
		let formData = new FormData();

		formData.append('title', title)
		formData.append('content', content)
		formData.append('date', date)
		formData.append('time', time)
		formData.append('participants', JSON.stringify(participants))

		return axios.post(apiUrl, formData)
}

const updateEvent = (apiUrl, id, title, content, date, time, participants) => {
		let formData = new FormData();

		formData.append('id', id)
		formData.append('title', title)
		formData.append('content', content)
		formData.append('date', date)
		formData.append('time', time)
		formData.append('participants', JSON.stringify(participants))
		formData.append('_method', 'PUT')

		return axios.post(apiUrl, formData)
}

export default {
		getEvent,
		createEvent,
		updateEvent
}
