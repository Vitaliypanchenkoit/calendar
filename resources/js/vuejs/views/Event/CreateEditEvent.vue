<template>
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<go-home-button></go-home-button>
				<div class="success mb-4">{{ successMessage }}</div>
				<div class="form-item mb-2">
						<label for="title">Title</label>
						<input id="title" class="flex-grow" v-model="title" v-if="!id"/>
						<div class="disabled-input" v-else>{{ title }}</div>
						<span class="text-red-600" v-if="errors.title">{{ errors.title[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<label>Date</label>
						<datetime v-if="!id" v-model="date" :format="{ year: 'numeric', month: 'long', day: 'numeric' }"></datetime>
						<div class="disabled-input" v-else>{{ date }}</div>
						<span class="text-red-600" v-if="errors.date">{{ errors.date[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<label>Time</label>
						<datetime type="time" v-model="time"></datetime>
						<span class="text-red-600" v-if="errors.time">{{ errors.time[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<label for="content">Content</label>
						<textarea id="content" class="flex-grow" rows="8" v-model="content" v-if="!id"></textarea>
						<div class="disabled-textarea" v-else>{{ content }}</div>
						<span class="text-red-600" v-if="errors.content">{{ errors.content[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<div v-if="!id" class="save-button" @click="submit()">Create</div>
						<div v-else class="save-button" @click="submit()">Update</div>
				</div>

				<div class="form-item mb-2" v-if="$route.name === 'editEvent'">
						<v-select></v-select>

				</div>
		</div>

</template>

<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import {Datetime} from "vue-datetime";
import GoHomeButton from "../../components/GoHomeButton";
import {mapState} from "vuex";
import {actionTypes} from "../../store/modules/event";

export default {
		name: "CreateEditEvent",
		props: {
				id: {
						type: Number,
						default: 0
				}
		},
		components: {
				datetime: Datetime,
				GoHomeButton
		},
		data() {
				return {
						prevRoute: {path: ''},
				}
		},
		computed: {
				...mapState({
						isLoading: state => state.event.isLoading,
						errors: state => state.event.errors,
						successMessage: state => state.event.successMessage,
				}),
				title: {
						get () {
								return this.$store.state.event.singleEventData.title
						},
						set (value) {
								this.$store.dispatch(actionTypes.getInputValue, {name: 'title', value: value})
						}
				},
				content: {
						get () {
								return this.$store.state.event.singleEventData.content
						},
						set (value) {
								this.$store.dispatch(actionTypes.getInputValue, {name: 'content', value: value})
						}
				},
				date: {
						get () {
								return this.$store.state.event.singleEventData.date
						},
						set (value) {
								this.$store.dispatch(actionTypes.getInputValue, {name: 'date', value: value})
						}
				},
				time: {
						get () {
								return this.$store.state.event.singleEventData.time
						},
						set (value) {
								this.$store.dispatch(actionTypes.getInputValue, {name: 'time', value: value})
						}
				},
				participants: {
						get () {
								return this.$store.state.event.singleEventData.participants
						},
				}
		},
		created() {
				this.$store.dispatch(actionTypes.getSingleEvent, {id: this.id});
		},
		beforeRouteEnter(to, from, next) {
				next(vm => {
						vm.prevRoute = from
				})
		},
		methods: {
				submit() {
						if (this.$route.name === 'createEvent') {
								this.$store.dispatch(actionTypes.createEvent, {
										title: this.title,
										content: this.content,
										date: this.date,
										time: this.time,
								})
						} else if (this.$route.name === 'editEvent') {
								this.$store.dispatch(actionTypes.updateEvent, {
										id: this.id,
										time: this.time,
										date: this.date,
								})
						}
				},
		}

}
</script>

<style scoped>

</style>
