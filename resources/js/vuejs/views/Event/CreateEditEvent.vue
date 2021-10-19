<template>
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<go-home-button></go-home-button>
				<div class="success mb-4">{{ successMessage }}</div>
				<div class="form-item mb-2">
						<label for="title">Title</label>
						<input id="title" class="flex-grow" v-model="title" />
						<span class="text-red-600" v-if="errors.title">{{ errors.title[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<label>Date</label>
						<datetime v-model="date" :format="{ year: 'numeric', month: 'long', day: 'numeric' }"></datetime>
						<span class="text-red-600" v-if="errors.date">{{ errors.date[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<label>Time</label>
						<datetime type="time" v-model="time"></datetime>
						<span class="text-red-600" v-if="errors.time">{{ errors.time[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<label for="content">Content</label>
						<textarea id="content" class="flex-grow" rows="8" v-model="content" ></textarea>
						<span class="text-red-600" v-if="errors.content">{{ errors.content[0] }}</span>
				</div>
				<div class="form-item mb-2">
						<button class="h-10 px-5 my-2 text-green-100 transition-colors duration-150 bg-green-600 rounded-lg hover:bg-green-700" @click="addParticipant()">Add a participant</button>
						<input id="participant" class="flex-grow" v-model="newParticipantEmail" />
						<span class="text-red-600" v-if="newParticipantEmailError">{{ newParticipantEmailError }}</span>
				</div>

				<div class="form-item mb-2">
						<label>Participants</label>
						<div class="participants-list">
								<div v-for="(participant, index) in participants" class="participants-item">
										<div class="participants-item__title"></div>
										<div class="participants-item__remove" @click="removeParticipant(index)"></div>
								</div>
						</div>
				</div>
				<div class="form-item mb-2">
						<div v-if="!id" class="save-button" @click="submit()">Create</div>
						<div v-else class="save-button" @click="submit()">Update</div>
				</div>

		</div>

</template>

<script>
import {Datetime} from "vue-datetime";
import GoHomeButton from "../../components/GoHomeButton";
import {mapState} from "vuex";
import {actionTypes} from "../../store/modules/event";
import {validateEmail} from "../../helpers/validationHelper"

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
				GoHomeButton,
		},
		data() {
				return {
						prevRoute: {path: ''},
						newParticipantEmail: '',
						newParticipantEmailError: '',
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
				},
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
				getUsers() {

				},
				async addParticipant() {
						this.newParticipantEmailError = '';
						if (!this.newParticipantEmail) {
								return;
						}

						if (!validateEmail(this.newParticipantEmail)) {
								this.newParticipantEmailError = 'Invalid email';
						} else if (this.singleEventData.participants.includes(newParticipantEmail)) {
								this.newParticipantEmailError = 'This email has been already included';
						} else {
								await this.$store.dispatch(actionTypes.addParticipant, this.newParticipantEmail)
								this.newParticipantEmail = '';
						}


				},
				removeParticipant(index) {
						if (!this.singleEventData.participants[index]) {
								return;
						}
						this.$store.dispatch(actionTypes.removeParticipant, index);

				},
		}

}
</script>

<style scoped>
.participants-list {
		padding: 1rem;
		background: #ffffff;
		border: 1px solid rgba(0, 0, 0, 0.2);
		border-radius: 5px;
}
.participants-item {
		position: relative;
		padding: 0.5rem 1rem;
		background: rgba(0, 0, 0, 0.2);
}
.participants-item__close {
		position: absolute;
		top: -10px;
		right: -10px;
}

</style>
