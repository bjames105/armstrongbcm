module.exports = {
	el: '#group',
	// replace this.$notify with UIKit.notify when I build a new theme.

	ready: function ()
	{
		this.resource = this.$resource('api/groups{/id}');
	},

	data: {
		group: window.$data.group,
		currentUser: window.$data.current_user,
		groupCategories: window.$data.group_categories,
		newDiscussionPost: { content: '' },
		postToDelete: null,
		weekdays: {
			M: 'Monday',
			T: 'Tuesday',
			W: 'Wednesday',
			R: 'Thursday',
			F: 'Friday',
			S: 'Saturday',
			U: 'Sunday'
		}
	},

	methods: {
		create: function()
		{
			this.resource.save({ new_group: this.group })
			.then(function (response)
			{
				window.location.href = '/index.php/groups/' + response.data.group.id
				this.$notify(response.data.message);
			}), function (error)
			{
				this.$notify(error.data.message, 'danger');
			};
		},
		update: function (e)
		{
			e.preventDefault();

			this.resource.update({ id: this.group.id }, { group: this.group })
			.then(function (response)
			{
				document.title = this.group.name + ' | Groups | Armstrong BCM';
				this.$notify("<i class='uk-icon-check'></i> " + response.data.message);
			},
			function (error)
			{
				this.$notify(error.data.message, 'danger');
			});
		},
		remove: function () {
			this.resource.delete({ id: this.group.id })
			.then(function (response)
			{
				window.location.href = "/index.php/groups";
			},
			function (error)
			{
				this.$notify(error.data.message, 'danger');
			});
		},
		join: function () {
			this.$http({url: 'api/groups/' + this.group.id + '/join', method: 'GET'})
			.then(function (response)
			{
				this.group.group_members.push(response.data.user);
				this.$notify("<i class='uk-icon-check'></i> " + response.data.message);
		    }, function (error)
			{
		        this.$notify(error.data.message, 'danger');
		    });
		},
		leave: function () {
			this.$http({url: 'api/groups/' + this.group.id + '/leave', method: 'GET'})
			.then(function (response)
			{
				for (var i = 0; i < this.group.group_members.length; i++)
				{
					if (this.group.group_members[i].id == this.currentUser.id)
					{
						this.group.group_members.splice(i, 1);
						break;
					}
				}

				this.$notify("<i class='uk-icon-check'></i> " + response.data.message);
		    }, function (error)
			{
		        this.$notify(error.data.message, 'danger');
		    });
		},
		postDiscussion: function (e)
		{
			e.preventDefault();

			this.$http({url: 'api/groups/' + this.group.id + '/discussion', method: 'POST', data: { content: this.newDiscussionPost }})
			.then(function (response)
			{
				this.group.group_discussion.push(response.data.group_discussion_post);
				this.newDiscussionPost = {};
				this.$notify("<i class='uk-icon-check'></i> " + response.data.message);
			}, function (error)
			{
				this.$notify(error.data.messsage, 'danger')
			});
		},
		setPostToDelete: function (post)
		{
			this.postToDelete = post;
		},
		deleteDiscussionPost: function (discussionPost)
		{
			this.$http({url: 'api/groups/discussion/' + discussionPost.id, method: 'DELETE'})
			.then(function (response)
			{
				this.group.group_discussion.$remove(discussionPost);
				this.postToDelete = null;
				this.$notify("<i class='uk-icon-check'></i> " + response.data.message);
			}, function (error)
			{
				this.$notify(error.data.messsage, 'danger')
			});
		},
		userCanJoinGroup: function ()
		{
			if (this.currentUser == null)
			{
				return false;
			}

			for (var i = 0; i < this.group.group_members.length; i++)
			{
				if (this.group.group_members[i].id == this.currentUser.id)
				{
					return false;
				}
			}

			return true;
		},
		userCanLeaveGroup: function ()
		{
			if (this.currentUser == null)
			{
				return false;
			}

			if (this.group.user_id == this.currentUser.id)
			{
				return false;
			}

			return !this.userCanJoinGroup();
		},
		userCreatedGroup: function ()
		{
			return this.group.user_id == this.currentUser.id;
		},
		setWeekday: function (weekday)
		{
			for (var thisWeekday in this.weekdays)
			{
				if (this.weekdays[thisWeekday] == weekday)
				{
					this.$data.group.active_day = thisWeekday;
				}
			}
		},
		upload: function (e)
		{
			e.preventDefault();

			$('#upload').click();
		},
		setGroupGender: function (gender)
		{
			this.group.gender = gender;
		}
	}
}

Vue.ready(module.exports);

/**
 * Vue filter to make a simple timestamp for an ISO date.
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
