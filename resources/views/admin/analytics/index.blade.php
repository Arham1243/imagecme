@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.analytics.index') }}
            <div id="validation-form">

                <div class="custom-sec custom-sec--form">
                    <div class="custom-sec__header">
                        <div class="section-content">
                            <h3 class="heading">Analytics</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Charts</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="chart">
                                        <div class="chart-title">Specialty</div>
                                        <div class="chart-item">
                                            <div id="specialtyPiechart" class="pie"></div>
                                        </div>
                                    </div>
                                    <div class="chart py-5">
                                        <div class="chart-title">Duration</div>
                                        <div class="chart-item">
                                            <div id="durationChart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        .pie {
            width: 700px;
            min-height: 400px;

        }
    </style>
@endpush
@push('js')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <script>
        google.charts.load('current', {
            'packages': ['corechart', 'bar']
        });
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            drawSpecialtyChart();
            drawDurationChart();
        }

        function showMessage(data, elementId, message = 'No data available for this chart.') {
            if (data.getNumberOfRows() === 0) {
                document.getElementById(elementId).innerHTML = `<p class="no-data-message">${message}</p>`;
                return true;
            }
            return false;
        }

        function drawSpecialtyChart() {
            var data = google.visualization.arrayToDataTable([
                ['Specialty', 'Total Trainings'],
                ['Specialty 1', '4']
            ]);
            if (showMessage(data, 'specialtyPiechart')) {
                return;
            }

            var chart = new google.visualization.PieChart(document.getElementById('specialtyPiechart'));
            chart.draw(data);
        }

        function drawDurationChart() {
            var data = google.visualization.arrayToDataTable([
                ['Duration', 'Total Trainings'],
                ['Duration 1', 4],
                ['Duration 2', 5],
                ['Duration 3', 6],
                ['Duration 4', 7],
                ['Duration 5', 8]
            ]);

            var options = {
                width: 800,
                height: 500,
                hAxis: {
                    title: 'Duration',
                    slantedText: true,
                    slantedTextAngle: 45
                },
                vAxis: {
                    title: 'Total Trainings',
                    format: '0',
                    viewWindow: {
                        min: 0
                    },
                    gridlines: {
                        count: -1
                    },
                },
                legend: {
                    position: 'none'
                },
                chartArea: {
                    left: 50,
                    top: 50,
                    width: '100%',
                    height: '70%'
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('durationChart'));
            chart.draw(data, options);
        }
    </script>
@endpush
