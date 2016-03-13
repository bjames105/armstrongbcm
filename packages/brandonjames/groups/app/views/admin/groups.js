module.exports = {

	el: '#groups',

	ready: function () {
		this.resource = this.$resource('api/groups{/id}');
	},

	data: {
		groups: window.$data.groups,
		searchText: '',
		groupToDelete: { name: '' },
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
			this.resource.delete({ id: entry.id }).then(function (resp) {
				var message = resp.data.message;
				this.groups.$remove(entry);
				this.groupToDelete = { name: '' };
				UIkit.notify(message, '');
			}, function (resp) {
				var message = resp.data.message;
				UIkit.notify(message, 'danger');
			});
		},

		save: function (entry) {
			this.resource.update({ group: entry }).then(function (data) {
				this.groups.$remove(entry);
				UIkit.notify(data.message, '');
			}, function (error) {
				UIkit.notify(error.data, 'danger');
			});
		},

		setGroupToDelete: function(group)
		{
			this.groupToDelete = group;
		}
	}
};

Vue.ready(module.exports);
