import axios from "../api/axios";

const getData = (apiUrl, start, end) => {
		return axios.get(apiUrl, {
				params: {
						start: start,
						end: end
				}
		})
}

export default {
		getData
}
