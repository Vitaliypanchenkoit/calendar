<template>
		<div class="select-container">
				<v-select :options="years" v-model="year"></v-select>
		</div>
</template>

<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
export default {
		name: "NavYear",
		components: {
				vSelect
		},
		props: {
				year: {
						type: Number,
				},
		},
		computed: {
				years: {
						get: function () {
								let arr = [];
								for (let i = (this.year - 10); i < this.year + 20; i++) {
										arr.push({label: i, code: i});
								}
								return arr;
						}
				}
		},
		created: function () {

		}
}
</script>

<style scoped>

</style>
