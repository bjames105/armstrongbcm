<?php $view->script('groups', 'groups:app/bundle/admin-categories.js', 'vue'); ?>

<div id="categories">
    <h2>{{ '{0} Categories|{1} One Category|]1,Inf[ %count% Categories' | transChoice categories.length {count:categories.length} }}</h2>
    <div class="uk-grid uk-form">
        <div class="uk-form-icon uk-width-1-3">
            <i class="uk-icon-search"></i>
            <input type="text" v-model="searchText" placeholder="Search" class="uk-form-width-large">
        </div>
        <div class="uk-width-1-3"></div>
        <div class="uk-text-right uk-width-1-3">
            <a href="<?= $view->url('@groups/categoriescreate'); ?>" target="_blank" class="uk-button uk-button-primary"><i class="uk-icon-plus"></i> New Category</a>
        </div>
    </div>
    <ul class="uk-list-line">
        <li class="uk-grid" v-for="category in categories | filterBy searchText in 'name'">
            {{ category.name }}
        </li>
    </ul>
</div>
