<?php $view->script('groups', 'groups:app/bundle/groups.js', 'vue'); ?>

<div id="groups" class="uk-form">

    <button class="uk-button uk-button-primary uk-align-right" @click="save">{{ 'Save' | trans }}</button>

    <h2>{{ '{0} Groups|{1} One Group|]1,Inf[ %count% Groups' | transChoice groups.length {count:groups.length} }}</h2>

    <form class="uk-width-large-2-3" @submit="add">
        <input class="uk-input-large uk-width-3-4" placeholder="{{ 'New Group' | trans }}" v-model="newGroup.name">
        <button class="uk-button" @click="add">{{ 'Add' | trans }}</button>
    </form>

    <hr>

    <div class="uk-alert" v-if="!groups.length">{{ 'You can add your first group using the input field above. Go ahead!' | trans }}</div>

    <ul class="uk-list uk-list-line" v-if="groups.length">
        <li class="uk-text-large" v-for="group in groups">

            <span class="uk-align-right">
                <button @click="remove(group)" class="uk-button uk-button-danger"><i class="uk-icon-remove"></i></button>
            </span>

            {{ group.name }}
        </li>
    </ul>

</div>