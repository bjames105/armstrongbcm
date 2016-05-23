module.exports = {

	el: '#events',

	ready: function () {
        var today = new Date();

		this.resource = this.$resource('api/events{/id}');
        this.months = [ 'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December' ];
        this.month = this.months[today.getMonth()];

        var getMonthLength = function (date)
        {
            var nextMonth = new Date();
            nextMonth.setMonth(date.getMonth() + 1);
            nextMonth.setDate(1);
            nextMonth.setDate(nextMonth.getDate() - 1);
            return nextMonth.getDate();
        }

		// Takes a Date object and returns a list of dates in a month
		var composeCalendar = function (date)
        {
            var calendar = [];
			var monthLength = getMonthLength(date);

			for (var i = 1; i <= monthLength; i++)
			{
                var d = new Date(date.getTime());
                d.setDate(i);
				calendar.push(d);
			}

            return calendar;
        }

		// Takes an array of dates then turns it into a calendar that the UI can use
		var calendarForView = function (cal)
		{
			var startsOnDay = cal[0].getDay();
			var endsOnDay = cal[cal.length - 1].getDay();
			var week = 0;
			var calendar = { weeks: [] };
			calendar.weeks[week] = [];

			// Add the days in the calendar from the previous month to fill out
			// the week
			if (startsOnDay > 0)
			{
				for (var i = startsOnDay; i > 0; i--)
				{
					var date = new Date(cal[0].getTime());
					date.setDate(date.getDate() - i);
	                calendar.weeks[week].push(date);
				}
			}

            for (var i = 0; i < cal.length; i++)
            {
				var date = cal[i];

				if (date.getDay() == 0)
				{
					calendar.weeks[++week] = [];
				}

				calendar.weeks[week].push(date);
            }

			var lastWeek = calendar.weeks[calendar.weeks.length - 1];

			if (lastWeek.length < 7)
			{
				var lastDayOfMonth = cal[cal.length - 1];
				var i = 0;

				while (lastWeek.length < 7)
				{
					var date = new Date(lastDayOfMonth.getTime());
					date.setDate(date.getDate() + i++);

					lastWeek.push(date);
				}
			}

			return calendar;
		}

        this.calendar = calendarForView(composeCalendar(today));
	},

	data: {

		weekdays: {
            Sun: 'Sunday',
			Mon: 'Monday',
			Tue: 'Tuesday',
			Wed: 'Wednesday',
            Thu: 'Thursday',
			Fri: 'Friday',
			Sat: 'Saturday'
		},
        calendar: this.calendar,
        month: this.month,
        daysInMonth: this.monthLength
	},

	methods: {
        getMonthLength: function (date)
        {
            return this.getMonthLength(date);
        }
	}
};

Vue.ready(module.exports);

/**
 * Vue filter to make a simple timestamp for an ISO date.
 * http://jsfiddle.net/bryan_k/44kqtpeg/
 *
 * @param {String} value The value string.
 */
Vue.filter('time', function(value) {
	time = value.split(':');
	var amPm = 'PM';

	if (parseInt(time[0], 10) > 12)
	{
	   var hour = parseInt(time[0], 10) % 12;
	}
	else
	{
    	var hour = parseInt(time[0], 10);
	    if (hour == 12)
		{
			amPm = 'PM';
		}
		else
		{
			amPm = 'AM';
		}
	}

	return hour + ':' + time[1] + ' ' + amPm;
});

/**
 * Vue filter to make a simple timestamp for an ISO date.
 * http://jsfiddle.net/bryan_k/44kqtpeg/
 *
 * @param {String} value The value string.
 */
Vue.filter('date', function(value, format)
{
    var dateFormat = require('dateformat');

    if (!(!!format))
    {
        format = "fullDate";
    }
    var date = new Date(value);
    return dateFormat(date, format);
});
