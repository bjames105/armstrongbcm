module.exports = {

	el: '#settings',

	ready: function () {
		this.resource = this.$resource('api/groups/update_settings');
	},

	data: {
		config: window.$data.config,
	},

	methods: {
		save: function (config) {
			this.resource.update({ 'config': window.$data.config}).then(function (resp)
			{
				var message = resp.data.message;
				UIkit.notify(message, '');
			},
			function (error)
			{
				var message = error.data.message;
				UIkit.notify(message, 'danger');
			});
		}
	}

};

Vue.ready(module.exports);
