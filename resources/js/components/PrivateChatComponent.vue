<template>
	<div>
		<h3 class="d-flex justify-content-center">Private chat -&nbsp; <b>requires authentication</b></h3>
		<div style="overflow-y: auto; height: 300px;">
			<div class="message" v-for="message in imessages">
				<hr style="width: 200px">
				<h6 class="d-flex justify-content-center">From:&nbsp;<i>{{ user.name }}</i></h6>
				<div class="d-flex justify-content-center">Message: {{ message.body}}</div>
			</div>
		</div>
		<form class="form-inline" @submit.prevent="sendMessage">
			<div class="form-group">
				<label for="message">Message:</label>
				&nbsp;
				<input required id="message" class="form-control" placeholder="message.." type="text" name="message" v-model="form.message">
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
			console.log('Listening');
			this.imessages = JSON.parse(this._imessages)
			this.user = JSON.parse(this._user)
		},
		data() {
			return {
				imessages: [],
				form: {
					body: ''
				},
				user: {},
			}
		},
		methods: {
			listen ()
			{
				Echo.private('App.User.1')
				.listen('NewPrivateMessage', (message) => {
					this.imessages.push(message)
				})
			},
			sendMessage ()
			{
				Axios.post('http://127.0.0.1:8000/message/private', this.form)
				.catch(error => {
					console.log(error)
				});
			}
		},
		props: ['_imessages', '_user']
	};
</script>