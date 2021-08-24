<template>
		<div class="create-buttons">
				<router-link
						class="create-new reminder"
						:to="{name: 'createReminder'}"
				>
						Create Reminder
				</router-link>
				<router-link
						class="create-new news"
						:to="{name: 'createNews'}"
				>
						Create News
				</router-link>
				<router-link
						class="create-new event"
						:to="{name: 'createEvent'}"
				>
						Create Event
				</router-link>
		</div>

</template>

<script>
export default {
		name: "CreateButtons"
}
</script>

<style scoped>
.create-buttons {
		padding: 0 2rem;
		margin-bottom: 2rem;
}
.create-new {
		display: inline-block;
		margin-right: 2rem;

}

</style>
