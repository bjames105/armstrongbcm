<?php $view->script('groups', 'groups:app/bundle/admin-groups.js', 'vue'); ?>
<div id="groups">
    <h2>{{ '{0} Groups|{1} One Group|]1,Inf[ %count% Groups' | transChoice groups.length {count:groups.length} }}</h2>
    <div class="uk-grid uk-form">
        <div class="uk-form-icon uk-width-1-3">
            <i class="uk-icon-search"></i>
            <input type="text" v-model="searchText" placeholder="Search" class="uk-form-width-large">
        </div>
        <div class="uk-width-1-3"></div>
        <div class="uk-text-right uk-width-1-3">
            <a href="<?= $view->url('@groups/create'); ?>" target="_blank" class="uk-button uk-button-primary"><i class="uk-icon-plus"></i> New Group</a>
        </div>
    </div>
    <table class="uk-table">
        <thead>
            <tr>
                <th class="uk-width-1-4">
                    Group Name
                </th>
                <th class="uk-width-1-4">
                    Members
                </th>
                <th class="uk-width-1-4">
                    Created by
                </th>
                <th class="uk-text-right uk-width-1-4">
                    More
                </th>
            </tr>
        </thead>
    </table>
    <div class="uk-grid" v-for="group in groups | filterBy searchText in 'name'">
        <div class="uk-width-1-4">
            <a href="<?= $view->url('@groups'); ?>/{{group.id}}" target="_blank">{{ group.name }}</a>
        </div>
        <div class="uk-width-1-4">
            {{ group.group_members.length + ' Members' }}
        </div>
        <div class="uk-width-1-4">
            {{ group.user.name }}
        </div>
        <div class="uk-width-1-4 uk-text-right">
            <button type="button" class="uk-button" data-uk-toggle="{target: '{{ '#' + group.id + '-more'}}', animation:'uk-animation-fade, uk-animation-fade'}"><i class="uk-icon-caret-down"></i> More</button>
        </div>
        <div class="uk-width-1-1 uk-margin-top uk-hidden" id="{{ group.id + '-more' }}">
            <div class="uk-grid uk-panel-box">
                <div class="uk-width-1-3">
                    <dl class="uk-description-list-horizontal">
                        <dt>Category name</dt>
                        <dd>{{ group.group_category.name }}</dd>
                        <dt>Created on</dt>
                        <dd>{{ group.created | date }}</dd>
                        <dt>Gender</dt>
                        <dd>{{ genders[group.gender] }}</dd>
                        <dt>Day of Week</dt>
                        <dd>{{ weekdays[group.active_day] }}</dd>
                        <dt>Members</dt>
                        <dd v-for="member in group.group_members">
                            {{ member.name }}
                        </dd>
                    </dl>
                </div>
                <div class="uk-width-1-3">
                </div>
                <div class="uk-width-1-3 uk-text-right">
                    <ul class="uk-list uk-list-space">
                        <li><a href="<?= $view->url('@groups'); ?>/{{group.id}}" class="uk-button uk-button-primary uk-text-left" target="_blank"><i class="uk-icon-edit"></i> Edit</a></li>
                        <li><a @click="setGroupToDelete(group)" class="uk-button uk-button-danger uk-text-left" data-uk-modal="{target:'#delete-group-confirmation'}"><i class="uk-icon-trash"></i> Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="delete-group-confirmation" class="uk-modal">
        <div class="uk-modal-dialog">
            <a @click="setGroupToDelete({ name: '' })" class="uk-modal-close uk-close"></a>
            <h2>Are you sure you want to delete {{ groupToDelete.name }}?</h2>
            <a class="uk-button uk-button-danger uk-modal-close" @click="remove(groupToDelete)"><i class="uk-icon-trash"></i> Yes, delete {{ groupToDelete.name }}</a>
        </div>
    </div>
</div>
