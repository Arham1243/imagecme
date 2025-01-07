@extends('user.analytics.layouts.main')
@section('chart_data')
    <div class="form-box">
        <div class="form-box__header">
            <div class="title">Charts</div>
        </div>
        <div class="form-box__body">
            <form id="year-form">
                <div class="form-fields mb-5 position-relative">
                    <label class="title">Select Year</label>
                    <input type="text" autocomplete="off" class="field" id="yearpicker" name="year"
                        value="{{ $year }}">
                </div>
            </form>
            <div class="chart mb-5">
                <div class="chart-title">Total Views per Case</div>
                <div class="chart-item">
                    <div id="caseViewsChart"></div>
                </div>
            </div>
            <div class="chart mb-5">
                <div class="chart-title">Total Likes per Case</div>
                <div class="chart-item">
                    <div id="caseLikesChart"></div>
                </div>
            </div>
            <div class="chart mb-5">
                <div class="chart-title">Total Comments per Case</div>
                <div class="chart-item">
                    <div id="caseCommentsChart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
        rel="stylesheet" />
@endpush
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        $(document).ready(function() {
            $('#yearpicker').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            }).on('changeDate', function() {
                $('#year-form').submit();
            }).on('show', function() {
                $(this).after($('.datepicker'));
            });
        });

        google.charts.load('current', {
            packages: ['corechart', 'bar']
        });
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            drawCaseViewsChart();
            drawCaseLikesChart();
            drawCaseCommentsChart();
        }



        function drawCaseViewsChart() {
            var caseViewsData = @json($caseViewsData);

            if (!caseViewsData || caseViewsData.length === 0) {
                document.getElementById('caseViewsChart').innerHTML = '<p>No data available to display.</p>';
                return;
            }

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Case');
            data.addColumn('number', 'Views');

            caseViewsData.forEach(item => {
                data.addRow([item.case, item.views]);
            });

            var options = {
                width: 800,
                height: 500,
                hAxis: {
                    title: 'Case',
                    textStyle: {
                        fontSize: 12
                    },
                    slantedText: true,
                    slantedTextAngle: 45,
                },
                vAxis: {
                    title: 'Views',
                    minValue: 0,
                    format: '0',
                },
                legend: {
                    position: 'none'
                },
                chartArea: {
                    left: 50,
                    top: 50,
                    width: '80%',
                    height: '70%'
                },
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('caseViewsChart'));
            chart.draw(data, options);
        }

        function drawCaseLikesChart() {
            var caseLikesData = @json($caseLikesData);

            if (!caseLikesData || caseLikesData.length === 0) {
                document.getElementById('caseLikesChart').innerHTML = '<p>No data available to display.</p>';
                return;
            }

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Case');
            data.addColumn('number', 'Likes');

            caseLikesData.forEach(item => {
                data.addRow([item.case, item.likes]);
            });

            var options = {
                width: 800,
                height: 500,
                hAxis: {
                    title: 'Case',
                    textStyle: {
                        fontSize: 12
                    },
                    slantedText: true,
                    slantedTextAngle: 45,
                },
                vAxis: {
                    title: 'Likes',
                    minValue: 0,
                    format: '0',
                },
                legend: {
                    position: 'none'
                },
                chartArea: {
                    left: 50,
                    top: 50,
                    width: '80%',
                    height: '70%'
                },
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('caseLikesChart'));
            chart.draw(data, options);
        }

        function drawCaseCommentsChart() {
            var caseCommentsData = @json($caseCommentsData);

            if (!caseCommentsData || caseCommentsData.length === 0) {
                document.getElementById('caseCommentsChart').innerHTML = '<p>No data available to display.</p>';
                return;
            }

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Case');
            data.addColumn('number', 'Comments');

            caseCommentsData.forEach(item => {
                data.addRow([item.case, item.comments]);
            });

            var options = {
                width: 800,
                height: 500,
                hAxis: {
                    title: 'Case',
                    textStyle: {
                        fontSize: 12
                    },
                    slantedText: true,
                    slantedTextAngle: 45,
                },
                vAxis: {
                    title: 'Comments',
                    minValue: 0,
                    format: '0',
                },
                legend: {
                    position: 'none'
                },
                chartArea: {
                    left: 50,
                    top: 50,
                    width: '80%',
                    height: '70%'
                },
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('caseCommentsChart'));
            chart.draw(data, options);
        }
    </script>
@endpush
