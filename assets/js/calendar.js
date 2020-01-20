// assets/js/calendar/index.js

import { Calendar } from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import frLocale from '@fullcalendar/core/locales/fr';

import '@fullcalendar/core/main.css';
import '@fullcalendar/daygrid/main.css';
import '@fullcalendar/timegrid/main.css';

import '../scss/calendar.scss'; // this will create a calendar.css file reachable to 'encore_entry_link_tags'
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min';

require('bootstrap');
const $ = require('jquery');

// FOS BUNDLE JS ROUTING
const routes = require('../../public/js/fos_js_routes.json'); // eslint-disable-line

Routing.setRoutingData(routes);

document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('calendar-holder');
    const calendar = new Calendar(calendarEl, {
        defaultView: 'dayGridMonth',
        editable: true,
        selectable: true,
        dateClick: (info) => {
            /* CREATE NEW DATE TO COMPARE IF DATE CLICKED IS PAST OR NOT */
            const today = new Date();
            today.setHours(0);
            /* IF PAST NO EVENT IS DONE, ELSE A MODAL OPEN WITH AVAILABLE HOURS FOR THIS SERVICE */
            if (today < info.date) {
                fetch(Routing.generate('get_hours', { id: calendarEl.getAttribute('service'), date: info.dateStr }))
                    .then(response => response.json())
                    .then((result) => {
                        if (result.length === 0) {
                            $('.modal-body').html('Il n\'y a pas d\'horaires disponible pour ce jour');
                        } else {
                            let hours = '';
                            result.forEach((item, index) => {
                                hours += `<a href="/booking/${calendarEl.getAttribute('service')}/${info.dateStr}/${result[index]}" class="btn btn-pink">${result[index]}</a>`;
                            });
                            $('.modal-body').html(hours);
                        }
                        $('#exampleModalCenter').modal();
                    });
            }
        },
        dayRender: (dayRenderInfo) => {
            const today = new Date();
            today.setHours(0);
            if (today > dayRenderInfo.date) {
                // eslint-disable-next-line no-param-reassign
                dayRenderInfo.el.bgColor = '#f4f4f4';
            }
        },
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'today',
        },
        locale: frLocale,
        plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin], // https://fullcalendar.io/docs/plugin-index
        timeZone: 'UTC',
    });
    calendar.render();
});
