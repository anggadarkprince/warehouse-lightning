const bookingChart = document.getElementById('booking-chart');
const deliveryChart = document.getElementById('delivery-chart');
const jobChart = document.getElementById('job-chart');
const stockContainerChart = document.getElementById('stock-container-chart');
const stockGoodsChart = document.getElementById('stock-goods-chart');
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
const stockChartOptions = {
    tooltips: {
        mode: 'index',
        intersect: false,
    },
    legend: {
        display: false,
    },
    scales: {
        xAxes: [{
            gridLines: {
                zeroLineColor: "rgba(0, 0, 0, 0.08)",
                color: "rgba(0, 0, 0, 0.08)",
            }
        }],
        yAxes: [{
            display: false,
            ticks: {
                beginAtZero: true,
                min: 0,
                suggestedMax: 5
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
                backgroundColor: 'rgb(39, 145, 226)',
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
                backgroundColor: 'rgb(72, 187, 120)',
                data: document.jobWeekly || []
            }]
        },
        options: miniChartOptions
    });
}

if (stockContainerChart) {
    const ctx = stockContainerChart.getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
            datasets: [{
                label: '45',
                backgroundColor: 'rgba(34,138,217,.1)',
                borderColor: 'rgb(34,138,217)',
                data: document.stockContainer45 || [],
                pointRadius: 3,
                pointBackgroundColor: 'rgb(34,138,217)',
                pointBorderWidth: 0,
                lineTension: 0,
            }, {
                label: '40',
                backgroundColor: 'rgba(54,156,234,.1)',
                borderColor: 'rgb(54,156,234)',
                data: document.stockContainer40 || [],
                pointRadius: 3,
                pointBackgroundColor: 'rgb(39,145,226)',
                pointBorderWidth: 0,
                lineTension: 0,
            }, {
                label: '20',
                backgroundColor: 'rgba(111,192,253,.1)',
                borderColor: 'rgb(111,192,253)',
                data: document.stockContainer20 || [],
                pointRadius: 3,
                pointBackgroundColor: 'rgb(111,192,253)',
                pointBorderWidth: 0,
                lineTension: 0,
            }]
        },
        options: stockChartOptions
    });
}

if (stockGoodsChart) {
    const ctx = stockGoodsChart.getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
            datasets: [{
                label: 'Goods Stock',
                backgroundColor: 'rgba(255, 99, 132, .2)',
                borderColor: 'rgb(255, 99, 132)',
                data: document.stockGoods || [],
                pointRadius: 5,
                pointBackgroundColor: 'rgb(255, 255, 255)',
                pointBorderWidth: 2,
            }]
        },
        options: stockChartOptions
    });
}
