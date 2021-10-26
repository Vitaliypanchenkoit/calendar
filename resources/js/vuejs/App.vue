<template>
  <div id="calendar">
			<create-buttons></create-buttons>
			<transition name="fade">
    		<router-view></router-view>
			</transition>
  </div>
</template>

<script>
import CreateButtons from "./components/CreateButtons";
export default {
  name: "App",
		components: {
				CreateButtons
		},
		data() {
			return {
					currentUser: window.currentUser,
					goTo: window.goTo,
			}
		},
		created() {
			if (this.goTo) {
					this.$router.push({name: this.goTo.routerName, params: {id: this.goTo.id}})
			}
		}
}
</script>

<style scoped>

</style>
