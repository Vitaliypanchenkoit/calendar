<template>
		<div class="go-home mb-4 relative cursor-pointer">
				<router-link
						class="go-home__link ml-5 duration-500"
						:to="{name: 'month'}"
				>Back to calendar</router-link>
		</div>

</template>

<script>
export default {
		name: "GoHomeButton"
}
</script>

<style scoped>
.go-home::before {
		content: url(../../../../public/img/chevron-up-solid.svg);
		position: absolute;
		left: -7px;
		top: 6px;
		display: block;
		width: 10px;
		height: 10px;
		transform: rotate(-90deg);
}
.go-home:hover .go-home__link{
		margin-left: 2rem;
}

</style>
