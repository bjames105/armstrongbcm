<?php $view->script('groups', 'groups:app/bundle/groups.js', 'vue'); ?>
<div id="groups">
	<h1>Groups</h1>
	<p>{{ displayMessage }}</p>
	<div class="uk-grid uk-form">
        <div class="uk-form-icon uk-width-1-3">
            <i class="uk-icon-search"></i>
            <input type="text" v-model="searchText" placeholder="Search" class="uk-form-width-large">
        </div>
		<div class="uk-width-1-3"><span v-if="groups.length > 0">{{ '{0} Groups|{1} One Group|]1,Inf[ %count% Groups' | transChoice groups.length {count:groups.length} }}</span></div>
		<?php if ($user_can_create_group): ?><div class="uk-text-right uk-width-1-3">
            <a href="<?= $view->url('@groups/create'); ?>" class="uk-button uk-button-primary"><i class="uk-icon-plus"></i> Create Group</a>
        </div><?php endif; ?>
		<!-- Trying to get a filter for weekdays -->
		<!-- <div class="uk-width-1-1 uk-margin-top">
			<div class="uk-grid">
				<div class="uk-width-1-5">
					<strong class="uk-text-middle">Filter by day</strong>
				</div>
				<div data-uk-button-checkbox class="uk-width-4-5">
					<div class="uk-button-group">
						<button class="uk-button" v-for="weekday in weekdays">{{ weekday }}</button>
					</div>
				</div>
			</div>
		</div> -->
    </div>
	<div v-if="groups.length == 0" class="uk-margin-top">
		<h2>There are no groups</h2>
	</div>
	<div class="uk-margin-top uk-grid" v-if="usersGroups.length > 0">
		<div class="uk-width-1-1">
			<h3>Your Groups</h3>
		</div>
		<div class="uk-width-1-3" v-for="group in usersGroups">
			<a href="{{ '<?= $view->url('@groups'); ?>/' + group.id }}"><div class="uk-panel uk-panel-box uk-margin-top">
				<h4>{{ group.name }}</h4>
			</div></a>
		</div>
	</div>
    <div class="uk-margin-top" v-for="category in categories | filterBy searchText in 'name'" v-if="groupsMapByCategory[category.id].length > 0">
        <h3>{{ category.name }}</h3>
        <p>{{ category.description }}</p>
		<div class="uk-width-1-1 uk-grid uk-grid-medium uk-grid-match">
			<div class="uk-width-large-1-3 uk-width-medium-1-2 uk-width-small-1-1 uk-margin-bottom"
				v-for="group in groupsMapByCategory[category.id] | filterBy searchText in fields | orderBy 'name'">
				<div class="uk-panel uk-panel-box">
					<div class="uk-panel-teaser">
						<a href="{{ '<?= $view->url('@groups'); ?>/' + group.id }}"><div class="uk-overlay-panel"><h3>{{ group.name }}</h3></div></a>
				        <img src="/storage/placeholder_600x400.svg">
				    </div>
					<ul class="uk-list uk-list-space">
						<li>Led by <strong>{{ group.user.name }}</strong></li>
						<li><i class="uk-icon-users"></i> {{ '{0} Members|{1} One Member|]1,Inf[ %count% Members' | transChoice group.group_members.length {count:group.group_members.length} }}</li>
						<li>Meets on {{ weekdays[group.active_day] }}s at {{ group.active_time | time }}</li>
					</ul>
				</div>
			</div>
		</div>
    </div>
</div>
