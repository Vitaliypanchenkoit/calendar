<template>
		<div class="calendar_nav__current-year">
				<span class="calendar_nav__prev-year arrow arrow-left"></span>
				{{ year }}
				<span class="calendar_nav__next-year arrow arrow-right"></span>
		</div>
</template>

<script>
export default {
		name: "NavYear",
		props: {
				year: {
						type: Number,
				},
		},
}
</script>

<style scoped>

</style>
