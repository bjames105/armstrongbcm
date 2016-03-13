module.exports = {

	el: '#groups',

	ready: function () {
		this.resource = this.$resource('api/groups{/id}');
	},

	data: {
		groups: window.$data.groups,
		displayMessage: window.$data.displayMessage,
		newGroup: { }
	},

	methods: {
		add: function (e) {
			e.preventDefault();

			if (!this.newGroup) return;

			this.resource.save({ new_group: this.newGroup }).then(function (data) {
				var response = data.data;
				this.groups.push(response.group);
				UIkit.notify(response.message, '');
			}, function (error) {
				UIkit.notify(error.data.message, 'danger');
			});
			this.newGroup = { };
		},

		remove: function (entry) {
			this.resource.delete({ id: entry.id }).then(function (data) {
				this.groups.$remove(entry);
				UIkit.notify(data.message, '');
			}, function (error) {
				UIkit.notify(error.data, 'danger');
			});
		},

		save: function (entry) {
			this.resource.update({ group: entry }).then(function (data) {
				this.groups.$remove(entry);
				UIkit.notify(data.message, '');
			}, function (error) {
				UIkit.notify(error.data, 'danger');
			});
		}
	}
};

Vue.ready(module.exports);
