
document.addEventListener("turbo:load", function () {
    // Call loadDashboardData when turbo:load event fires
    if( authUser && roleAdmin){
          loadDashboardData();
    }
});

function loadDashboardData() {
    // Call your AJAX request inside this function
    $.ajax({
        type: "post",
        url: route("user.storage.chart"),
        dataType: "json",
        success: function (result) {
            // Call storageChart with received data
            storageChart(result.data.data, result.data.labels);
        },
        cache: false,
    });
}

window.statisticsColors = ["#6571FF", "#C1C6FF"];

function storageChart(data, labels) {
    // Check if the element exists before accessing it
    let pieChartElement = document.getElementById("storagePieChart");
    if (!pieChartElement) return; // Exit if the element doesn't exist
    let ctx = pieChartElement.getContext("2d");
    new Chart(ctx, {
        type: "pie",
        options: {
            responsive: true,
            maintainAspectRatio: false,
            responsiveAnimationDuration: 500,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                           let label = labels[context.dataIndex] || '';
                           let value = Math.round(context.parsed) + "%";
                           return label + " " + value;
                        },
                    },
                },
            },
        },
        data: {
            datasets: [
                {
                    data: data,
                    backgroundColor: window.statisticsColors, // corrected variable name
                },
            ],
        },
    });
}
