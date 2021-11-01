import axios from "../api/axios";

const getData = (apiUrl, start, end, shift) => {
		return axios.get(apiUrl, {
				params: {
						start: start,
						end: end,
						shift: shift
				}
		})
}

export default {
		getData
}
