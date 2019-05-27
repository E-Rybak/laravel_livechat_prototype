<template>
	<div>
		<h3 class="d-flex justify-content-center">Private chat -&nbsp; <b>requires authentication</b></h3>
		<div style="overflow-y: auto; height: 300px;">
			<div class="message" v-for="message in imessages">
				<hr style="width: 200px">
				<h6 class="d-flex justify-content-center">From:&nbsp;<i>{{ message.user.name }}</i></h6>
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
			this.listen(this._roomid);
			console.log('Listening');
			this.imessages = JSON.parse(this._imessages)
			this.user = JSON.parse(this._user)
		},
		data() {
			return {
				imessages: [],
				form: {
					message: '',
					roomId: this._roomid
				},
				user: {},
			}
		},
		methods: {
			listen ($id)
			{
				let channel = 'App.User.' + $id
				console.log(channel)
				Echo.private(channel)
				.listen('NewPrivateMessage', (message) => {
					console.log(message)
					this.imessages.push(message)
				})
			},
			sendMessage ()
			{
				console.log(JSON.stringify(this.form))
				Axios.post('http://127.0.0.1:8000/message/private', this.form)
				.then(response => {
					// console.log(response.data)
				})
				.catch(error => {
					console.log(error)
				});
			}
		},
		props: ['_imessages', '_user', '_roomid', 'participants']
	};
</script>