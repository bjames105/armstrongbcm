<template>
	<div class="uk-form-row"> 
		<label class="uk-form-label">Select a Group</label>
		<select class="uk-width-1-1" v-model="link">
			<option v-for="item in groups" :value="item.id | filter_link">{{ item.name }}</option>
		</select>
	</div>
</template>

<script>
	module.exports = {
		link: {label: 'Groups'},

		props: ['link'],

		data: function() {
			return {groups: []};
		},

		created: function() {
			this.resource = this.$resource('api/groups');
			this.resource.get().then(function (data) {
				this.$set('groups', data.data.groups);
			}, function (error) {
				UIkit.notify(error.data, 'danger');
			});

		},

		ready: function() {
			this.link = '@groups';
		},

		filters: {
			filter_link: function(val) { return this.link + '/group/' + val; }
		}
	}
	window.Links.components['link-groups'] = module.exports;
</script>