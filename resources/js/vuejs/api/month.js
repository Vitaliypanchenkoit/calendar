import axios from "../api/axios";

const getDates = apiUrl => {
		return axios.get(apiUrl)
}

export default {
		getDates
}
