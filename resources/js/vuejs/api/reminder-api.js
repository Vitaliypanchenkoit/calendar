import axios from "../api/axios";

const getReminder = (apiUrl, id) => {
		return axios.get(apiUrl, {
				params: {
						id: id
				}
		})
}

export default {
		getReminder
}
