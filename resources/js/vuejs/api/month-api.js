import axios from "../api/axios";

const getData = (apiUrl, year, month) => {
		return axios.get(apiUrl, {
				params: {
						year: year,
						month: month
				}
		})
}

export default {
		getData
}
