<template>
  <div id="calendar">
			<create-buttons></create-buttons>
    <router-view></router-view>
  </div>
</template>

<script>
import CreateButtons from "./components/CreateButtons";
export default {
  name: "App",
		components: {
				CreateButtons
		},
}
</script>

<style scoped>

</style>
