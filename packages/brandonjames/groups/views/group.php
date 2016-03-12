<?php $view->script('groups', 'groups:app/bundle/group.js', 'vue'); ?>
<div id="group">
	<div class="uk-cover-background" style="background-image: url('/storage/placeholder_600x400.svg'); height: 300px;"></div>
	<div class="uk-grid">
		<div class="uk-hidden-small uk-hidden-medium uk-width-large-1-4 uk-margin-small-top">
			<div class="uk-panel uk-panel-box">
				<div class="uk-panel-teaser">
					<img src="/storage/placeholder_600x400.svg" alt="">
				</div>
				<div class="uk-text-center"><strong>Group Leader</strong></div>
				<div class="uk-text-center">Group Leader name</div>
			</div>
		</div>
		<div class="uk-width-small-1-1 uk-width-large-3-4 uk-margin-small-top">
			<div class="uk-grid">
				<div class="uk-width-1-1">
					<h1>{{ group.name }}</h1>
				</div>
				<div class="uk-width-large-1-5 uk-width-1-4 uk-margin-small-top" style="text-align: center;">
					Day
				</div>
				<div class="uk-width-large-1-5 uk-width-1-4 uk-margin-small-top" style="text-align: center;">
					Time
				</div>
				<div class="uk-width-large-1-5 uk-width-1-4 uk-margin-small-top" style="text-align: center;">
					Place
				</div>
				<div class="uk-width-large-1-5 uk-width-1-4 uk-margin-small-top" style="text-align: center;">
					Members
				</div>
				<div class="uk-width-large-1-5 uk-width-1-1 uk-margin-small-top" style="text-align: center;">
					Created On<br>
					{{ group.created }}
				</div>
			</div>
		</div>
	</div>
</div>
