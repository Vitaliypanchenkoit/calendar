import axios from "../api/axios";

const getDates = (apiUrl, year, month) => {
		return axios.get(apiUrl, {
				params: {
						year: year,
						month: month
				}
		})
}

export default {
		getDates
}
