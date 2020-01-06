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
                failure: () => {
                    // alert("There was an error while fetching FullCalendar!");
                },
            },
        ],
        dateClick: (info) => {
            calendarEl.getAttribute("professional");
            const days = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
            //console.log(days[info.date.getDay()]);
            fetch(`/service/test/${calendarEl.getAttribute('professional')}/${info.dateStr}`)
                .then((response) => {
                    return response.json()
                })
                .then((result) => {
                    console.log(result);
                    let hours = ''
                    result.forEach((item, index) => hours += `<button class="btn btn-pink">${result[index].openTime.slice(11, 16)}</button>
                                                          <button class="btn btn-pink">${result[index].closeTime.slice(11, 16)}</button>`)
                    $(".modal-body").html(hours);
                    $('#exampleModalCenter').modal();

                });

            const monthNames = [
                "Janvier", "Février", "Mars",
                "Avril", "Mai", "Juin", "Juillet",
                "Août", "Septembre", "Octobre",
                "Novembre", "Decembre"
            ];
            let day = info.date.getDate();
            let monthIndex = info.date.getMonth();
            let year = info.date.getFullYear();



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
