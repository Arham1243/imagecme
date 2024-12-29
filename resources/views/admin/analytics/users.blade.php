@extends('admin.analytics.layouts.main')
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
                <div class="chart-title">Total Users per Month</div>
                <div class="chart-item">
                    <div id="overallUsersChart"></div>
                </div>
            </div>

            <div class="chart mb-5">
                <div class="chart-title">Users by Specialty</div>
                <div class="chart-item">
                    <div id="specialtyChart"></div>
                </div>
            </div>

            <div class="chart mb-5">
                <div class="chart-title">Users by Role</div>
                <div class="chart-item">
                    <div id="caseTypeChart"></div>
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
            drawOverallUsersChart();
            drawSpecialtyChart();
            drawCaseTypeChart();
        }

        function drawSpecialtyChart() {
            var data = google.visualization.arrayToDataTable([
                ['Month',
                    @foreach ($specialtyData->first() as $specialty => $count)
                        '{{ $specialty }}',
                    @endforeach
                ],
                @foreach ($specialtyData as $month => $counts)
                    ['{{ $month }}',
                        @foreach ($counts as $count)
                            {{ $count }},
                        @endforeach
                    ],
                @endforeach
            ]);

            // Check if there's any data
            if (data.getNumberOfRows() === 0 || data.getNumberOfColumns() === 1) {
                $('#specialtyChart').html('<div class="no-data-message">No data available to display.</div>');
            } else {
                var options = {
                    width: 800,
                    height: 500,
                    isStacked: true,
                    hAxis: {
                        title: 'Month',
                        slantedText: true,
                        slantedTextAngle: 45,
                    },
                    vAxis: {
                        title: 'Total Users',
                        minValue: 0,
                    },
                    legend: {
                        position: 'top',
                        alignment: 'center',
                    },
                    chartArea: {
                        left: 50,
                        top: 50,
                        width: '80%',
                        height: '70%',
                    },
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('specialtyChart'));
                chart.draw(data, options);
            }
        }

        function drawCaseTypeChart() {
            var data = google.visualization.arrayToDataTable([
                ['Month',
                    @foreach ($userRoleData->first() as $type => $count)
                        '{{ $type }}',
                    @endforeach
                ],
                @foreach ($userRoleData as $month => $counts)
                    ['{{ $month }}',
                        @foreach ($counts as $count)
                            {{ $count }},
                        @endforeach
                    ],
                @endforeach
            ]);

            // Check if there's any data
            if (data.getNumberOfRows() === 0 || data.getNumberOfColumns() === 1) {
                $('#caseTypeChart').html('<div class="no-data-message">No data available to display.</div>');
            } else {
                var options = {
                    width: 800,
                    height: 500,
                    isStacked: true,
                    hAxis: {
                        title: 'Month',
                        slantedText: true,
                        slantedTextAngle: 45,
                    },
                    vAxis: {
                        title: 'Total Users',
                        minValue: 0,
                    },
                    legend: {
                        position: 'top',
                        alignment: 'center',
                    },
                    chartArea: {
                        left: 50,
                        top: 50,
                        width: '80%',
                        height: '70%',
                    },
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('caseTypeChart'));
                chart.draw(data, options);
            }
        }

        function drawOverallUsersChart() {
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Total Users'],
                @foreach ($usersData as $month => $total)
                    ['{{ $month }}', {{ $total }}],
                @endforeach
            ]);

            let allZero = Object.values(@json($usersData)).every(value => value === 0);

            if (allZero) {
                $('#overallUsersChart').html('<p>No data available to display.</p>');
                return;
            }
            var options = {
                width: 800,
                height: 500,
                hAxis: {
                    title: 'Month',
                    slantedText: true,
                    slantedTextAngle: 45
                },
                vAxis: {
                    title: 'Total Users',
                    viewWindow: {
                        min: 0
                    }
                },
                legend: {
                    position: 'none'
                },
                chartArea: {
                    width: '70%',
                    height: '70%'
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('overallUsersChart'));
            chart.draw(data, options);
        }
    </script>
@endpush
