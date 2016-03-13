module.exports = {

	el: '#categories',

	ready: function () {
		this.resource = this.$resource('api/groups/categories{/id}');
	},

	data: {
		categories: window.$data.categories,
		searchText: '',
		newCategory: { }
	},

	methods: {
		add: function (e) {
			e.preventDefault();

			if (!this.newGroup) return;

			this.resource.save({ newCategory: this.newCategory }).then(function (data) {
				var response = data.data;
				this.groups.push(response.categorie);
				UIkit.notify(response.message, '');
			}, function (error) {
				UIkit.notify(error.data.message, 'danger');
			});
			this.newGroup = { };
		},

		remove: function (entry) {
			this.resource.delete({ id: entry.id }).then(function (data) {
				this.categories.$remove(entry);
				UIkit.notify(data.message, '');
			}, function (error) {
				UIkit.notify(error.data, 'danger');
			});
		},

		save: function (entry) {
			this.resource.update({ category: entry }).then(function (data) {
				this.categories.$remove(entry);
				UIkit.notify(data.message, '');
			}, function (error) {
				UIkit.notify(error.data, 'danger');
			});
		}
	}
};

Vue.ready(module.exports);
