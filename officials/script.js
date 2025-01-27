


document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: 'fetch-events.php', // Load events from a PHP script
    });

    calendar.render();
});

function addEventToCalendar() {
    var type = document.getElementById('eventType').value;
    var date = document.getElementById('eventDate').value;
    var time = document.getElementById('eventTime').value;
    var message = document.getElementById('eventMessage').value;

    fetch('add-event.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'type=' + encodeURIComponent(type) +
              '&date=' + encodeURIComponent(date) +
              '&time=' + encodeURIComponent(time) +
              '&message=' + encodeURIComponent(message)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Event added successfully!');
            location.reload(); // Reload the page to reflect changes on the calendar
        } else {
            alert('Failed to add event!');
        }
    });

    return false; // Prevent form submission
}



document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [] // This will hold the events
    });
    calendar.render();

    // Check if there are event details passed from PHP
    var eventType = document.getElementById('eventTypeData').value;
    var eventDate = document.getElementById('eventDateData').value;
    var eventTime = document.getElementById('eventTimeData').value;
    var eventMessage = document.getElementById('eventMessageData').value;

    if (eventType && eventDate && eventTime && eventMessage) {
        // Parse the date and time into a proper format
        var eventStartDateTime = eventDate + 'T' + eventTime;

        // Add event to calendar
        calendar.addEvent({
            title: eventType,
            start: eventStartDateTime,
            description: eventMessage,
            allDay: false // adjust based on your needs
        });

        // Optionally, refocus the calendar on the newly added event
        calendar.gotoDate(eventStartDateTime);
    }
});


