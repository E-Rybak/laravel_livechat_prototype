<template>
	<div>
		<h3 class="d-flex justify-content-center">Public chat</h3>
		<div style="overflow-y: auto; height: 300px;">
			<div class="message" v-for="message in messages">
				<hr style="width: 200px">
				<h6 class="d-flex justify-content-center">From:&nbsp;<i>{{ message.username }}</i></h6>
				<div class="d-flex justify-content-center">Message: {{ message.message}}</div>
			</div>
		</div>
		<form class="form-inline" @submit.prevent="sendMessage">
			<div class="form-group">
				<label for="message">Message:</label>
				&nbsp;
				<input required id="message" class="form-control" placeholder="message.." type="text" name="message" v-model="form.message">
				&nbsp;
				<label for="user">Username:</label>
				&nbsp;
				<input required id="user" class="form-control" placeholder="username.." type="text" name="username" v-model="form.user">
				&nbsp;
			</div>
			<button type="submit" class="btn btn-primary mb2">Send message</button>
		</form>
	</div>
</template>
<script>
import Axios from 'axios'
	export default {
		mounted() {
			this.listen();
		},
		data () {
			return {
				messages: [],
				form: {
					user: '',
					message: ''
				},
			}
		},
		methods: {
			listen ()
			{
				Echo.channel('public-channel')
					.listen('NewPublicMessage', (message) => {
						console.log(message);
						this.messages.push(message);
					});
			},
			sendMessage ()
			{
				Axios.post('http://127.0.0.1:8000/SendNewMessage', this.form).then(response => {
					// console.log(response.data)
				})
			}
		}
	};
</script>