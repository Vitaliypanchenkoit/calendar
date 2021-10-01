import axios from "../api/axios";

const getSingleNews = (apiUrl, id) => {
		return axios.get(apiUrl, {
				params: {
						id: id
				}
		})
}

const createNews = (apiUrl, title, content) => {
				let formData = new FormData();

				formData.append('title', title)
				formData.append('content', content)

				return axios.post(apiUrl, formData)
}

const updateNews = (apiUrl, id, title, content) => {
				let formData = new FormData();

				formData.append('id', id)
				formData.append('title', title)
				formData.append('content', content)
				formData.append('_method', 'PUT')

				return axios.post(apiUrl, formData)
}

const markNews = (apiUrl, id, key, value) => {
		console.log(3, apiUrl, id, key, value);
		value = value ? 1 : 0;
		let formData = new FormData();
		formData.append('newsId', id)
		formData.append('key', key)
		formData.append('value', value)
		formData.append('_method', 'PUT')

		return axios.post(apiUrl, formData)
}

export default {
		getSingleNews,
		createNews,
		updateNews,
		markNews
}
