$(document).ready(function () {
    if ($('#container-categories').length) {
        var categoriesChart = null;
        categoriesChart = new Highcharts.chart('container-categories', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Estadísticas de uso por categorías'
                },
                credits: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                xAxis: {
                    categories: categories.map(category => category.name)
                },
                yAxis: {
                    title: {
                        text: null
                    }
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}%'
                        },
                        colorByPoint: true
                    }
                },

                series: [
                    {
                        name: 'Categoría',
                        data: categories.map(category => category.usePercentage),
                    }
                ]

            }
        )
    }

    if ($('#container-tasks').length) {
        var tasksChart = null;
        tasksChart = new Highcharts.chart('container-tasks', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Estadísticas de uso de pomodoros por tareas'
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: tasks.map(task => task.name),
                min: 0
            },
            yAxis: {
                stackLabels: {
                    enabled: false
                },
                labels: {
                    enabled: false
                },
                title: {
                    text: null
                },
                min: 0

            },
            plotOptions: {
                series: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                        style: {
                            textShadow: '0 0 3px black'
                        }
                    }
                }
            },
            legend: {
                reversed: true,
            },
            series: [
                {
                    name: 'Excedidos',
                    data: tasks.map(task => {
                        var exceeded = task.usedPomodoros - task.estimatedPomodoros

                        if (exceeded > 0) {
                            return exceeded
                        } else {
                            return 0
                        }
                    }),
                    color: 'red'
                },
                {
                    name: 'Usados',
                    data: tasks.map(task => task.usedPomodoros),
                    color: 'green'
                }
            ]
        })
    }

})
;