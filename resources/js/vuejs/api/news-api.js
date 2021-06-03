import axios from "../api/axios";

const getSingleNews = (apiUrl, id) => {
		return axios.get(apiUrl, {
				params: {
						id: id
				}
		})
}

export default {
		getSingleNews
}
