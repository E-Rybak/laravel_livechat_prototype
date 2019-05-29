<template>
	<div>
	<h3 class="d-flex justify-content-center">Presence chat - requires authentication</h3>
	<div class="row">
		
		<form class="form-inline message col-sm-6" @submit.prevent="sendMessage">
			<div class="form-group">
				<label for="message">Message:</label>
				&nbsp;
				<input required id="message" class="form-control" placeholder="message.." type="text" name="message" v-model="form.message" v-on:keyup="userTyping">
				&nbsp;
			</div>
			<button type="submit" class="btn btn-primary mb2">Send message</button>
		</form>
		<div style="overflow-y: auto; height: 300px;">
			<div class="message col-sm-6" v-for="message in messages">
				<hr style="width: 200px">
				<h6 class="d-flex justify-content-center">From:&nbsp;<i>{{ message.user.id === auth_user.id ? "You" : message.user.name }}</i></h6>
				<div class="d-flex justify-content-center">Message: {{ message.body}}</div>
			</div>
		</div>
		<div class="container col-sm-4">
			<h5>Users online</h5>
			<div v-for="userOnline in usersOnline">
				{{ userOnline.name }} - {{ userOnline.email }}
			</div>
			<h5>Notification logs</h5>
			<div class="log" v-for="notification in notifications">
				{{ notification }}
			</div>
		</div>
		<div v-show="typing" class="typingNotification col-sm-12" align="center">
			<i>{{ name }} is typing</i>
		</div>
	</div>
	<div id="countdownExample">
    <div class="values"></div>
</div>
	</div>
</template>

<script>
import Axios from 'axios'
import Timer from 'easytimer.js';
	export default {
		data() {
			return {
				messages: [],
				form: {
					message: ''
				},
				auth_user: {},
				notifications: [],
				typing: false,
				name: '',
				usersOnline: [],
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
						this.usersOnline = users
					})
					.joining((user) => {
						let notification = user.name + ' joined the room'
						this.notifications.push(notification)
					})
					.leaving((user) => {
						let notification = user.name + ' left the room'
						this.notifications.push(notification)
					})
					.listen('NewPresenceMessage', (response) => {
						console.log(response.message);
						this.messages.push(response.message);
					});
			},
			userTyping () {
				let channel = Echo.private('Presence')

				setTimeout( () => {
					channel.whisper('typing', {
						name: this.auth_user.name,
						typing: true
					})
				}, 300)
			}
		},
		mounted() {
			this.messages = JSON.parse(this._messages)
			this.auth_user = JSON.parse(this._auth_user)
			this.listen()
		},
		created() {
			console.log("Listening for whisper")
			Echo.private('Presence').listenForWhisper('typing', (e) => {
				e.typing ? this.typing = true : this.typing = false
				this.name = e.name
				setTimeout( () => {
					this.typing = false;
				}, 1000)
			})
			
		},
		props: ['_messages', '_auth_user']
	};
</script>