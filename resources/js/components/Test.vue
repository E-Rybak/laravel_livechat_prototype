<template>
	<div>
		<h1>hey</h1>
	</div>
</template>
<script>
	export default {
		mounted() {
			console.log("HELLO")
			this.listen()
		},
		methods: {
			listen () {
				Echo.private('channel-name').listen('Test', (message) => { console.log(message) })
			}
		}
	}
</script>