<template>
	<div>
		<h3 class="d-flex justify-content-center">Presence chat - requires authentication</h3>
		<div style="overflow-y: auto; height: 300px;">
			<div class="message" v-for="message in messages">
				<hr style="width: 200px">
				<h6 class="d-flex justify-content-center">From:&nbsp;<i>{{ message.user.name }}</i></h6>
				<div class="d-flex justify-content-center">Message: {{ message.body}}</div>
			</div>
		</div>
		<form class="form-inline" @submit.prevent="sendMessage">
			<div class="form-group">
				<label for="message">Message:</label>
				&nbsp;
				<input required id="message" class="form-control" placeholder="message.." type="text" name="message" v-model="form.message" v-on:keydown="userTyping">
				&nbsp;
			</div>
			<button type="submit" class="btn btn-primary mb2">Send message</button>
		</form>
	</div>
</template>

<script>
import Axios from 'axios'
	export default {
		data() {
			return {
				messages: [],
				form: {
					message: ''
				},
				auth_user: {},
			}
		},
		methods: {
			sendMessage () {
				Axios.post('http://127.0.0.1:8000/message/presence', this.form)
				.then((response) => {
					// console.log(response.data)
				})
				.catch((error) => {
					console.log(error.message)
				});
			},
			listen () {
				Echo.join('Presence')
					.here((users) => {
						// users currently in the room
						// console.log(users)
					})
					.joining((user) => {
						console.log('User ' + user.name + ' joining the room')
					})
					.leaving((user) => {
						console.log('user ' + user.name + ' left the room')
					})
					.listen('NewPresenceMessage', (response) => {
						console.log(response.message);
						this.messages.push(response.message);
					});
			},
			userTyping () {
				console.log('123')
				Echo.private('Presence').whisper('typing', {
					name: this.auth_user.name
				})
			}
		},
		mounted() {
			this.messages = JSON.parse(this._messages)
			this.auth_user = JSON.parse(this._auth_user)
			this.listen()
		},
		created() {
			Echo.private('Presence').listenForWhisper('typing', (name) => {
				console.log(name.name + ' is typing.')
			})
		},
		props: ['_messages', '_auth_user'],
	};
</script>