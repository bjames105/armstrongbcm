module.exports = {

	el: '#events',

	ready: function () {
		// A useless line to make sure my git config was changed properly
        var today = new Date();

		this.resource = this.$resource('api/events{/id}');
        this.months = [ 'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December' ];
        this.today = today;
        this.month = this.months[today.getMonth()];

        var getMonthLength = function (date)
        {
            var nextMonth = new Date();
            nextMonth.setMonth(date.getMonth() + 1);
            nextMonth.setDate(1);
            nextMonth.setDate(nextMonth.getDate() - 1);
            return nextMonth.getDate();
        }

        this.daysInMonth = getMonthLength(today);

        var composeCalendar = function (date)
        {
            var calendar = {
                weeks: [],
                events: []
            };

            var date = new Date();
            var daysInMonth = getMonthLength(date);
            var week = 0;

            for (var i = 1; i <= daysInMonth; i++)
            {
                var d = new Date();
                d.setDate(i);

                if (d.getDay() == 0 || i == 1)
                {
                    week++;
                    calendar.weeks[week] = [];
                }

                calendar.weeks[week].push(d);
            }
            return calendar;
        }

        this.calendar = composeCalendar(today);
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
