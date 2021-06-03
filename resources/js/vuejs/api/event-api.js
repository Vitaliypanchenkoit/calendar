import axios from "../api/axios";

const getEvent = (apiUrl, id) => {
		return axios.get(apiUrl, {
				params: {
						id: id
				}
		})
}

export default {
		getEvent
}
