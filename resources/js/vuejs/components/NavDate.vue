<template>
		<div class="calendar_nav__current-date">
				<span class="calendar_nav__prev-date arrow arrow-left"></span>
				{{ date }}
				<span class="calendar_nav__next-date arrow arrow-right"></span>
		</div>
</template>

<script>
export default {
		name: "NavDate",
		props: {
				date: {
						type: Number,
				},
		},
}
</script>

<style scoped>

</style>
