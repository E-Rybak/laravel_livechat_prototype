<template>
	<div>
		<ul v-for="room in rooms">
			<h2>Chatrooms</h2>
			<li>
				<h4><a :href="link + '/chatrooms/' +room.id">{{ room.name }}</a></h4>
				<h5>{{ room.created_at }}</h5>
			</li>
		</ul>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				rooms: [],
			}
		},
		props: ['_rooms', 'link'],
		mounted() {
			this.rooms = JSON.parse(this._rooms)
		},
		methods: {

		},
	};
</script>