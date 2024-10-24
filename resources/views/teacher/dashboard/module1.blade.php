<div class="card h-xl-100 " style="overflow: scroll;">
    <!--begin::Body-->
    <div class="card-body mt-3 px-3 pt-0" style="overflow: scroll;" form-control="dashboard-calendar">

    </div>
    <!--end::Body-->
</div>

<script>
    var calendar;
    var calendarManager;

    $(() => {
        calendar = new Calendar({
            container: document.querySelector('[form-control="dashboard-calendar"]')
        });
    })

    var Calendar = class {
        constructor(options) {
            this.container = options.container;
            this.currentDate = this.createCurrentDate();
            this.dateData = {
                date: this.currentDate,
                events: {!! $sections !!},

            };

            this.init();    
        };

        getDateData() {
            return this.dateData;
        };

        removeAllEvents() {
            this.getDateData().events = [];
            this.render();
        };

        updateAllEvents(events) {
            this.getDateData().events = events;
            this.render();
        };

        /**
         * Filter out events added directly to the calendar and retain.
         * Additionally add new events from the schedules
         */
        updateEvents(newEvents) {
            const currCalendarEvents = this.getDateData().events;
            const eventNeedRemoveIndexs = []; // The array of event indexs add in calendar need remove

            for(let i = 0; i < currCalendarEvents.length; ++i) {
                let currEvent = currCalendarEvents[i].is_add_later;

                if(!currEvent || currEvent=== "" || currEvent === null || currEvent == "0") {
                    eventNeedRemoveIndexs.push(i);
                };
            };

            // Remove old week schedule items in currCalendarEvents (ignore events add in calendar).
            const filteredCalendarEvents = currCalendarEvents.filter((event, index) => !eventNeedRemoveIndexs.includes(index));

            // Merge current filtered array & new array.
            const newEventsFiltered = filteredCalendarEvents.concat(newEvents);

            this.getDateData().events = newEventsFiltered;
            this.render();
        };

        deleteEventInCalendar(code, date) {
            if(!date.split(' ')[1]) {
                date += ' 00:00:00'
            };
            
            const existingEvents = this.getDateData().events;

            const updatedEvents = existingEvents.filter(event => {
                let eventDate = event.study_date;

                if(!eventDate.split(' ')[1]) {
                    eventDate += ' 00:00:00'
                };

                return !(event.code === code && eventDate === date);
            });

            this.getDateData().events = updatedEvents;
            this.render();
        };

        getContainer() {
            return this.container;
        };

        getEvents() {
            return this.dateData.events;
        };

        getPrevMonthBtn() {
            return this.container.querySelector('[data-control="prev-btn"]');
        };

        getTodayBtn() {
            return this.container.querySelector('[data-control="today-btn"]');
        };

        getNextMonthBtn() {
            return this.container.querySelector('[data-control="next-btn"]');
        };

        createCurrentDate() {
            const currentDateObject = new Date();
            const year = currentDateObject.getFullYear();
            const month = String(currentDateObject.getMonth() + 1).padStart(2, '0');
            const day = String(currentDateObject.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };

        getCurrentDate() {
            return this.currentDate;
        };

        prevMonth() {
            this.currentDate = this.getPrevMonthByDate(this.currentDate);
            this.dateData.date = this.currentDate;
            this.render();
        };

        today() {
            this.currentDate = this.getToday();
            this.dateData.date = this.currentDate;
            this.render();
        };

        nextMonth() {
            this.currentDate = this.getNextMonthByDate(this.currentDate);
            this.dateData.date = this.currentDate;
            this.render();
        };

        getPrevMonthByDate(dateString) {
            const date = new Date(dateString);
            date.setMonth(date.getMonth() - 1);
            return date.toISOString().slice(0, 10);
        };

        getToday() {
            const date = new Date(this.createCurrentDate());
            return date.toISOString().slice(0, 10);
        };

        getNextMonthByDate(dateString) {
            const date = new Date(dateString);
            date.setMonth(date.getMonth() + 1);
            return date.toISOString().slice(0, 10);
        };

        init() {
            this.render();
            this.events();
        };

        events() {
            $(this.getPrevMonthBtn()).on('click', e => {
                e.preventDefault();

                this.prevMonth();
            });

            $(this.getTodayBtn()).on('click', e => {
                e.preventDefault();

                this.today();
            });

            $(this.getNextMonthBtn()).on('click', e => {
                e.preventDefault();

                this.nextMonth();
            });
        };

        getEventByCodeAndDate(code, date) {
            const events = this.getDateData().events;

            events.forEach(event => {
                if(event.study_date.split(' ').length < 2) {
                    event.study_date += ' 00:00:00';
                };
            });

            const result = events.find(event => event.code === code && event.study_date === date);
            const endArrTimePart = result.end_at.split(' ')[1];
            const startArrTimePart = result.start_at.split(' ')[1];

            if(startArrTimePart) {
                result.start_at = startArrTimePart;
            };

            if(endArrTimePart) {
                result.end_at = endArrTimePart;
            };

            return result;
        };

        editEvent(eventEdited) {
            const existingEvents = this.getDateData().events;
            const updatedEvents = existingEvents.filter(event => {
                return !(event.code == eventEdited.code && event.study_date == eventEdited.study_date);
            });

            this.getDateData().events = updatedEvents;
            this.getDateData().events.push(eventEdited);
            this.render();
        };

        addEvent(event) {
            this.dateData.events.push(event);
            this.render();
        };

        getTotalMonth(currDate) {
            const _this = this;
            const yearAndMonthPart = _this.getPartYearAndMonth(currDate);

            let date = new Date(yearAndMonthPart);

            if(isNaN(date.getTime())) {
                throw new Error('Chuối ngày tháng không hợp lệ!');
            }

            let totalMonth = date.getFullYear() * 12 + date.getMonth() + 1;

            return totalMonth;
        };

        getPartYearAndMonth(dateTime) {
            const _this = this;
            let yearAndMonth;

            // Get part year-month-date of date (ignore time if has time)
            const currDateArr = dateTime.split(' ');
            if(currDateArr.length > 1) {
                yearAndMonth = currDateArr[0];
            } else {
                yearAndMonth = dateTime;
            }

            return yearAndMonth;
        };

        // Load balancing for scheduling optimization.
        getEventByMonth(allEvents) {
            const _this = this;
            const currDate = this.dateData.date;
            const totalMonthOfCurrDate = _this.getTotalMonth(currDate);
            const events = [];

            allEvents.forEach(event => {
                const totalMonthOfEvent = _this.getTotalMonth(event.start_at);

                if(parseInt(totalMonthOfEvent) === parseInt(totalMonthOfCurrDate)) {
                    events.push(event);
                };
            });

            return events;
        };

        addLoadEffect() {
            this.getContainer().classList.add('list-loading');

            if (!this.getContainer().querySelector('[list-action="loader"]')) {
                $(this.listContent).before(`
                    <div list-action="loader" class="py-20 px-3 text-center position-absolute" style="left:calc(50% - 20px);top:20px;">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `);
            }
        };

        removeLoadEffect() {
            this.getContainer().classList.remove('list-loading');

            // remove loader
            if (this.getContainer().querySelector('[list-action="loader"]')) {
                this.getContainer().querySelector('[list-action="loader"]').remove();
            }
        };

        render() {
            const _this = this;
            const data = {};
            const eventsByMonth = this.getEventByMonth(this.dateData.events);

            data._token = "{{ csrf_token() }}";
            data.date = this.dateData.date;
            data.events = JSON.stringify(eventsByMonth);

            _this.addLoadEffect();

            $.ajax({
                url: '{{ action('App\Http\Controllers\CalendarController@getDashboardCalendar') }}',
                method: 'POST',
                data: data,
            }).done(response => {
                $(this.container).html(response)
                calendarSectionHandle.events();
                
                this.events();
                
                if($(this.getContainer())[0]) {
                    initJs($(this.getContainer())[0]);
                };

                _this.removeLoadEffect();

            }).fail(response => {
                throw new Error(response);
            })

            // document.addEventListener('doneLoadNewglobalCalendarManager', function(event) {
            //     globalCalendarManager.disableActionsInEventBoxes();
            // })
        };
    };
</script>
