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
                type: 'category'
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
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
            },

            series: [
                {
                    "name": "Categoría",
                    "colorByPoint": true,
                    "data": [
                        {
                            "name": "Comunicación y planificación",
                            "y": 62.74,
                            "drilldown": "Comunicación y planificación"
                        },
                        {
                            "name": "Entretenimiento y redes sociales",
                            "y": 10.57,
                            "drilldown": "Firefox"
                        },
                        {
                            "name": "Desarrollo de software",
                            "y": 7.23,
                            "drilldown": "Desarrollo de software"
                        },
                        {
                            "name": "Compras",
                            "y": 5.58,
                            "drilldown": "Compras"
                        },
                        {
                            "name": "Utilidades, referencias",
                            "y": 4.02,
                            "drilldown": "Utilidades, referencias"
                        },
                        {
                            "name": "Otro",
                            "y": 7.62,
                            "drilldown": null
                        }
                    ]
                }
            ],
            "drilldown": {
                "series": [
                    {
                        "name": "Chrome",
                        "id": "Chrome",
                        "data": [
                            [
                                "v65.0",
                                0.1
                            ],
                            [
                                "v64.0",
                                1.3
                            ],
                            [
                                "v63.0",
                                53.02
                            ],
                            [
                                "v62.0",
                                1.4
                            ],
                            [
                                "v61.0",
                                0.88
                            ],
                            [
                                "v60.0",
                                0.56
                            ],
                            [
                                "v59.0",
                                0.45
                            ],
                            [
                                "v58.0",
                                0.49
                            ],
                            [
                                "v57.0",
                                0.32
                            ],
                            [
                                "v56.0",
                                0.29
                            ],
                            [
                                "v55.0",
                                0.79
                            ],
                            [
                                "v54.0",
                                0.18
                            ],
                            [
                                "v51.0",
                                0.13
                            ],
                            [
                                "v49.0",
                                2.16
                            ],
                            [
                                "v48.0",
                                0.13
                            ],
                            [
                                "v47.0",
                                0.11
                            ],
                            [
                                "v43.0",
                                0.17
                            ],
                            [
                                "v29.0",
                                0.26
                            ]
                        ]
                    },
                    {
                        "name": "Firefox",
                        "id": "Firefox",
                        "data": [
                            [
                                "v58.0",
                                1.02
                            ],
                            [
                                "v57.0",
                                7.36
                            ],
                            [
                                "v56.0",
                                0.35
                            ],
                            [
                                "v55.0",
                                0.11
                            ],
                            [
                                "v54.0",
                                0.1
                            ],
                            [
                                "v52.0",
                                0.95
                            ],
                            [
                                "v51.0",
                                0.15
                            ],
                            [
                                "v50.0",
                                0.1
                            ],
                            [
                                "v48.0",
                                0.31
                            ],
                            [
                                "v47.0",
                                0.12
                            ]
                        ]
                    },
                    {
                        "name": "Internet Explorer",
                        "id": "Internet Explorer",
                        "data": [
                            [
                                "v11.0",
                                6.2
                            ],
                            [
                                "v10.0",
                                0.29
                            ],
                            [
                                "v9.0",
                                0.27
                            ],
                            [
                                "v8.0",
                                0.47
                            ]
                        ]
                    },
                    {
                        "name": "Safari",
                        "id": "Safari",
                        "data": [
                            [
                                "v11.0",
                                3.39
                            ],
                            [
                                "v10.1",
                                0.96
                            ],
                            [
                                "v10.0",
                                0.36
                            ],
                            [
                                "v9.1",
                                0.54
                            ],
                            [
                                "v9.0",
                                0.13
                            ],
                            [
                                "v5.1",
                                0.2
                            ]
                        ]
                    },
                    {
                        "name": "Edge",
                        "id": "Edge",
                        "data": [
                            [
                                "v16",
                                2.6
                            ],
                            [
                                "v15",
                                0.92
                            ],
                            [
                                "v14",
                                0.4
                            ],
                            [
                                "v13",
                                0.1
                            ]
                        ]
                    },
                    {
                        "name": "Opera",
                        "id": "Opera",
                        "data": [
                            [
                                "v50.0",
                                0.96
                            ],
                            [
                                "v49.0",
                                0.82
                            ],
                            [
                                "v12.1",
                                0.14
                            ]
                        ]
                    }
                ]
            }
        })
    }

    if ($('#container-tasks').length) {
        console.log(tasks.map(task => {
            return {
                x: task.usedPomodoros,
                color: task.usedPomodoros > task.estimatedPomodros ? 'red' : 'green'
            }
        }))
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
                    color: 'orange'
                },
                {
                    name: 'Estimados',
                    data: tasks.map(task => task.estimatedPomodoros),
                    color: 'blue'
                },
                {
                    name: 'Usados (ROJO y VERDE)',
                    data: tasks.map(task => {
                        return {
                            y: task.usedPomodoros,
                            color: task.usedPomodoros > task.estimatedPomodoros ? 'red' : 'green'
                        }
                    }),
                    color: 'white'
                }
            ]
        })
    }

});