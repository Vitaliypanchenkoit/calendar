import axios from "../api/axios";

const getData = (apiUrl, year, month, date) => {
		return axios.get(apiUrl, {
				params: {
						year: year,
						month: month,
						date: date,
				}
		})
}

export default {
		getData
}
