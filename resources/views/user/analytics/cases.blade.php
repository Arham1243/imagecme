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
                <div class="chart-title">Total Images per Month</div>
                <div class="chart-item">
                    <div id="overallCasesChart"></div>
                </div>
            </div>

            <div class="chart mb-5">
                <div class="chart-title">Total Reviewed/Unreviewed Cases</div>
                <div class="chart-item">
                    <div id="commentedCasesChart"></div>
                </div>
            </div>

            <div class="chart mb-5">
                <div class="chart-title">Images by Specialty</div>
                <div class="chart-item">
                    <div id="specialtyChart"></div>
                </div>
            </div>

            <div class="chart mb-5">
                <div class="chart-title">Images by Type</div>
                <div class="chart-item">
                    <div id="imagesTypeChart"></div>
                </div>
            </div>

            <div class="chart mb-5">
                <div class="chart-title">Images by Quality</div>
                <div class="chart-item">
                    <div id="qualityChart"></div>
                </div>
            </div>

            <div class="chart mb-5">
                <div class="chart-title">Images by Ease of Diagnosis</div>
                <div class="chart-item">
                    <div id="easeOfDiagnosisChart"></div>
                </div>
            </div>

            <div class="chart mb-5">
                <div class="chart-title">Images by Certainty</div>
                <div class="chart-item">
                    <div id="certaintyChart"></div>
                </div>
            </div>

            <div class="chart mb-5">
                <div class="chart-title">Images by Segment</div>
                <div class="chart-item">
                    <div id="segmentChart"></div>
                </div>
            </div>

            <div class="chart mb-5">
                <div class="chart-title">Images by Ethnicity</div>
                <div class="chart-item">
                    <div id="ethnicityChart"></div>
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
            drawOverallCasesChart();
            drawSpecialtyChart();
            drawQualityChart();
            drawEaseOfDiagnosisChart()
            drawCertaintyChart()
            drawSegmentChart()
            drawEthnicityChart()
            drawImagesTypeChart()
            drawCommentedCasesChart()
        }


        function isAllDataEmpty(data) {
            for (var month in data) {

                if (Object.values(data[month]).some(value => value > 0)) {
                    return false;
                }
            }
            return true;
        }

        function drawImagesTypeChart() {
            var imageTypeData = @json($imageTypeData->toArray());

            var isEmpty = true;
            for (var month in imageTypeData) {
                if (Object.keys(imageTypeData[month]).length > 0) {
                    isEmpty = false;
                    break;
                }
            }

            if (isEmpty) {
                $('#imagesTypeChart').html('<p>No data available to display.</p>');
                return;
            }


            var chartDataArray = [];


            var header = ['Month'];

            var imageTypes = [];
            for (var month in imageTypeData) {
                for (var imageType in imageTypeData[month]) {
                    if (imageTypes.indexOf(imageType) === -1) {
                        imageTypes.push(imageType);
                    }
                }
            }


            header = header.concat(imageTypes);
            chartDataArray.push(header);


            for (var month in imageTypeData) {
                var row = [month];

                for (var i = 0; i < imageTypes.length; i++) {
                    var imageType = imageTypes[i];
                    var value = imageTypeData[month][imageType] || 0;
                    row.push(value);
                }
                chartDataArray.push(row);
            }


            var data = google.visualization.arrayToDataTable(chartDataArray);

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
                    title: 'Total Cases',
                    minValue: 0,
                    format: '0',
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

            var chart = new google.visualization.ColumnChart(document.getElementById('imagesTypeChart'));
            chart.draw(data, options);
        }




        function drawSpecialtyChart() {
            var specialtyData = @json($specialtyData->toArray());

            if (isAllDataEmpty(specialtyData)) {
                $('#specialtyChart').html('<p>No data available to display.</p>');
                return;
            }

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
                    title: 'Total Cases',
                    minValue: 0,

                    format: '0',
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

        function drawQualityChart() {
            var qualityData = @json($qualityData->toArray());

            if (isAllDataEmpty(qualityData)) {
                $('#qualityChart').html('<p>No data available to display.</p>');
                return;
            }

            var data = google.visualization.arrayToDataTable([
                ['Month',
                    @foreach ($qualityData->first() as $type => $count)
                        '{{ $type }}',
                    @endforeach
                ],
                @foreach ($qualityData as $month => $counts)
                    ['{{ $month }}',
                        @foreach ($counts as $count)
                            {{ $count }},
                        @endforeach
                    ],
                @endforeach
            ]);

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
                    title: 'Total Cases',
                    minValue: 0,

                    format: '0',
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

            var chart = new google.visualization.ColumnChart(document.getElementById('qualityChart'));
            chart.draw(data, options);
        }

        function drawEaseOfDiagnosisChart() {
            var easeOfDiagnosisData = @json($easeOfDiagnosisData->toArray());

            if (isAllDataEmpty(easeOfDiagnosisData)) {
                $('#easeOfDiagnosisChart').html('<p>No data available to display.</p>');
                return;
            }

            var data = google.visualization.arrayToDataTable([
                ['Month',
                    @foreach ($easeOfDiagnosisData->first() as $ease => $count)
                        '{{ $ease }}',
                    @endforeach
                ],
                @foreach ($easeOfDiagnosisData as $month => $counts)
                    ['{{ $month }}',
                        @foreach ($counts as $count)
                            {{ $count }},
                        @endforeach
                    ],
                @endforeach
            ]);

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
                    title: 'Total Cases',
                    minValue: 0,

                    format: '0',
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

            var chart = new google.visualization.ColumnChart(document.getElementById('easeOfDiagnosisChart'));
            chart.draw(data, options);
        }

        function drawCertaintyChart() {
            var certaintyData = @json($certaintyData->toArray());

            if (isAllDataEmpty(certaintyData)) {
                $('#certaintyChart').html('<p>No data available to display.</p>');
                return;
            }

            var data = google.visualization.arrayToDataTable([
                ['Month',
                    @foreach ($certaintyData->first() as $certainty => $count)
                        '{{ $certainty }}',
                    @endforeach
                ],
                @foreach ($certaintyData as $month => $counts)
                    ['{{ $month }}',
                        @foreach ($counts as $count)
                            {{ $count }},
                        @endforeach
                    ],
                @endforeach
            ]);

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
                    title: 'Total Cases',
                    minValue: 0,

                    format: '0',
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

            var chart = new google.visualization.ColumnChart(document.getElementById('certaintyChart'));
            chart.draw(data, options);
        }

        function drawSegmentChart() {
            var segmentData = @json($segmentData->toArray());

            if (isAllDataEmpty(segmentData)) {
                $('#segmentChart').html('<p>No data available to display.</p>');
                return;
            }

            var data = google.visualization.arrayToDataTable([
                ['Month',
                    @foreach ($segmentData->first() as $segment => $count)
                        '{{ $segment }}',
                    @endforeach
                ],
                @foreach ($segmentData as $month => $counts)
                    ['{{ $month }}',
                        @foreach ($counts as $count)
                            {{ $count }},
                        @endforeach
                    ],
                @endforeach
            ]);

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
                    title: 'Total Cases',
                    minValue: 0,

                    format: '0',
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

            var chart = new google.visualization.ColumnChart(document.getElementById('segmentChart'));
            chart.draw(data, options);
        }

        function drawCommentedCasesChart() {
            var commentsCasesData = @json($commentsCasesData->toArray());

            if (isAllDataEmpty(commentsCasesData)) {
                $('#commentedCasesChart').html('<p>No data available to display.</p>');
                return;
            }

            var data = google.visualization.arrayToDataTable([
                ['Month',
                    @foreach ($commentsCasesData->first() as $ethnicity => $count)
                        '{{ $ethnicity }}',
                    @endforeach
                ],
                @foreach ($commentsCasesData as $month => $counts)
                    ['{{ $month }}',
                        @foreach ($counts as $count)
                            {{ $count }},
                        @endforeach
                    ],
                @endforeach
            ]);

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
                    title: 'Total Cases',
                    minValue: 0,

                    format: '0',
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

            var chart = new google.visualization.ColumnChart(document.getElementById('commentedCasesChart'));
            chart.draw(data, options);
        }

        function drawEthnicityChart() {
            var ethnicityData = @json($ethnicityData->toArray());

            if (isAllDataEmpty(ethnicityData)) {
                $('#ethnicityChart').html('<p>No data available to display.</p>');
                return;
            }

            var data = google.visualization.arrayToDataTable([
                ['Month',
                    @foreach ($ethnicityData->first() as $ethnicity => $count)
                        '{{ $ethnicity }}',
                    @endforeach
                ],
                @foreach ($ethnicityData as $month => $counts)
                    ['{{ $month }}',
                        @foreach ($counts as $count)
                            {{ $count }},
                        @endforeach
                    ],
                @endforeach
            ]);

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
                    title: 'Total Cases',
                    minValue: 0,

                    format: '0',
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

            var chart = new google.visualization.ColumnChart(document.getElementById('ethnicityChart'));
            chart.draw(data, options);
        }


        function drawOverallCasesChart() {
            var casesData = @json($casesData->toArray());

            let allZero = Object.values(casesData).every(value => value === 0);

            if (allZero) {
                $('#overallCasesChart').html('<p>No data available to display.</p>');
                return;
            }

            var data = google.visualization.arrayToDataTable([
                ['Month', 'Total Cases'],
                @foreach ($casesData as $month => $total)
                    ['{{ $month }}', {{ $total }}],
                @endforeach
            ]);

            var options = {
                width: 800,
                height: 500,
                hAxis: {
                    title: 'Total Cases',
                    minValue: 0,

                },
                vAxis: {
                    title: 'Month',
                    format: '0',

                },
                legend: {
                    position: 'none',
                },
                chartArea: {
                    width: '70%',
                    height: '70%',
                },
            };

            var chart = new google.visualization.LineChart(document.getElementById('overallCasesChart'));
            chart.draw(data, options);
        }
    </script>
@endpush
