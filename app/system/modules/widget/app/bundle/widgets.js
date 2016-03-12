!function(t){function o(i){if(s[i])return s[i].exports;var e=s[i]={exports:{},id:i,loaded:!1};return t[i].call(e.exports,e,e.exports,o),e.loaded=!0,e.exports}var s={};return o.m=t,o.c=s,o.p="",o(0)}([function(t,o,s){window.Widgets=t.exports={data:function(){return{widgets:[]}},created:function(){this.resource=this.$resource("api/site/widget{/id}")},partials:{settings:s(3)},components:{settings:s(6),visibility:s(7)}}},function(t,o){"use strict";t.exports={section:{label:"Settings"},props:["widget","form","config"],created:function(){this.$options.partials=this.$parent.$options.partials}}},function(t,o){"use strict";t.exports={section:{label:"Visibility",priority:100},data:function(){return{menus:!1}},props:["widget","config","form"]}},function(t,o){t.exports="<div class=\"uk-panel uk-form-stacked\"> <div class=uk-form-row> <label for=form-status class=uk-form-label>{{ 'Status' | trans }}</label> <div class=uk-form-controls> <select id=form-status class=uk-width-1-1 v-model=widget.status> <option value=0>{{ 'Disabled' | trans }}</option> <option value=1>{{ 'Enabled' | trans }}</option> </select> </div> </div> <div class=uk-form-row> <label for=form-position class=uk-form-label>{{ 'Position' | trans }}</label> <div class=uk-form-controls> <select id=form-position name=position class=uk-width-1-1 v-model=widget.position> <option value=\"\">{{ '- Assign -' | trans }}</option> <option v-for=\"position in config.positions\" :value=position.name>{{ position.label }}</option> </select> </div> </div> <div class=uk-form-row> <span class=uk-form-label>{{ 'Restrict Access' | trans }}</span> <div class=\"uk-form-controls uk-form-controls-text\"> <p v-for=\"role in config.roles\" class=uk-form-controls-condensed> <label><input type=checkbox :value=role.id v-model=widget.roles number> {{ role.name }}</label> </p> </div> </div> </div>"},function(t,o){t.exports='<div class="uk-grid pk-grid-large" data-uk-grid-margin> <div class="uk-flex-item-1 uk-form-horizontal"> <div class=uk-form-row> <label for=form-title class=uk-form-label>{{ \'Title\' | trans }}</label> <div class=uk-form-controls> <input id=form-title class=uk-form-width-large type=text name=title v-model=widget.title v-validate:required> <p class="uk-form-help-block uk-text-danger" v-show=form.title.invalid>{{ \'Title cannot be blank.\' | trans }}</p> </div> </div> </div> <div class="pk-width-sidebar pk-width-sidebar-large"> <partial name=settings></partial> </div> </div>'},function(t,o){t.exports='<div class=uk-form-horizontal> <div class=uk-form-row> <span class=uk-form-label>Pages</span> <div class="uk-form-controls uk-form-controls-text" v-if=config.menus> <input-tree :active.sync=widget.nodes></input-tree> </div> </div> </div>'},function(t,o,s){var i,e;i=s(1),e=s(4),t.exports=i||{},t.exports.__esModule&&(t.exports=t.exports["default"]),e&&(("function"==typeof t.exports?t.exports.options:t.exports).template=e)},function(t,o,s){var i,e;i=s(2),e=s(5),t.exports=i||{},t.exports.__esModule&&(t.exports=t.exports["default"]),e&&(("function"==typeof t.exports?t.exports.options:t.exports).template=e)}]);