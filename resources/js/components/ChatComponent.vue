<template>
	<div>
		<h3 class="d-flex justify-content-center">Public chat</h3>
		<div style="overflow-y: auto; height: 300px;">
			<div class="message" v-for="message in messages">
				<hr style="width: 200px">
				<h6 class="d-flex justify-content-center">From:&nbsp;<i>{{ message.user_id ? message.user.name : "Guest" }}</i></h6>
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
			this.listen()
			this.auth_user = JSON.parse(this._auth_user)
			this.messages = JSON.parse(this._messages)
			if (this.auth_user) {
				this.form.user_id = this.auth_user.id
			}
		},
		data () {
			return {
				messages: [],
				form: {
					message: '',
					user_id: null,
				},
				auth_user: {},
			}
		},
		methods: {
			listen ()
			{
				Echo.channel('public-channel')
					.listen('NewPublicMessage', (response) => {
						console.log(response);
						this.messages.push(response.message);
					});
			},
			sendMessage ()
			{
				if (this.auth_user) {
					this.form.user = this.auth_user.name
					Axios.post('http://127.0.0.1:8000/message', this.form).then(response => {
					// console.log(response.data)
				})
				} else {
					Axios.post('http://127.0.0.1:8000/message', this.form).then(response => {
					// console.log(response.data)
				})
				}
				
			}
		},
		props: ['_auth_user', '_messages'],
	};
</script>