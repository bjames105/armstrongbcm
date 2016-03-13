<?php $view->script('groups', 'groups:app/bundle/groups.js', 'vue'); ?>
<div id="groups">
	<h1>Groups</h1>
	<p>{{ displayMessage }}</p>
	<div class="uk-grid uk-grid-width-medium-1-2 uk-grid-width-large-1-3 uk-grid-match">
		<a href="{{ '<?= $view->url('@groups'); ?>/' + group.id }}" v-for="group in groups" class="uk-margin-bottom group">
			<div class="uk-panel uk-panel-box">
				<div class="uk-panel-teaser">
					<div class="uk-overlay-panel">{{ group.name }}</div>
					<img src="/storage/placeholder_600x400.svg">
				</div>
				<div class="uk-grid uk-grid-small">
					<div class="uk-width-1-5">
						<img src="/storage/placeholder_600x400.svg">
					</div>
					<div class="uk-width-4-5">Led by <strong>Group Leader</strong></div>
				</div>
				<div><span class="badge">{{ group.active_day }}</span></div>
			</div>
		</a>
	</div>
</div>
