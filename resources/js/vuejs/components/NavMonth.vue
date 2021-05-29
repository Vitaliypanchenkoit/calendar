<template>
		<div class="calendar_nav__current-month">
				<span class="calendar_nav__prev-month arrow arrow-left"></span>
				{{ this.monthNames[month] }}
				<span class="calendar_nav__next-month arrow arrow-right"></span>
		</div>
</template>

<script>
export default {
		name: "NavMonth",
		props: {
				month: {
						type: Number,
				},
		},
		data() {
				return {
						monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November',' December'],
				}
		},
}
</script>

<style scoped>

</style>
