import Echo from "laravel-echo";

window.Pusher = require('pusher-js');
//window.Pusher.logToConsole = true;
//const lang = document.documentElement.lang || 'en';

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '4e81645806ddef0652b7',
    cluster: 'ap1',
    //authEndpoint: `/${lang}/broadcasting/auth`
});

if ('Notification' in window) {
    function displayNotification(title, message) {
        let options = {
            body: message,
            icon: '/img/favicon.png',
        };
        new Notification(title, options);
    }
    if (Notification.permission !== "granted") {
        Notification.requestPermission(function (result) {
            if (result !== 'granted') {
                console.log('No notification permission granted');
            } else {
                displayNotification(
                    'Successfully subscribed!',
                    'You successfully subscribe to our notification service!'
                );
            }
        });
    } else {

        const userId = document.head.querySelector('meta[name="user-id"]').content || 0;
        window.Echo.private(`job.assigned.${userId}`)
            .listen('JobAssignedEvent', (e) => {
                const workOrder = e.workOrder;
                displayNotification(
                    'Job Assignment',
                    `You are assigned to proceed Job ${workOrder.job_number} (${workOrder.job_type}), happy working!`
                );
            });

        window.Echo.private(`upload.validated`)
            .listen('UploadValidatedEvent', (e) => {
                const upload = e.upload;
                displayNotification(
                    'Upload Validated',
                    `Upload document number ${upload.upload_number} is validated and ready to be booked!`
                );
            });

        window.Echo.private(`booking.inbound.validated`)
            .listen('BookingValidatedEvent', (e) => {
                const booking = e.booking;
                displayNotification(
                    'Booking Validated',
                    `Booking inbound ${booking.booking_number} (${booking.booking_type.booking_name}) is validated and ready to deliver!`
                );
            });

        window.Echo.private(`booking.outbound.validated`)
            .listen('BookingValidatedEvent', (e) => {
                const booking = e.booking;
                displayNotification(
                    'Booking Validated',
                    `Booking outbound ${booking.booking_number} (${booking.booking_type.booking_name}) is validated and ready to be loaded!`
                );
            });

    }
} else {
    console.log('Not support notification');
}
