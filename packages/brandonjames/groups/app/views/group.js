module.exports = {
	el: '#group',

	ready: function () {
		this.resource = this.$resource('api/groups{/id}');
	},

	data: {
		group: window.$data.group,
		newGroup: { }
	},

	methods: {
		add: function (e) {
			e.preventDefault();

			if (!this.newGroup) return;

			this.resource.save({ new_group: this.newGroup }).then(function (data) {
				UIkit.notify(response.message, '');
			}, function (error) {
				UIkit.notify(error.data.message, 'danger');
			});
			this.newGroup = { };
		}
	}
}

Vue.ready(module.exports);
