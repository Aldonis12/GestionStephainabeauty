function createDonutChart(chartId, legendId, labels, data) {
    if ($(chartId).length) {
        var areaData = {
            labels: labels,
            datasets: [
                {
                    data: data,
                    backgroundColor: ["#4B49AC", "#FFC100", "#248AFD"],
                    borderColor: "rgba(0,0,0,0)",
                },
            ],
        };
        var areaOptions = {
            responsive: true,
            maintainAspectRatio: true,
            segmentShowStroke: false,
            cutoutPercentage: 78,
            elements: {
                arc: {
                    borderWidth: 4,
                },
            },
            legend: {
                display: false,
            },
            tooltips: {
                enabled: true,
            },
            legendCallback: function (chart) {
                var text = [];
                text.push('<div class="report-chart">');

                for (var i = 0; i < chart.data.labels.length; i++) {
                    var label = chart.data.labels[i];
                    var data = chart.data.datasets[0].data[i];
                    var backgroundColor =
                        chart.data.datasets[0].backgroundColor[i];

                    text.push(
                        '<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3">'
                    );
                    text.push('<div class="d-flex align-items-center">');
                    text.push(
                        '<div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' +
                            backgroundColor +
                            '"></div>'
                    );
                    text.push('<p class="mb-0">' + label + "</p>");
                    text.push("</div>");
                    text.push('<p class="mb-0">' + data + "</p>");
                    text.push("</div>");
                }

                text.push("</div>");
                return text.join("");
            },
        };
        var SommeData = data.reduce(function (a, b) {
            return a + b;
        }, 0);
        var northAmericaChartPlugins = {
            beforeDraw: function (chart) {
                var width = chart.chart.width,
                    height = chart.chart.height,
                    ctx = chart.chart.ctx;

                ctx.restore();
                var fontSize = 3.125;
                ctx.font = "600 " + fontSize + "em sans-serif";
                ctx.textBaseline = "middle";
                ctx.fillStyle = "#000";

                var text = SommeData,
                    textX = Math.round(
                        (width - ctx.measureText(text).width) / 2
                    ),
                    textY = height / 2;

                ctx.fillText(text, textX, textY);
                ctx.save();
            },
        };
        var northAmericaChartCanvas = $(chartId).get(0).getContext("2d");
        var northAmericaChart = new Chart(northAmericaChartCanvas, {
            type: "doughnut",
            data: areaData,
            options: areaOptions,
            plugins: northAmericaChartPlugins,
        });
        document.getElementById(legendId).innerHTML =
            northAmericaChart.generateLegend();
    }
}

function NombreClient(variableID, legendID, labels, data) {
    if ($(variableID).length) {
        var SalesChartCanvas = $(variableID).get(0).getContext("2d");
        var SalesChart = new Chart(SalesChartCanvas, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Client",
                        data: data,
                        backgroundColor: "#98BDFF",
                    },
                ],
            },
            options: {
                cornerRadius: 10,
                responsive: true,
                maintainAspectRatio: true,
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 20,
                        bottom: 0,
                    },
                },
                scales: {
                    yAxes: [
                        {
                            display: true,
                            gridLines: {
                                display: true,
                                drawBorder: false,
                                color: "#F2F2F2",
                            },
                            ticks: {
                                display: true,
                                min: 0,
                                max: Math.ceil(Math.max(...data) / 10) * 20,
                                callback: function (value, index, values) {
                                    return value.toString();
                                },
                                autoSkip: true,
                                maxTicksLimit: 10,
                                fontColor: "#6C7383",
                            },
                        },
                    ],
                    xAxes: [
                        {
                            stacked: false,
                            ticks: {
                                beginAtZero: true,
                                fontColor: "#6C7383",
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                                display: false,
                            },
                            barPercentage: 1,
                        },
                    ],
                },
                legend: {
                    display: false,
                },
                elements: {
                    point: {
                        radius: 0,
                    },
                },
            },
        });
        document.getElementById(legendID).innerHTML =
            SalesChart.generateLegend();
    }
}

function AvisClient(
    avisId,
    avislegendId,
    avislabel,
    reponsebien,
    reponsemoyen,
    reponsemauvais
) {
    if ($(avisId).length) {
        var maxValue = Math.max(
            ...reponsebien,
            ...reponsemoyen,
            ...reponsemauvais
        );

        var result = Math.ceil(maxValue / 10) * 10;
        var SalesChartCanvas = $(avisId).get(0).getContext("2d");
        var SalesChart = new Chart(SalesChartCanvas, {
            type: "bar",
            data: {
                labels: avislabel,
                datasets: [
                    {
                        label: "Enchanté",
                        data: reponsebien,
                        backgroundColor: "#98BDFF",
                    },
                    {
                        label: "Moyennement Satisfait",
                        data: reponsemoyen,
                        backgroundColor: "#4B49AC",
                    },
                    {
                        label: "Mécontent",
                        data: reponsemauvais,
                        backgroundColor: "#f268a4",
                    },
                ],
            },
            options: {
                cornerRadius: 5,
                responsive: true,
                maintainAspectRatio: true,
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 20,
                        bottom: 0,
                    },
                },
                scales: {
                    yAxes: [
                        {
                            display: true,
                            gridLines: {
                                display: true,
                                drawBorder: false,
                                color: "#F2F2F2",
                            },
                            ticks: {
                                display: true,
                                min: 0,
                                max: result,
                                callback: function (value, index, values) {
                                    return value + "%";
                                },
                                autoSkip: true,
                                maxTicksLimit: 10,
                                fontColor: "#6C7383",
                            },
                        },
                    ],
                    xAxes: [
                        {
                            stacked: false,
                            ticks: {
                                beginAtZero: true,
                                fontColor: "#6C7383",
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                                display: false,
                            },
                            barPercentage: 1,
                        },
                    ],
                },
                legend: {
                    display: false,
                },
                elements: {
                    point: {
                        radius: 0,
                    },
                },
            },
        });
        document.getElementById(avislegendId).innerHTML =
            SalesChart.generateLegend();
    }
}

function ExportPNG(container, exportButton, filename) {
    exportButton.style.display = "none";

    const options = {
        width: container.offsetWidth,
        height: container.offsetHeight,
    };

    html2canvas(container, options).then(function (canvas) {
        exportButton.style.display = "block";

        const dataUrl = canvas.toDataURL("image/png");

        const a = document.createElement("a");
        a.href = dataUrl;
        a.download = "chart_" + filename + ".png";

        a.click();
    });
}

function NombreService(variableID, legendID, labels,name,data,color) {
    if ($(variableID).length) {
        var SalesChartCanvas = $(variableID).get(0).getContext("2d");
        var datasets = [];

        for (var i = 0; i < name.length; i++) {
            var dataset = {
                label: name[i],
                data: data,
                backgroundColor: color,
            };
            datasets.push(dataset);
        }

        var SalesChart = new Chart(SalesChartCanvas, {
            type: "bar",
            data: {
                labels: labels,
                datasets: datasets,
            },
            options: {
                cornerRadius: 10,
                responsive: true,
                maintainAspectRatio: true,
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 20,
                        bottom: 0,
                    },
                },
                scales: {
                    yAxes: [
                        {
                            display: true,
                            gridLines: {
                                display: true,
                                drawBorder: false,
                                color: "#F2F2F2",
                            },
                            ticks: {
                                display: true,
                                min: 0,
                                max: Math.ceil(Math.max(...data) / 10) * 20,
                                callback: function (value, index, values) {
                                    return value.toString();
                                },
                                autoSkip: true,
                                maxTicksLimit: 10,
                                fontColor: "#6C7383",
                            },
                        },
                    ],
                    xAxes: [
                        {
                            stacked: false,
                            ticks: {
                                beginAtZero: true,
                                fontColor: "#6C7383",
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                                display: false,
                            },
                            barPercentage: 1,
                        },
                    ],
                },
                legend: {
                    display: false,
                },
                elements: {
                    point: {
                        radius: 0,
                    },
                },
            },
        });
        document.getElementById(legendID).innerHTML =
            SalesChart.generateLegend();
    }
}

function NombreClientCODE(variableID, legendID, labels, data) {
    if ($(variableID).length) {
        var SalesChartCanvas = $(variableID).get(0).getContext("2d");
        var SalesChart = new Chart(SalesChartCanvas, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Client",
                        data: data,
                        backgroundColor: "#98BDFF",
                    },
                ],
            },
            options: {
                cornerRadius: 10,
                responsive: true,
                maintainAspectRatio: true,
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 20,
                        bottom: 0,
                    },
                },
                scales: {
                    yAxes: [
                        {
                            display: true,
                            gridLines: {
                                display: true,
                                drawBorder: false,
                                color: "#F2F2F2",
                            },
                            ticks: {
                                display: true,
                                min: 0,
                                max: Math.ceil(Math.max(...data) / 10) * 20,
                                callback: function (value, index, values) {
                                    return value.toString();
                                },
                                autoSkip: true,
                                maxTicksLimit: 10,
                                fontColor: "#6C7383",
                            },
                        },
                    ],
                    xAxes: [
                        {
                            stacked: false,
                            ticks: {
                                beginAtZero: true,
                                fontColor: "#6C7383",
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                                display: false,
                            },
                            barPercentage: 1,
                        },
                    ],
                },
                legend: {
                    display: false,
                },
                elements: {
                    point: {
                        radius: 0,
                    },
                },
            },
        });
        document.getElementById(legendID).innerHTML =
            SalesChart.generateLegend();
    }
}