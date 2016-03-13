<?php $view->script('settings', 'groups:app/bundle/settings.js', 'vue') ?>

<div id="settings" class="uk-form uk-form-horizontal" v-cloak>

    <div class="uk-grid pk-grid-large" data-uk-grid-margin>
        <div class="pk-width-sidebar">

            <div class="uk-panel">

                <ul class="uk-nav uk-nav-side pk-nav-large" data-uk-tab="{ connect: '#tab-content' }">
                    <li><a><i class="pk-icon-large-settings uk-margin-right"></i> General</a></li>
                    <li><a><i class="pk-icon-large-comment uk-icon-small uk-margin-right"></i>Discussions</a></li>
                </ul>

            </div>

        </div>
        <div class="uk-flex-item-1">

            <ul id="tab-content" class="uk-switcher uk-margin">
                <li>
                    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
                        <div data-uk-margin>

                            <h2 class="uk-margin-remove">{{ 'General' | trans }}</h2>

                        </div>
                        <div data-uk-margin>

                            <button class="uk-button uk-button-primary" @click.prevent="save">{{ 'Save' | trans }}</button>

                        </div>
                    </div>

                    <div class="uk-form-row">
                        <span class="uk-form-label">Setting 1</span>
                        <div class="uk-form-controls uk-form-controls-text">
                            <p class="uk-form-controls-condensed">
                                <label>
                                    <input type="radio" value="">
                                    Value <code>'/123'</code>
                                </label>
                            </p>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <label class="uk-form-label">Greeting Message</label>
                        <div class="uk-form-controls uk-form-controls-text">
                            <p class="uk-form-controls-condensed">
                                <textarea class="uk-form-width-large" name="displayMessage" v-model="config.displayMessage"></textarea>
                            </p>
                        </div>
                    </div>

                </li>
                <li>

                    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
                        <div data-uk-margin>

                            <h2 class="uk-margin-remove">Discussions</h2>

                        </div>
                        <div data-uk-margin>

                            <button class="uk-button uk-button-primary" @click.prevent="save">{{ 'Save' | trans }}</button>

                        </div>
                    </div>

                    <div class="uk-form-row">
                        <span class="uk-form-label">More Settings</span>
                        <div class="uk-form-controls uk-form-controls-text">
                            <p class="uk-form-controls-condensed">
                                <label><input type="checkbox">Require something or not</label>
                            </p>
                            <p class="uk-form-controls-condensed">
                                <input class="uk-form-small uk-form-width-mini" type="number" min="1"> amount
                            </p>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <span class="uk-form-label">Appearance</span>
                        <div class="uk-form-controls uk-form-controls-text">
                            <p class="uk-form-controls-condensed">
                                <label>Value
                                    <select class="uk-form-small">
                                        <option value="ASC">Option 1</option>
                                        <option value="DESC">Option 2</option>
                                    </select>
                                </label>
                            </p>
                            <p class="uk-form-controls-condensed">
                                <input type="checkbox"> More text stuff
                                <input class="uk-form-small uk-form-width-mini" type="number" min="2" max="10"> number
                            </p>
                        </div>
                    </div>

                </li>
            </ul>

        </div>
    </div>

</div>
