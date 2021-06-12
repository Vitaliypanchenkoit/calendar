import axios from "../api/axios";

const getReminder = (apiUrl, id) => {
		return axios.get(apiUrl, {
				params: {
						id: id
				}
		})
}

const createReminder = (apiUrl, title, content, dateTime) => {
		console.log(title);
		return axios.post(apiUrl, {
				params: {
						title: title,
						content: content,
						dateTime: dateTime,
				}
		})
}

const updateReminder = (apiUrl, id, title, content, dateTime) => {
		return axios.put(apiUrl, {
				params: {
						id: id,
						title: title,
						content: content,
						dateTime: dateTime,
				}
		})
}

export default {
		getReminder,
		createReminder,
		updateReminder

}
