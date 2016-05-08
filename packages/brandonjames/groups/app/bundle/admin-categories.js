/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports) {

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


/***/ }
/******/ ]);