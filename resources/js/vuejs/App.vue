<template>
  <div id="calendar" class="position-relative">
			<reminder-pop-up v-if="showReminderPopUp" :reminder="reminder"></reminder-pop-up>
			<create-buttons></create-buttons>
			<transition name="fade">
    		<router-view></router-view>
			</transition>
  </div>
</template>

<script>
import CreateButtons from "./components/CreateButtons";
import ReminderPopUp from "./components/ReminderPopUp";
export default {
  name: "App",
		components: {
				CreateButtons,
				ReminderPopUp
		},
		data() {
			return {
					currentUser: window.currentUser,
					goTo: window.goTo,
					showReminderPopUp: false,
					reminder: {},
			}
		},
		created() {
			if (undefined !== this.goTo && this.goTo.routerName) {
					this.$router.push({name: this.goTo.routerName, params: {id: this.goTo.id}})
			}
		}
}
</script>

<style scoped>

</style>
