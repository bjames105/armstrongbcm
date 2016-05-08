module.exports = {

	el: '#groups',

	ready: function () {
		this.resource = this.$resource('api/groups{/id}');

		var groupsMap = {};
		var groupsMapByCategory = {};
		var groupCategoriesMap = {};

		this.groupsMap = groupsMap;
		this.groupsMapByCategory = groupsMapByCategory;
		this.groupCategoriesMap = groupCategoriesMap;

		var mapGroup = function (group)
		{
			if (typeof groupsMap[group.id] == 'undefined')
			{
				groupsMap[group.id] = [];
			}
			if (typeof groupsMapByCategory[group.group_category_id] == 'undefined')
			{
				groupsMapByCategory[group.group_category_id] = [];
			}

			groupsMap[group.id].push(group);
			groupsMapByCategory[group.group_category_id].push(group);
		}

		var mapGroupCategory = function (category)
		{
			groupCategoriesMap[category.id] = category;
		}

		for (var i = 0; i < this.groups.length; i++)
		{
			mapGroup(this.groups[i]);
		}

		for (var i = 0; i < this.categories.length; i++)
		{
			mapGroupCategory(this.categories[i]);
		}

	},

	data: {
		groups: window.$data.groups,
		categories: window.$data.group_categories,
		displayMessage: window.$data.displayMessage,
		groupsMap: {},
		groupsMapByCategory: {},
		groupCategoriesMap: {},
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
				delete this.groupsMap[entry.id];
				delete this.groupsMapByCategory[group.category_id];
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
