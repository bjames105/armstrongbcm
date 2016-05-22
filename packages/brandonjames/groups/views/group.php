<?php $view->script('groups', 'groups:app/bundle/group.js',
	[ 'vue', 'uikit', 'uikit-autocomplete', 'uikit-timepicker', 'uikit-tooltip', 'uikit-notify' ]);
?>
<?php $view->style('groups', 'groups:app/styles/groups.css', [ 'uikit-notify' ]); ?>
<div id="group" class="uk-grid">
	<div class="uk-position-top uk-padding-remove uk-height-1-1 uk-width-1-1">
		<div class="uk-cover-background uk-width-1-1 uk-height-1-1 uk-padding-remove">
			<div class="uk-height-1-1" style="background-color: rgba(255, 255, 255, 0.9)"></div>
		</div>
	</div>
	<div class="uk-width-1-6 uk-text-center uk-hidden-small uk-position-relative">
		<img class="uk-comment-avatar uk-width-1-1 uk-margin-bottom" :alt="group.user.name" v-gravatar="group.user.email">
		<div class="uk-width-1-1">Led by<br><strong>{{ group.user.name }}</strong></div>
	</div>
	<div class="uk-grid uk-width-large-5-6 uk-width-small-1-1 uk-position-relative"><?php if ($user_can_edit_group): ?>
		<h1 class="uk-width-1-1 uk-margin-large-bottom editable">
			<span class="group-name">{{ group.name }}</span>
			<form class="uk-form group-name uk-hidden">
				<input type="text" class="uk-width-1-1" v-model="group.name"/>
			</form>
			<a href="javascript:;" class="group-name edit-hint" data-uk-toggle="{target:'.group-name'}" data-uk-tooltip title="Edit Name"><i class="uk-icon-edit"></i></a>
			<a @click="update" href="javascript:;" class="group-name edit-hint uk-hidden" data-uk-toggle="{target:'.group-name'}" data-uk-tooltip title="Done"><i class="uk-icon-check"></i></a>
		</h1>
		<form class="uk-form uk-grid uk-width-1-1 uk-text-center uk-margin-bottom">
			<div class="uk-width-large-1-5 uk-width-small-1-4">
				<i class="uk-icon-calendar uk-icon-large uk-display-block uk-margin-small-bottom"></i>
				<div>Day</div>
				<div class="uk-text-bold uk-position-relative editable">{{ weekdays[group.active_day] }}<a href="#weekday" class="edit-hint uk-text-bold" data-uk-modal data-uk-tooltip title="Edit Day"><i class="uk-icon-edit"></i></a></div>
			</div>
			<div class="uk-width-large-1-5 uk-width-small-1-4">
				<i class="uk-icon-clock-o uk-icon-large uk-display-block uk-margin-small-bottom"></i>
				<div>Time</div>
				<div class="uk-text-bold uk-position-relative editable">
					<a @click="update" href="javascript:;" class="edit-hint uk-hidden group-time" data-uk-toggle="{target:'.group-time'}" data-uk-tooltip title="Done"><i class="uk-icon-check"></i></a></span>
					<a href="javascript:;" class="edit-hint group-time" data-uk-toggle="{target:'.group-time'}" data-uk-tooltip title="Edit Time"><i class="uk-icon-edit"></i></a></span>
					<time datetime="{{ group.active_time | time }}">
						<span class="group-time uk-text-bold">{{ group.active_time | time }}</span>
					    <input type="text" class="uk-text-center uk-hidden group-time" data-uk-timepicker v-model="group.active_time">
					</time>
				</div>
			</div>
			<div class="uk-width-large-1-5 uk-width-small-1-4">
				<i class="uk-icon-location-arrow uk-icon-large uk-display-block uk-margin-small-bottom"></i>
				<div>Place</div>
				<div class="uk-text-bold uk-position-relative editable uk-text-bold">
					<span class="group-location">{{ (group.location == null || group.location == "") ? "Undisclosed" : group.location }}</span>
					<input type="text" class="uk-width-1-1 uk-text-center uk-hidden group-location uk-text-small" v-model="group.location"/>
					<a @click="update" href="javascript:;" class="edit-hint uk-hidden group-location" data-uk-toggle="{target:'.group-location'}" data-uk-tooltip title="Done"><i class="uk-icon-check"></i></a>
					<a href="javascript:;" class="edit-hint group-location" data-uk-toggle="{target:'.group-location'}" data-uk-tooltip title="Edit Location"><i class="uk-icon-edit"></i></a>
				</div>
			</div>
			<div class="uk-width-large-1-5 uk-width-small-1-4">
				<i class="uk-icon-users uk-icon-large uk-display-block uk-margin-small-bottom"></i>
				<div>Members</div>
				<div class="uk-text-bold" v-if="!userCreatedGroup()"><a href="#group-members" data-uk-modal>{{ group.group_members.length + ' Members' }}</a></div>
				<div class="uk-text-bold" v-if="userCreatedGroup()">
					<div class="uk-text-bold"><a href="#group-members" data-uk-modal data-uk-tooltip title="Pick max member count and member gender">{{ group.group_members.length + ' Members' }}</a></div>
				</div>
			</div>
			<div class="uk-width-large-1-5 uk-width-small-1-1">
				<div>
					<select @change="update" v-model="group.group_category_id">
						<option v-for="category in groupCategories" value="{{ category.id }}">{{ category.name }}</option>
					</select>
					<button v-show="userCanLeaveGroup()" type="button" class="uk-button uk-button-danger" @click="leave()"><i class="uk-icon-user-times uk-margin-small-bottom"></i> Leave</button>
					<button v-show="userCanJoinGroup()" type="button" class="uk-button uk-button-primary" @click="join()"><i class="uk-icon-user-plus uk-margin-small-bottom"></i> Join</button>
				</div>
				<div>Created</div>
				<div class="uk-text-bold">{{ group.created | date }}</div>
			</div>
		</form>
		<form class="uk-form uk-width-1-1 uk-margin-bottom">
			<h2>Description</h2>
			<p class="editable uk-position-relative uk-form-row">
				<span class="group-description">{{ (group.description == null || group.description == "") ? "Add a description to this group" : group.description }}</span>
				<textarea placeholder="Group description" class="uk-hidden uk-width-1-1 group-description" v-model="group.description"></textarea>
				<a @click="update" href="javascript:;" class="edit-hint uk-hidden group-description" data-uk-toggle="{target:'.group-description'}" data-uk-tooltip title="Done"><i class="uk-icon-check"></i></a>
				<a href="javascript:;" class="edit-hint group-description" data-uk-toggle="{target:'.group-description'}" data-uk-tooltip title="Edit Description"><i class="uk-icon-edit"></i></a>
			</p>
			<p><a href="#delete-confirmation" class="uk-link uk-text-danger" data-uk-modal>Delete Group</a></p>
		</form>
		<?php else: ?><h1 class="uk-width-1-1 uk-margin-large-bottom">{{ group.name }}</h1>
			<div class="uk-grid uk-width-1-1 uk-text-center uk-margin-bottom">
				<div class="uk-width-large-1-5 uk-width-small-1-4">
					<i class="uk-icon-calendar uk-icon-large uk-display-block uk-margin-small-bottom"></i>
					<div>Day</div>
					<div class="uk-text-bold"><div class="uk-text-bold">{{ weekdays[group.active_day] }}</div></div>
				</div>
				<div class="uk-width-large-1-5 uk-width-small-1-4">
					<i class="uk-icon-clock-o uk-icon-large uk-display-block uk-margin-small-bottom"></i>
					<div>Time</div>
					<div class="uk-text-bold"><time datetime="{{ group.active_time | time }}">{{ group.active_time | time }}</time></div>
				</div>
				<div class="uk-width-large-1-5 uk-width-small-1-4">
					<i class="uk-icon-location-arrow uk-icon-large uk-display-block uk-margin-small-bottom"></i>
					<div>Place</div>
					<div class="uk-text-bold">{{ (group.location == null) ? "Undisclosed" : group.location }}</div>
				</div>
				<div class="uk-width-large-1-5 uk-width-small-1-4">
					<i class="uk-icon-users uk-icon-large uk-display-block uk-margin-small-bottom"></i>
					<div>Members</div>
					<div class="uk-text-bold"><a href="#group-members" data-uk-modal>{{ '{0} Members|{1} One Member|]1,Inf[ %count% Members' | transChoice group.group_members.length {count:group.group_members.length} }}</a></div>
				</div>
				<div class="uk-width-large-1-5 uk-width-small-1-1">
					<button v-show="userCanLeaveGroup()" type="button" class="uk-button uk-button-danger" @click="leave()"><i class="uk-icon-user-times uk-margin-small-bottom"></i> Leave</button>
					<button v-show="userCanJoinGroup()" type="button" class="uk-button uk-button-primary" @click="join()"><i class="uk-icon-user-plus uk-margin-small-bottom"></i> Join</button>
					<div>Created</div>
					<div class="uk-text-bold">{{ group.created | date }}</div>
				</div>
			</div>
			<div class="uk-width-1-1 uk-margin-bottom">
				<h2>Description</h2>
				<p>{{ (group.description == null) ? "This group has no description." : group.description }}</p>
			</div><?php endif; ?>
			<div id="discussions" class="uk-width-1-1">
				<h2>Discussion</h2>
				<?php if ($user_can_post_discussions): ?><form class="uk-form">
					<textarea v-model="newDiscussionPost.content" class="uk-width-1-1 uk-margin-small-bottom" placeholder="What do you want to talk about?" style="resize: vertical; min-height: 100px"></textarea>
					<button @click="postDiscussion" type="button" class="uk-button uk-button-primary"><i class="uk-icon-plus"></i> Make Discussion Post</button>
				</form><?php endif; ?>
				<ul class="uk-list uk-list-line">
					<li v-for="post in group.group_discussion" class="uk-grid">
						<div class="uk-width-1-10"><img class="uk-comment-avatar group-member" :alt="post.user.name" v-gravatar="post.user.email"></div>
						<div class="uk-width-9-10 uk-position-relative">
							<strong>{{ post.user.name }}</strong>
							<p>{{ post.content }}</p>
							<a href="#delete-post-confirmation"
								v-if="post.user.id == currentUser.id"
								@click="setPostToDelete(post)"
								title="Delete Post"
								data-uk-tooltip
								data-uk-modal
								class="uk-position-top-right"><strong><i class="uk-icon-close"></i></a>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div id="group-members" class="uk-modal">
		    <div class="uk-modal-dialog">
				<a class="uk-modal-close uk-close"></a>
				<div v-if="userCreatedGroup()">
					<div class="uk-modal-header">Choose Member Gender and Maximum Size</div>
					<form class="uk-form uk-form-horizontal" data-uk-margin>
						<div class="uk-form-row">
					        <label class="uk-form-label" for="max-members">Maximum Group size</label>
					        <div class="uk-form-controls"><input type="number" id="max-members" v-model="group.max_members"/></div>
							<label class="uk-form-label">Group Gender</label>
							<div class="uk-form-controls">
								<div data-uk-button-radio>
								    <button type="button"
										@click="setGroupGender('c')"
										class="uk-button"
										:class="{ 'uk-active' : (group.gender == 'c') }">Co-ed</button>
								    <button type="button"
										class="uk-button"
										:class="{ 'uk-active' : (group.gender == 'm') }"
										@click="setGroupGender('m')">Guys</button>
								    <button type="button"
										class="uk-button"
										:class="{ 'uk-active' : (group.gender == 'f') }"
										@click="setGroupGender('f')">Girls</button>
								</div>
							</div>
					    </div>
						<div class="uk-form-row uk-align-right">
							<button @click="update" class="uk-button uk-button-primary uk-margin-small-bottom">Save</button>
						</div>
					</form>
					<div class="uk-modal-header">{{ '{0} Members|{1} One Member|]1,Inf[ %count% Members' | transChoice group.group_members.length {count:group.group_members.length} }}</div>
					<ul class="uk-list uk-list-line">
						<li v-for="member in group.group_members"><img class="uk-comment-avatar group-member" :alt="member.name" v-gravatar="member.email">{{ member.name }}</li>
					</ul>
			</div>
		</div>
	</div>
	<?php if ($user_can_edit_group): ?><div id="weekday" class="uk-modal">
	    <div class="uk-modal-dialog">
			<a @click="update" class="uk-modal-close uk-close"></a>
			<div class="uk-modal-header"><h2>Pick a Weekday for your group</h2></div>
			<div class="uk-width-1-1 uk-margin-top">
				<div data-uk-button-radio class="uk-grid-width-1-3">
				    <button @click="setWeekday(weekday)"
						class="uk-button uk-button-primary uk-margin-small-bottom"
						:class="{ 'uk-active' : (weekdays[group.active_day] == weekday) }"
						v-for="weekday in weekdays"
						aria-selected="{{ (weekdays[group.active_day] == weekday) ? 'true' : 'false' }}">{{ weekday }}</button>
				</div>
			</div>
	    </div>
	</div>
	<div id="delete-confirmation" class="uk-modal">
		<div class="uk-modal-dialog">
			<a class="uk-modal-close uk-close"></a>
			<div class="uk-modal-header"><h2>Are you sure you want to delete {{ group.name }}?</h2></div>
			<div class="uk-width-1-1 uk-margin-top">
				<p>This action <em>cannot</em> be reversed</p>
				<button class="uk-modal-close uk-button">Cancel</button>
				<button @click="remove()" class="uk-button uk-button-danger">Yes, delete {{ group.name }}</button>
			</div>
		</div>
	</div><?php endif; ?>
	<div id="delete-post-confirmation" class="uk-modal">
		<div class="uk-modal-dialog">
			<a class="uk-modal-close uk-close"></a>
			<div class="uk-modal-header"><h2>Are you sure you want to delete your post?</h2></div>
			<div class="uk-width-1-1 uk-margin-top">
				<p>This action <em>cannot</em> be reversed</p>
				<button class="uk-modal-close uk-button">Cancel</button>
				<button @click="deleteDiscussionPost(postToDelete)" class="uk-button uk-button-danger uk-modal-close">Yes, delete my post</button>
			</div>
		</div>
	</div>
</div>
