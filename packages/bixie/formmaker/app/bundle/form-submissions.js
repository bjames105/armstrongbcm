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

	module.exports = {

	    el: '#formmaker-submissions',

	    data: function () {
	        return _.merge({
	            submissions: false,
	            submissionID: 0,
	            pages: 0,
	            count: '',
	            selected: []
	        }, window.$data);
	    },

	    created: function () {
	        this.resource = this.$resource('api/formmaker/submission{/id}', {'export': {method: 'post', url: 'api/formmaker/submission/csv'}});
	        this.config.filter = _.extend({ status: '', form: '', order: 'created desc'}, this.config.filter);
	    },

	    events: {
	        'close.submissionmodal': function () {
	            if (this.$url.current.hash) {
	                window.history.replaceState({}, '', this.$url.current.href.replace('#' + this.$url.current.hash, ''));
	                this.$url.current.hash = '';
	            }
	        },
	        'close.csvmodal': function () {
	            this.load();
	        }
	    },

	    watch: {

	        'config.page': 'load',

	        'config.filter': {
	            handler: function () { this.load(0); },
	            deep: true
	        }

	    },

	    computed: {

	        statusOptions: function () {

	            var options = _.map(this.statuses, function (status, id) {
	                return { text: status, value: id };
	            });

	            return [{ text: this.$trans('Status'), value: '' }, { text: this.$trans('Show all'), value: 'all' }, { label: this.$trans('Filter by'), options: options }];
	        },

	        formOptions: function () {

	            var options = _.map(this.forms, function (form) {
	                return { text: form.title, value: form.id };
	            });

	            return [{ text: this.$trans('Form'), value: '' }, { label: this.$trans('Filter by'), options: options }];
	        }

	    },

	    methods: {

	        load: function (page) {

	            page = page !== undefined ? page : this.config.page;

	            this.resource.query({ filter: this.config.filter, page: page }).then(function (res) {
	                this.$set('submissions', res.data.submissions);
	                this.$set('pages', res.data.pages);
	                this.$set('count', res.data.count);
	                this.$set('config.page', page);
	                this.$set('selected', []);
	                this.checkDetailHash();
	            });
	        },

	        checkDetailHash: function () {
	            if (this.$url.current.hash) {
	                var id = parseInt(this.$url.current.hash, 10), submission = _.find(this.submissions, function (submission) {
	                    return submission.id === id;
	                });
	                if (submission) {
	                    this.submissionDetails(submission);
	                }
	            }
	        },

	        active: function (submission) {
	            return this.selected.indexOf(submission.id) !== -1;
	        },

	        getSelected: function () {
	            return this.submissions.filter(function(submission) { return this.selected.indexOf(submission.id) !== -1; }, this);
	        },

	        getStatusText: function (submission) {
	            return this.statuses[submission.status];
	        },

	        status: function (status, submissions) {

	            submissions = submissions || this.getSelected();

	            submissions.forEach(function (submission) {
	                submission.status = status;
	            });

	            this.resource.save({id: 'bulk'}, {submissions: submissions}).then(function () {
	                this.load();
	                this.$notify('Submission(s) saved.');
	            });
	        },

	        toggleStatus: function (submission) {
	            submission.status = submission.status === 2 ? 0 : submission.status + 1;
	            this.resource.save({id: submission.id}, {submission: submission}).then(function () {
	                this.load();
	                this.$notify('Submission saved.');
	            });
	        },

	        removeSubmissions: function () {

	            this.resource.delete({id: 'bulk'}, {ids: this.selected}).then(function () {
	                this.load();
	                this.$notify('Submission(s) deleted.');
	            });
	        },

	        submissionDetails: function (submission) {
	            window.history.replaceState({}, '', this.$url.current.href.replace('#' + this.$url.current.hash, '') + '#' + submission.id);
	            this.$url.current.hash = '#' + submission.id;
	            this.submissionID = submission.id;
	            this.$refs.submissionmodal.open();
	        },

	        formatValue: function (fieldvalue) {
	            if (window.Formmakerfields.components[fieldvalue.type] && typeof window.Formmakerfields.components[fieldvalue.type].formatValue === 'function') {
	                console.log(fieldvalue.value);
	                return window.Formmakerfields.components[fieldvalue.type].formatValue.apply(this, [fieldvalue]);
	            }
	            return typeof fieldvalue.value === 'string' ? [fieldvalue.value] : fieldvalue.value;
	        }

	    },

	    components: {
	        'submissiondetail': __webpack_require__(32),
	        'submissioncsv': __webpack_require__(35)
	    }

	};

	__webpack_require__(31)(Vue);

	Vue.ready(module.exports);



/***/ },

/***/ 31:
/***/ function(module, exports) {

	module.exports = function (Vue) {

	    Vue.filter('datetime', function (date) {
	        if (typeof date === 'string') {
	            date = new Date(date);
	        }
	        return date ? this.$date(date, 'mediumDate') + ', ' + this.$date(date, 'HH:mm:ss') : '';
	    });

	    Vue.filter('shortcode', function (slug, key) {
	        return '$$ ' + slug + ':' + key + ' $$';
	    });

	};

/***/ },

/***/ 32:
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	__vue_script__ = __webpack_require__(33)
	if (__vue_script__ &&
	    __vue_script__.__esModule &&
	    Object.keys(__vue_script__).length > 1) {
	  console.warn("[vue-loader] packages\\bixie\\formmaker\\app\\components\\submission-detail.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(34)
	module.exports = __vue_script__ || {}
	if (module.exports.__esModule) module.exports = module.exports.default
	if (__vue_template__) {
	(typeof module.exports === "function" ? (module.exports.options || (module.exports.options = {})) : module.exports).template = __vue_template__
	}
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), true)
	  if (!hotAPI.compatible) return
	  var id = "C:\\BixieProjects\\pagekit\\pagekit\\packages\\bixie\\formmaker\\app\\components\\submission-detail.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },

/***/ 33:
/***/ function(module, exports) {

	'use strict';

	module.exports = {
	    data: function data() {
	        return {
	            submission: { status: null },
	            loaded: false
	        };
	    },

	    props: ['submissionid'],

	    created: function created() {

	        this.$root.resource.query({ id: 'detail', submission_id: this.submissionid }).then(function (res) {
	            this.$set('submission', res.data);
	            this.loaded = true;
	        }.bind(this));
	    },

	    beforeDestroy: function beforeDestroy() {
	        this.$dispatch('close.submissionmodal');
	    },

	    watch: {
	        'submission.status': function submissionStatus(value, oldValue) {
	            if (oldValue !== null && oldValue !== value) {
	                this.$root.status(value, [this.submission]);
	            }
	        }
	    }
	};

/***/ },

/***/ 34:
/***/ function(module, exports) {

	module.exports = "\n    <div class=\"uk-modal-spinner\" v-if=\"!loaded\"></div>\n    <div v-show=\"loaded\">\n        <div class=\"uk-grid\">\n            <div class=\"uk-width-medium-3-4\">\n\n                <h2 class=\"uk-margin-top-remove\">{{ 'Submission for form \"%formtitle%\"' | trans {formtitle:submission.form_title} }}</h2>\n                <dl class=\"uk-description-list uk-description-list-horizontal\">\n                    <dt>{{ 'Submission date' | trans }}</dt><dd>{{ submission.created | datetime }}</dd>\n                    <dt>{{ 'Submission status' | trans }}</dt><dd :class=\"{'uk-text-danger': submission.status == 0,\n\t\t\t\t\t\t\t  'uk-text-primary': submission.status == 1,\n\t\t\t\t\t\t\t  'uk-text-success': submission.status == 2}\">{{ $root.getStatusText(submission) | trans }}</dd>\n                    <dt>{{ 'Remote IP address' | trans }}</dt><dd>{{ submission.ip }}</dd>\n                    <dt>{{ 'Email sent to' | trans }}</dt>\n                    <dd>\n                        <a v-if=\"submission.email\" href=\"mailto:{{ submission.email }}\">{{ submission.email }}</a>\n                        <span v-else>{{ 'No email provided' | trans }}</span>\n                    </dd>\n                </dl>\n                <h3>{{ 'Submission data' | trans }}</h3>\n                <dl class=\"uk-description-list uk-description-list-horizontal\">\n                    <template v-for=\"fieldsubmission in submission.fieldsubmissions\">\n                        <dt>{{ fieldsubmission.field.label}}</dt>\n                        <dd v-for=\"value in fieldsubmission.formatted\">{{{ value }}}</dd>\n                    </template>\n                </dl>\n\n            </div>\n            <div class=\"uk-width-medium-1-4 uk-form\">\n\n               <div class=\"uk-form-row\">\n                    <label for=\"form-status\" class=\"uk-form-label\">{{ 'Status' | trans }}</label>\n\n                    <div class=\"uk-form-controls\">\n                        <select id=\"form-status\" class=\"uk-width-1-1\" v-model=\"submission.status\" number>\n                            <option v-for=\"option in $root.statuses\" :value=\"$key\">{{ option }}</option>\n                        </select>\n                    </div>\n                </div>\n\n            </div>\n        </div>\n\n    </div>\n\n    <div class=\"uk-modal-footer uk-text-right\">\n        <button type=\"button\" class=\"uk-button uk-modal-close\">{{ 'Close' | trans }}</button>\n    </div>\n\n";

/***/ },

/***/ 35:
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	__vue_script__ = __webpack_require__(36)
	if (__vue_script__ &&
	    __vue_script__.__esModule &&
	    Object.keys(__vue_script__).length > 1) {
	  console.warn("[vue-loader] packages\\bixie\\formmaker\\app\\components\\submission-csv.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(37)
	module.exports = __vue_script__ || {}
	if (module.exports.__esModule) module.exports = module.exports.default
	if (__vue_template__) {
	(typeof module.exports === "function" ? (module.exports.options || (module.exports.options = {})) : module.exports).template = __vue_template__
	}
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), true)
	  if (!hotAPI.compatible) return
	  var id = "C:\\BixieProjects\\pagekit\\pagekit\\packages\\bixie\\formmaker\\app\\components\\submission-csv.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },

/***/ 36:
/***/ function(module, exports) {

	'use strict';

	module.exports = {

	    props: ['forms'],

	    data: function data() {
	        return {
	            options: {
	                form_id: 0,
	                filename: 'csv-export.csv',
	                mark_archived: true,
	                status: [1, 2],
	                field_ids: [],
	                datafields: ['id', 'status', 'email', 'ip', 'created']
	            },
	            formitem: {
	                id: 0,
	                fields: []
	            },
	            csvLink: '',
	            exporting: false,
	            count: 0,
	            loaded: false
	        };
	    },

	    created: function created() {
	        this.load();
	    },

	    beforeDestroy: function beforeDestroy() {
	        this.$dispatch('close.csvmodal');
	    },

	    computed: {
	        formLoaded: function formLoaded() {
	            return this.options.form_id && this.options.form_id == this.formitem.id;
	        }
	    },

	    methods: {
	        load: function load() {
	            this.$root.resource.query({ id: 'csv', options: this.options }).then(function (res) {
	                var data = res.data;
	                this.$set('options.field_ids', data.options.field_ids);
	                this.$set('options.filename', data.options.filename);
	                if (data.forms.length) {
	                    this.$set('count', 0);
	                    this.$set('forms', data.forms);
	                }
	                if (data.formitem.id) {
	                    this.$set('formitem', data.formitem);
	                    this.$set('formitem.fields', data.fields);
	                    this.$set('count', data.count);
	                    this.options.filename = 'export_' + this.formitem.slug + '.csv';
	                }
	                this.loaded = true;
	            }.bind(this));
	        },

	        doExport: function doExport() {

	            if (this.exporting || !this.options.form_id || this.formitem.id !== this.options.form_id) {
	                return false;
	            }
	            this.exporting = true;
	            this.$root.resource.export({ options: this.options }).then(function (res) {
	                if (res.data.csv) {
	                    var $url = window.URL || window.webkitURL;
	                    this.csvLink = $url.createObjectURL(new Blob([res.data.csv], { type: "application/force-download" }));
	                    this.exporting = false;
	                }
	            }.bind(this));
	        }
	    },

	    watch: {
	        'options': { handler: function handler(value) {
	                this.csvLink = '';
	            }, deep: true },

	        'options.form_id,options.status': function optionsForm_idOptionsStatus(value) {
	            this.load();
	        }
	    }

	};

/***/ },

/***/ 37:
/***/ function(module, exports) {

	module.exports = "\n\n<div>\n    <div class=\"uk-modal-header\">\n        <h2>{{ 'Export submissions as CSV file' | trans }}</h2>\n    </div>\n\n    <div class=\"uk-margin uk-form uk-form-stacked\">\n        <div class=\"uk-modal-spinner\" v-if=\"!loaded\"></div>\n        <div v-show=\"loaded\">\n\n            <div class=\"uk-grid\">\n                <div class=\"uk-width-medium-1-2\">\n                    <select class=\"uk-width-1-1\" v-model=\"options.form_id\" number>\n                        <option value=\"\">{{ 'Select form' | trans }}</option>\n                        <option v-for=\"form in forms\" :value=\"form.id\">{{ form.title }}</option>\n                    </select>\n\n                </div>\n                <div class=\"uk-width-medium-1-2\">\n                    <div class=\"uk-form-controls uk-form-controls-text uk-flex uk-margin-small-top\">\n                        <div class=\"uk-width-1-3\">\n                            <label><input type=\"checkbox\" :value=\"0\" v-model=\"options.status\" number>\n                                {{ 'Archived' | trans\n                                }}</label>\n                        </div>\n                        <div class=\"uk-width-1-3\">\n                            <label><input type=\"checkbox\" :value=\"1\" v-model=\"options.status\" number>\n                                {{ 'Active' | trans\n                                }}</label>\n                        </div>\n                        <div class=\"uk-width-1-3\">\n                            <label><input type=\"checkbox\" :value=\"2\" v-model=\"options.status\" number>\n                                {{ 'Done' | trans\n                                }}</label>\n                        </div>\n                    </div>\n                </div>\n            </div>\n\n            <div class=\"uk-grid\" v-if=\"formLoaded\">\n                <div class=\"uk-width-medium-2-3\">\n\n                    <div class=\"uk-grid\">\n                        <div class=\"uk-width-medium-1-2\">\n\n                            <div class=\"uk-form-row\">\n                                <span class=\"uk-form-label\">{{ 'Data to export' | trans }}</span>\n\n                                <div class=\"uk-form-controls uk-form-controls-text\">\n                                    <p class=\"uk-form-controls-condensed\">\n                                        <label><input type=\"checkbox\" value=\"id\" v-model=\"options.datafields\"> {{\n                                            'Id' | trans\n                                            }}</label>\n                                    </p>\n\n                                    <p class=\"uk-form-controls-condensed\">\n                                        <label><input type=\"checkbox\" value=\"status\" v-model=\"options.datafields\">\n                                            {{ 'Status' | trans\n                                            }}</label>\n                                    </p>\n\n                                    <p class=\"uk-form-controls-condensed\">\n                                        <label><input type=\"checkbox\" value=\"email\" v-model=\"options.datafields\"> {{\n                                            'Email' | trans\n                                            }}</label>\n                                    </p>\n\n                                    <p class=\"uk-form-controls-condensed\">\n                                        <label><input type=\"checkbox\" value=\"ip\" v-model=\"options.datafields\"> {{\n                                            'IP address' | trans\n                                            }}</label>\n                                    </p>\n\n                                    <p class=\"uk-form-controls-condensed\">\n                                        <label><input type=\"checkbox\" value=\"created\" v-model=\"options.datafields\">\n                                            {{ 'Created' | trans\n                                            }}</label>\n                                    </p>\n                                </div>\n                            </div>\n\n                        </div>\n                        <div class=\"uk-width-medium-1-2\">\n\n                            <div class=\"uk-form-row\">\n                                <span class=\"uk-form-label\">{{ 'Fields to export' | trans }}</span>\n\n                                <div class=\"uk-form-controls uk-form-controls-text\">\n                                    <p v-for=\"field in formitem.fields\" class=\"uk-form-controls-condensed\">\n                                        <label><input type=\"checkbox\" value=\"{{ field.id }}\"\n                                                      v-model=\"options.field_ids\" number> {{ field.label | trans\n                                            }}</label>\n                                    </p>\n                                </div>\n                            </div>\n\n                        </div>\n                    </div>\n\n                </div>\n                <div class=\"uk-width-medium-1-3\">\n                    <div class=\"uk-panel uk-panel-box\">\n\n                        <div class=\"uk-form-row\">\n                            <label for=\"form-filename\" class=\"uk-form-label\">{{ 'Filename' | trans }}</label>\n\n                            <div class=\"uk-form-controls\">\n                                <input id=\"form-filename\" class=\"uk-width-1-1\" type=\"text\"\n                                       v-model=\"options.filename\">\n                            </div>\n                        </div>\n\n\n                        <div class=\"uk-form-row\">\n                            <span class=\"uk-form-label\">{{ 'Archive' | trans }}</span>\n\n                            <div class=\"uk-form-controls uk-form-controls-text\">\n                                <label><input type=\"checkbox\" value=\"archived\" v-model=\"options.mark_archived\"> {{\n                                    'Mark exported as \"Archived\"' | trans\n                                    }}</label>\n                            </div>\n                        </div>\n\n                        <div class=\"uk-badge uk-badge-success uk-margin\">\n                            {{ count }} {{ '{0} submissions to be exported|{1} submission to be exported|]1,Inf[\n                            submissions to be exported' | transChoice count}}\n                        </div>\n\n                    </div>\n                </div>\n            </div>\n\n        </div>\n\n    </div>\n\n    <div class=\"uk-modal-footer uk-text-right\">\n        <button type=\"button\" class=\"uk-button uk-modal-close\">{{ 'Close' | trans }}</button>\n        <button type=\"button\" class=\"uk-button uk-button-primary\"\n                v-show=\"!csvLink\" @click=\"doExport\" v-el:export\n                :disabled=\"!formLoaded\">\n            <i v-show=\"exporting\" class=\"uk-icon-spinner uk-icon-spin\"></i>\n            <span v-else>{{ 'Export' | trans }}</span>\n        </button>\n        <a :href=\"csvLink\" class=\"uk-button uk-button-success\" download=\"{{ options.filename }}\"\n           v-show=\"csvLink\" v-el:exportlink><i class=\"uk-icon-download uk-margin-small-right\"></i>{{ 'Download' |\n            trans }}</a>\n    </div>\n</div>\n\n\n";

/***/ }

/******/ });