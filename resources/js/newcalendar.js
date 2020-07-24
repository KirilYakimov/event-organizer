import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

document.addEventListener("DOMContentLoaded", function() {
    let calendarEl = document.getElementById("calendar");
    let calendar = new Calendar(calendarEl, {
        height: 650,
        plugins: [dayGridPlugin, interactionPlugin],
        defaultView: "dayGridMonth",

        events: eventArray,

        header: {
            left: "prev",
            center: "title",
            right: "next"
        },

        navLinks: true,
        eventLimit: true,

        eventClick: function(info) {
            info.event.url;
        }
    });
    calendar.render();
});
