<template>
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<go-home-button></go-home-button>
				<div class="success mb-4">{{ successMessage }}</div>
				<div class="form-item mb-2">
						<label for="title">Title</label>
						<div id="title" class="flex-grow fake-input">{{ title }}</div>
				</div>
				<div class="form-item mb-2">
						<label>Date</label>
						<div id="date" class="flex-grow fake-input">{{ date }}</div>
				</div>
				<div class="form-item mb-2">
						<label>Time</label>
						<div id="time" class="flex-grow fake-input">{{ time }}</div>
				</div>
				<div class="form-item mb-2">
						<label for="content">Content</label>
						<div id="content" class="flex-grow fake-textarea">{{ content }}</div>
				</div>

				<div class="form-item mb-2">
						<label>Participants</label>
						<div class="participants-list" name="participants-list" tag="div">
								<div v-for="(participant, index) in participants" class="participants-item" :key="participant">
										<div class="participants-item__title">{{ participant }}</div>
								</div>
						</div>
				</div>

				<div v-if="participants.includes($parent.currentUser.email)" class="body-item__control">
						<label>
								<input type="checkbox" :checked="take_part.includes($parent.currentUser.id)" @change="markEvent(id, 'take_part', !take_part.includes($parent.currentUser.id))">
								<span>I'll take part</span>
						</label>&#160;&#160;
						<label>
								<input type="checkbox" :checked="not_interesting.includes($parent.currentUser.id)" @change="markEvent(id,'not_interesting', !not_interesting.includes($parent.currentUser.id))">
								<span>Not interesting</span>
						</label>
				</div>
		</div>

</template>

<script>
import GoHomeButton from "../../components/GoHomeButton";
import {mapState} from "vuex";
import {actionTypes} from "../../store/modules/event";
export default {
		name: "EventDetails",
		props: {
				id: {
						type: Number,
						default: 0
				}
		},
		components: {
				GoHomeButton,
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
				author_id: {
						get () {
								return this.$store.state.event.singleEventData.author_id
						},
				},
				title: {
						get () {
								return this.$store.state.event.singleEventData.title
						},
				},
				content: {
						get () {
								return this.$store.state.event.singleEventData.content
						},
				},
				date: {
						get () {
								return this.$store.state.event.singleEventData.date
						},
				},
				time: {
						get () {
								return this.$store.state.event.singleEventData.time
						},
				},
				participants: {
						get () {
								return this.$store.state.event.singleEventData.participants
						},
				},
				take_part: {
						get () {
								return this.$store.state.event.singleEventData.take_part
						},
				},
				not_interesting: {
						get () {
								return this.$store.state.event.singleEventData.not_interesting
						},
				},
		},
		created() {
				console.log(this.$store);
				this.$store.dispatch(actionTypes.getSingleEvent, {id: this.id});
		},
		beforeRouteEnter(to, from, next) {
				next(vm => {
						vm.prevRoute = from
				})
		},
		methods: {
				markEvent(id, key, value) {
						this.$store.dispatch(actionTypes.markEvent, {id, key, value})
				}
		}
}
</script>

<style scoped>
.fake-input,
.fake-textarea {
		display: block;
		width: 100%;
		padding: 0.5em 1em;
		border: 1px solid rgba(0, 0, 0, 0.2);
		border-radius: 5px;
		background-color: #fff;
}
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

</style>
