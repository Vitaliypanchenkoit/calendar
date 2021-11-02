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
						<span class="text-red-600" v-if="errors.date">{{ errors.date[0] }}</span>data
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
						<input id="participant" class="flex-grow" v-model="newParticipantEmail" @keypress.enter="addParticipant()" />
						<span class="text-red-600" v-if="newParticipantEmailError">{{ newParticipantEmailError }}</span>
				</div>

				<div class="form-item mb-2">
						<label>Participants</label>
						<transition-group class="participants-list" name="participants-list" tag="div">
								<div v-for="(participant, index) in participants" class="participants-item" :key="participant">
										<div class="participants-item__title">{{ participant }}</div>
										<div class="participants-item__remove" @click="removeParticipant(index)">
												<div class="leftright"></div>
												<div class="rightleft"></div>
										</div>
								</div>
						</transition-group>
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
										participants: this.participants,
								})
						} else if (this.$route.name === 'editEvent') {
								this.$store.dispatch(actionTypes.updateEvent, {
										id: this.id,
										title: this.title,
										content: this.content,
										date: this.date,
										time: this.time,
										participants: this.participants,
								})
						}
				},
				async addParticipant() {
						this.newParticipantEmailError = '';
						if (!this.newParticipantEmail) {
								return;
						}

						if (!validateEmail(this.newParticipantEmail)) {
								this.newParticipantEmailError = 'Invalid email';
						} else if (this.participants.includes(this.newParticipantEmail)) {
								this.newParticipantEmailError = 'This email has been already included';
						} else {
								await this.$store.dispatch(actionTypes.addParticipant, this.newParticipantEmail)
								this.newParticipantEmail = '';
						}


				},
				removeParticipant(index) {
						if (!this.participants[index]) {
								return;
						}
						this.$store.dispatch(actionTypes.removeParticipant, index);

				},
		}

}
</script>

<style scoped>
.participants-list {
		padding: 1rem 1rem 1.7rem 1rem;
		background: #ffffff;
		border: 1px solid rgba(0, 0, 0, 0.2);
		border-radius: 5px;
}
.participants-item {
		position: relative;
		display: inline-block;
		margin-right: 2rem;
		margin-top: 0.5rem;
		padding: 0.7rem 1rem;
		background: rgba(0, 0, 0, 0.1);
		border-radius: 20px;
}
.participants-item__remove {
		position: absolute;
		top: 0;
		right: -8px;
		width: 10px;
		height: 10px;
		cursor: pointer;
}

.leftright{
		height: 2px;
		width: 20px;
		position: absolute;
		background-color: #F4A259;
		border-radius: 2px;
		transform: rotate(45deg);
		transition: all .3s ease-in;
}

.rightleft{
		height: 2px;
		width: 20px;
		position: absolute;
		background-color: #F4A259;
		border-radius: 2px;
		transform: rotate(-45deg);
		transition: all .3s ease-in;
}

.participants-item__remove:hover .leftright{
		transform: rotate(-45deg);
		background-color: #F25C66;
}
.participants-item__remove:hover .rightleft{
		transform: rotate(45deg);
		background-color: #F25C66;
}
.participants-list-enter-active, .participants-list-leave-active {
		transition: all 0.6s;
}
.participants-list-enter, .participants-list-leave-to {
		opacity: 0;
		transform: translateY(30px);
}

</style>
