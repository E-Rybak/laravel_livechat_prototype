<template>
	<div>
		{{ title }}
	</div>
</template>

<script>
import Axios from 'axios'

	export default {
		mounted() {
			this.listen();
			console.log('Listening');
			this.TriggerEvent();
			console.log('Sent message');
		},
		data() {
			return {
				title: 'Hello World',
				form: {
					message: 'This is the message',
				}
			}
		},
		methods: {
			listen () 
			{
				Echo.private('App.User.1')
				.listen('NewPrivateMessage', (message) => {
					console.log(message)
				})
			},
			TriggerEvent () 
			{
				Axios.post('http://127.0.0.1:8000/message/private', this.form)
				.then(response => {
					 console.log(response.data)
				}).catch(error => { console.log(error) })
			}
		}
	};
</script>