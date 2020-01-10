// assets/js/calendar/index.js

import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import frLocale from "@fullcalendar/core/locales/fr";

import "@fullcalendar/core/main.css";
import "@fullcalendar/daygrid/main.css";
import "@fullcalendar/timegrid/main.css";

import "../scss/calendar.scss"; // this will create a calendar.css file reachable to 'encore_entry_link_tags'

require("bootstrap");
const $ = require("jquery");

document.addEventListener("DOMContentLoaded", () => {
    var calendarEl = document.getElementById("calendar-holder");

    var eventsUrl = calendarEl.dataset.eventsUrl;

    var calendar = new Calendar(calendarEl, {
        defaultView: "dayGridMonth",
        editable: true,
        selectable: true,
        eventSources: [
            {
                url: eventsUrl,
                method: "POST",
                extraParams: {
                    filters: JSON.stringify({})
                },
            },
        ],
        dateClick: (info) => {
            fetch(`/service/${calendarEl.getAttribute('service')}/${info.dateStr}`)
                .then((response) => {
                    return response.json();
                })
                .then((result) => {
                    console.log(result);
                    if (result.length === 0) {
                        $(".modal-body").html("Il n'y a pas d'horaires disponible pour ce jour");
                    } else {
                        let hours = '';
                        result.forEach((item, index) => hours += `<a href="/booking/${calendarEl.getAttribute('service')}/${info.dateStr}/${result[index]}" class="btn btn-pink">${result[index]}</a>`)
                        $(".modal-body").html(hours);
                    }
                    $('#exampleModalCenter').modal();
                });
        },
        header: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        locale: frLocale,
        plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin], // https://fullcalendar.io/docs/plugin-index
        timeZone: "UTC",
    });
    calendar.render();
});
