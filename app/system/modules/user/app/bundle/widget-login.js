!function(t){function i(r){if(e[r])return e[r].exports;var l=e[r]={exports:{},id:r,loaded:!1};return t[r].call(l.exports,l,l.exports,i),l.loaded=!0,l.exports}var e={};return i.m=t,i.c=e,i.p="",i(0)}({0:function(t,i,e){var r,l;r=e(5),l=e(10),t.exports=r||{},t.exports.__esModule&&(t.exports=t.exports["default"]),l&&(("function"==typeof t.exports?t.exports.options:t.exports).template=l)},5:function(t,i){"use strict";t.exports={section:{label:"Settings"},replace:!1,props:["widget","config","form"],created:function(){this.$options.partials=this.$parent.$options.partials}},window.Widgets.components["system-login:settings"]=t.exports},10:function(t,i){t.exports="<div class=\"uk-grid pk-grid-large\" data-uk-grid-margin> <div class=\"uk-flex-item-1 uk-form-horizontal\"> <div class=uk-form-row> <label for=form-title class=uk-form-label>{{ 'Title' | trans }}</label> <div class=uk-form-controls> <input id=form-title class=uk-form-width-large type=text name=title v-model=widget.title v-validate:required> <p class=\"uk-form-help-block uk-text-danger\" v-show=form.title.invalid>{{ 'Title cannot be blank.' | trans }}</p> </div> </div> <div class=uk-form-row> <label class=uk-form-label>{{ 'Login Redirect' | trans }}</label> <div class=uk-form-controls> <input-link class=uk-form-width-large :link.sync=widget.data.redirect_login></input-link> </div> </div> <div class=uk-form-row> <label class=uk-form-label>{{ 'Logout Redirect' | trans }}</label> <div class=uk-form-controls> <input-link class=uk-form-width-large :link.sync=widget.data.redirect_logout></input-link> </div> </div> </div> <div class=\"pk-width-sidebar pk-width-sidebar-large\"> <partial name=settings></partial> </div> </div>"}});