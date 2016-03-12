!function(e){function t(a){if(o[a])return o[a].exports;var s=o[a]={exports:{},id:a,loaded:!1};return e[a].call(s.exports,s,s.exports,t),s.loaded=!0,s.exports}var o={};return t.m=e,t.c=o,t.p="",t(0)}([function(e,t,o){var a,s;a=o(1),s=o(2),e.exports=a||{},e.exports.__esModule&&(e.exports=e.exports["default"]),s&&(("function"==typeof e.exports?e.exports.options:e.exports).template=s)},function(e,t){"use strict";e.exports={section:{label:"Cache",icon:"pk-icon-large-bolt",priority:30},props:["config","options"],data:function(){return{caches:window.$caches}},methods:{open:function(){this.$set("cache",{cache:!0}),this.$refs.modal.open()},clear:function(){this.$http.post("admin/system/cache/clear",{caches:this.cache}).then(function(){this.$notify("Cache cleared.")}),this.$refs.modal.close()}}},window.Settings.components["system/cache"]=e.exports},function(e,t){e.exports="<div class=\"uk-margin uk-flex uk-flex-space-between uk-flex-wrap\" data-uk-margin><div data-uk-margin><h2 class=uk-margin-remove>{{ 'Cache' | trans }}</h2></div><div data-uk-margin><button class=\"uk-button uk-button-primary\" type=submit>{{ 'Save' | trans }}</button></div></div><div class=uk-form-row><span class=uk-form-label>{{ 'Cache' | trans }}</span><div class=\"uk-form-controls uk-form-controls-text\"><p class=uk-form-controls-condensed v-for=\"cache in caches\"><label><input type=radio :value=$key v-model=config.caches.cache.storage :disabled=!cache.supported> {{ cache.name }}</label></p></div></div><div class=uk-form-row><span class=uk-form-label>{{ 'Developer' | trans }}</span><div class=\"uk-form-controls uk-form-controls-text\"><p class=uk-form-controls-condensed><label><input type=checkbox value=1 v-model=config.nocache> {{ 'Disable cache' | trans }}</label></p><p><button class=\"uk-button uk-button-primary\" type=button @click.prevent=open>{{ 'Clear Cache' | trans }}</button></p></div></div><v-modal v-ref:modal><form class=uk-form-stacked><div class=uk-modal-header><h2>{{ 'Select Cache to Clear' | trans }}</h2></div><div class=uk-form-row><p class=uk-form-controls-condensed><label><input type=checkbox v-model=cache.cache> {{ 'System Cache' | trans }}</label></p><p class=uk-form-controls-condensed><label><input type=checkbox v-model=cache.temp> {{ 'Temporary Files' | trans }}</label></p></div><div class=\"uk-modal-footer uk-text-right\"><button class=\"uk-button uk-button-link uk-modal-close\" type=button>{{ 'Cancel' | trans }}</button> <button class=\"uk-button uk-button-link\" @click.prevent=clear>{{ 'Clear' | trans }}</button></div></form></v-modal>"}]);