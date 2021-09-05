import axios from "../api/axios";

const getData = (apiUrl, year, month, date) => {
		return axios.get(apiUrl, {
				params: {
						year: year,
						month: month,
						date: date,
				}
		})
};

const removeObject = (apiUrl, objectName, id) => {
		let formData = new FormData();

		formData.append('objectName', objectName)
		formData.append('id', id)
		console.log(objectName);
		return axios.post(apiUrl, formData)
}

export default {
		getData,
		removeObject
}
