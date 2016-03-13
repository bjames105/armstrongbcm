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


/***/ }
/******/ ]);