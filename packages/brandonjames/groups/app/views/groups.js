module.exports = {

	el: '#groups',

	ready: function () {
		this.resource = this.$resource('api/groups{/id}');
	},

	data: {
		groups: window.$data.groups,
		displayMessage: window.$data.displayMessage,
		searchText: '',
		fields: [ 'name', 'user.name' ],
		weekdays: {
			M: 'Monday',
			T: 'Tuesday',
			W: 'Wednesday',
			R: 'Thursday',
			F: 'Friday',
			S: 'Saturday',
			U: 'Sunday'
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

/**
 * Vue filter to make a simple timestamp for an ISO date.
 * http://jsfiddle.net/bryan_k/44kqtpeg/
 *
 * @param {String} value The value string.
 */
Vue.filter('time', function(value) {
	time = value.split(':');
	var amPm = 'PM';

	if (parseInt(time[0], 10) > 12)
	{
	   var hour = parseInt(time[0], 10) % 12;
	}
	else
	{
    	var hour = parseInt(time[0], 10);
	    if (hour == 12)
		{
			amPm = 'PM';
		}
		else
		{
			amPm = 'AM';
		}
	}

	return hour + ':' + time[1] + ' ' + amPm;
});

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
