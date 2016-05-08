module.exports = {

	el: '#categories',

	ready: function () {
		this.resource = this.$resource('api/group_categories{/id}');
	},

	data: {
		categories: window.$data.categories,
		searchText: '',
		newCategory: { },
		categoryToDelete: { name: '' }
	},

	methods: {
		add: function ()
		{
			if (!this.newCategory) return;

			this.resource.save({ new_category: this.newCategory }).then(function (resp)
			{
				var response = resp.data;
				this.categories.push(response.category);
				UIkit.notify(response.message, '');
			},
			function (error)
			{
				UIkit.notify(error.data.message, 'danger');
			});
			this.newCategory = { };
		},
		remove: function (entry) {
			this.resource.delete({ id: entry.id }).then(function (resp)
			{
				var message = resp.data.message;
				this.categories.$remove(entry);
				this.categoryToDelete = { name: '' };
				UIkit.notify(message, '');
			},
			function (error)
			{
				this.$notify(error.data.message, 'danger');
			});
		},
		update: function (entry)
		{
			this.resource.update({ id: entry.id }, { group_category: entry })
			.then(function (response)
			{
				this.$notify("<i class='uk-icon-check'></i> " + response.data.message);
			},
			function (error)
			{
				this.$notify(error.data.message, 'danger');
			});
		},

		setCategoryToDelete: function(category)
		{
			this.categoryToDelete = category;
		}
	}
};

Vue.ready(module.exports);
