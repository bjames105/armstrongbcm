<?php $view->script('events', 'events:app/bundle/events.js', 'vue'); ?>
<div id="events">
	<h1>Events</h1>
    <h2>{{ month }}</h2>
	<table class="uk-table">
        <thead>
            <th v-for="(dayShort, day) in weekdays">{{ dayShort }}</th>
        </thead>
        <tbody>
            <tr v-for="week in calendar.weeks">
                <td v-for="day in week">{{ day | date 'd' }}</td>
            </tr>
        </tbody>
    </table>
    <!-- <ul class="uk-list uk-list-line">
        <li v-for="date in calendar">{{ date | date 'd' }}</li>
    </ul> -->
</div>
