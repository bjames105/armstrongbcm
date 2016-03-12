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
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	__vue_script__ = __webpack_require__(1)
	__vue_template__ = __webpack_require__(2)
	module.exports = __vue_script__ || {}
	if (module.exports.__esModule) module.exports = module.exports.default
	if (__vue_template__) { (typeof module.exports === "function" ? module.exports.options : module.exports).template = __vue_template__ }
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), true)
	  if (!hotAPI.compatible) return
	  var id = "/Applications/XAMPP/xamppfiles/htdocs/armstrongbcm/packages/brandonjames/groups/app/components/groups-link.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 1 */
/***/ function(module, exports) {

	'use strict';

	// <template>
	// 	<div class="uk-form-row">
	// 		<label class="uk-form-label">Select a Group</label>
	// 		<select class="uk-width-1-1" v-model="link">
	// 			<option v-for="item in groups" :value="item.id | filter_link">{{ item.name }}</option>
	// 		</select>
	// 	</div>
	// </template>
	//
	// <script>
	module.exports = {
		link: { label: 'Groups' },

		props: ['link'],

		data: function data() {
			return { groups: [] };
		},

		created: function created() {
			this.resource = this.$resource('api/groups');
			this.resource.get().then(function (data) {
				this.$set('groups', data.data.groups);
			}, function (error) {
				UIkit.notify(error.data, 'danger');
			});
		},

		ready: function ready() {
			this.link = '@groups';
		},

		filters: {
			filter_link: function filter_link(val) {
				return this.link + '/group/' + val;
			}
		}
	};
	window.Links.components['link-groups'] = module.exports;
	// </script>

/***/ },
/* 2 */
/***/ function(module, exports) {

	module.exports = "\n\t<div class=\"uk-form-row\"> \n\t\t<label class=\"uk-form-label\">Select a Group</label>\n\t\t<select class=\"uk-width-1-1\" v-model=\"link\">\n\t\t\t<option v-for=\"item in groups\" :value=\"item.id | filter_link\">{{ item.name }}</option>\n\t\t</select>\n\t</div>\n";

/***/ }
/******/ ]);