const bookingChart = document.getElementById('booking-chart');
const deliveryChart = document.getElementById('delivery-chart');
const jobChart = document.getElementById('job-chart');
const miniChartOptions = {
    tooltips: {
        enabled: false
    },
    legend: {
        display: false,
    },
    scales: {
        xAxes: [{
            display: false,
            gridLines: {
                display: false,
                color: "rgba(0, 0, 0, 0)",
            }
        }],
        yAxes: [{
            display: false,
            gridLines: {
                display: false,
                color: "rgba(0, 0, 0, 0)",
            },
            ticks: {
                min: 0
            }
        }]
    }
};

if (bookingChart) {
    const ctx = bookingChart.getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
            datasets: [{
                label: 'Booking',
                backgroundColor: 'rgb(255, 99, 132)',
                data: document.weeklyBooking || []
            }]
        },
        options: miniChartOptions
    });
}

if (deliveryChart) {
    const ctx = deliveryChart.getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
            datasets: [{
                label: 'Booking',
                backgroundColor: 'rgb(39,145,226)',
                data: document.deliveryWeekly || []
            }]
        },
        options: miniChartOptions
    });
}

if (jobChart) {
    const ctx = jobChart.getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
            datasets: [{
                label: 'Booking',
                backgroundColor: 'rgb(72,187,120)',
                data: document.jobWeekly || []
            }]
        },
        options: miniChartOptions
    });
}
