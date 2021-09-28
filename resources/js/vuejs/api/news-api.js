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

export default {
		getSingleNews,
				createNews,
				updateNews
}
