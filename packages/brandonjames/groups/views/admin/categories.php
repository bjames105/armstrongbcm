<?php $view->script('groups', 'groups:app/bundle/admin-categories.js', 'vue'); ?>

<div id="categories">
    <h2>{{ '{0} Categories|{1} One Category|]1,Inf[ %count% Categories' | transChoice categories.length {count:categories.length} }}</h2>
    <div class="uk-grid uk-form">
        <div class="uk-form-icon uk-width-1-3">
            <i class="uk-icon-search"></i>
            <input type="text" v-model="searchText" placeholder="Search" class="uk-form-width-large">
        </div>
        <div class="uk-width-2-3"></div>
    </div>
    <table class="uk-table">
        <thead>
            <tr>
                <th class="uk-width-1-5">
                    Category Name
                </th>
                <th class="uk-width-3-5">
                    Category Description
                </th>
                <th class="uk-text-right uk-width-1-5">
                    More
                </th>
            </tr>
        </thead>
    </table>
    <ul class="uk-list-line" uk-margin-remove>
        <li class="uk-grid" v-for="category in categories | filterBy searchText in 'name'">
            <div class="uk-width-1-5">
                <span class="{{ 'group-category-' + category.id}}">{{ category.name }}</span>
    			<form class="{{ 'group-category-' + category.id}} uk-form group-name uk-hidden">
    				<input type="text" class="uk-width-1-1" v-model="category.name"/>
    			</form>
            </div>
            <div class="uk-width-3-5">
                <span class="{{ 'group-category-' + category.id}}">{{ category.description }}</span>
    			<form class="{{ 'group-category-' + category.id}} uk-form group-name uk-hidden">
    				<input type="text" class="uk-width-1-1" v-model="category.description"/>
    			</form>
            </div>
            <div class="uk-width-1-5 uk-padding-remove uk-text-right">
                <a href="javascript:;" data-uk-toggle="{target:'.group-category-' + {{category.id}}}" class="{{ 'group-category-' + category.id + ' uk-button-primary uk-button uk-text-left'}}">
                    <span class="{{ 'group-category-' + category.id}}"><i class="uk-icon-edit"></i> Edit</span>
                </a>
                <a href="javascript:;" @click="update(category)" data-uk-toggle="{target:'.group-category-' + {{category.id}}}" class="{{ 'group-category-' + category.id + ' uk-hidden uk-button-primary uk-button uk-text-left'}}">
                    <span class="{{ 'group-category-' + category.id + ' uk-hidden'}}"><i class="uk-icon-check"></i> Done</span>
                </a>
                <a data-uk-modal href="#delete-category" @click="setCategoryToDelete(category)" class="uk-button-danger uk-button uk-text-left">
                    <i class="uk-icon-trash"></i> Delete
                </a>
            </div>
        </li>
        <li class="uk-grid">
            <div class="uk-width-1-5">
                <form class="uk-form">
                    <input type="text" v-model="newCategory.name" class="uk-width-1-1" placeholder="Name"/>
                </form>
            </div>
            <div class="uk-width-3-5">
                <form class="uk-form">
                    <input type="text" v-model="newCategory.description" class="uk-width-1-1" placeholder="Description"/>
                </form>
            </div>
            <div class="uk-width-1-5 uk-padding-remove uk-text-right">
                <form class="uk-form">
                    <button @click="add()" type="button" class="uk-button uk-button-primary uk-modal-close"><i class="uk-icon-plus"></i> Create Category</button>
                </form>
            </div>
        </li>
    </ul>
    <div id="delete-category" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
            <div class="uk-modal-header"><h2>Delete {{ categoryToDelete.name }}?</h2></div>
            <p class="uk-text-danger">This action cannot be reversed</p>
            <button type="button" class="uk-button uk-modal-close">Cancel</button>
            <button @click="remove(categoryToDelete)" type="button" class="uk-button uk-button-danger uk-modal-close"><i class="uk-icon-trash"></i> Delete Category</button>
        </div>
    </div>
</div>
