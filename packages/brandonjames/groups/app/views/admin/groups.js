module.exports = {

	el: '#groups',

	ready: function () {
		this.resource = this.$resource('api/groups{/id}');
	},

	data: {
		groups: window.$data.groups,
		searchText: '',
		groupToDelete: { name: '' },
		weekdays: {
			M: 'Monday',
			T: 'Tuesday',
			W: 'Wednesday',
			R: 'Thursday',
			F: 'Friday',
			S: 'Saturday',
			U: 'Sunday'
		},
		genders: {
			c: 'Co-ed',
			m: 'Men\'s',
			f: 'Women\'s'
		},
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

		setGroupToDelete: function(group)
		{
			this.groupToDelete = group;
		}
	}
};

Vue.ready(module.exports);

/**
 * Vue filter to make a simple timestamp for an ISO date.
 * http://jsfiddle.net/bryan_k/44kqtpeg/
 *
 * @param {String} value The value string.
 */
Vue.filter('date', function(value) {
	var date = new Date(value);
	return date.toLocaleDateString();
});
