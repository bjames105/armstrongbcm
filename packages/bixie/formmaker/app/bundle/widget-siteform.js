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
/******/ ({

/***/ 0:
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	__vue_script__ = __webpack_require__(47)
	if (__vue_script__ &&
	    __vue_script__.__esModule &&
	    Object.keys(__vue_script__).length > 1) {
	  console.warn("[vue-loader] packages\\bixie\\formmaker\\app\\components\\widget-siteform.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(48)
	module.exports = __vue_script__ || {}
	if (module.exports.__esModule) module.exports = module.exports.default
	if (__vue_template__) {
	(typeof module.exports === "function" ? (module.exports.options || (module.exports.options = {})) : module.exports).template = __vue_template__
	}
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), true)
	  if (!hotAPI.compatible) return
	  var id = "C:\\BixieProjects\\pagekit\\pagekit\\packages\\bixie\\formmaker\\app\\components\\widget-siteform.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },

/***/ 47:
/***/ function(module, exports) {

	'use strict';

	module.exports = {

	    section: {
	        label: 'Settings'
	    },

	    replace: false,

	    props: ['widget', 'config', 'form'],

	    data: function data() {
	        return {
	            forms: []
	        };
	    },

	    created: function created() {
	        this.$options.partials = this.$parent.$options.partials;

	        this.$resource('api/formmaker/form').get().then(function (res) {
	            this.forms = res.data;
	            if (res.data.length) {
	                this.widget.data.form_id = this.widget.data.form_id || res.data[0].id;
	            }
	        });
	        this.widget.data = _.assign({ form_id: 0, formStyle: 'uk-form-stacked' }, this.widget.data);
	    }
	};

	window.Widgets.components['bixie-siteform:settings'] = module.exports;

/***/ },

/***/ 48:
/***/ function(module, exports) {

	module.exports = "\n\n<div class=\"uk-grid pk-grid-large pk-width-sidebar-large\" data-uk-grid-margin>\n    <div class=\"pk-width-content uk-form-horizontal\">\n\n        <div class=\"uk-form-row\">\n            <label for=\"form-title\" class=\"uk-form-label\">{{ 'Title' | trans }}</label>\n            <div class=\"uk-form-controls\">\n                <input id=\"form-title\" class=\"uk-form-width-large\" type=\"text\" name=\"title\" v-model=\"widget.title\" v-validate:required>\n                <p class=\"uk-form-help-block uk-text-danger\" v-show=\"form.title.invalid\">{{ 'Title cannot be blank.' | trans }}</p>\n            </div>\n        </div>\n\n        <div class=\"uk-form-row\">\n            <label for=\"form-link-formmaker\" class=\"uk-form-label\">{{ 'Form' | trans }}</label>\n            <div class=\"uk-form-controls\">\n                <select id=\"form-link-formmaker\" class=\"uk-form-width-large\" v-model=\"widget.data.form_id\">\n                    <option v-for=\"form in forms\" :value=\"form.id\">{{ form.title }}</option>\n                </select>\n            </div>\n        </div>\n\n        <div class=\"uk-form-row\">\n            <span class=\"uk-form-label\">{{ 'Form title' | trans }}</span>\n\n            <div class=\"uk-form-controls uk-form-controls-text\">\n                <label><input type=\"checkbox\" value=\"hide-title\" v-model=\"widget.data.hide_title\"> {{ 'Hide form title' |\n                    trans }}</label>\n            </div>\n        </div>\n\n\n        <div class=\"uk-form-row\">\n            <label for=\"form-formstyle\" class=\"uk-form-label\">{{ 'Form style' | trans }}</label>\n\n            <div class=\"uk-form-controls\">\n                <select id=\"form-formstyle\" class=\"uk-form-width-large\" v-model=\"widget.data.formStyle\">\n                    <option value=\"uk-form-stacked\">{{ 'Form stacked' | trans }}</option>\n                    <option value=\"uk-form-horizontal\">{{ 'Form horizontal' | trans }}</option>\n                </select>\n            </div>\n        </div>\n\n\n    </div>\n    <div class=\"pk-width-sidebar\">\n\n        <partial name=\"settings\"></partial>\n\n    </div>\n</div>\n\n";

/***/ }

/******/ });