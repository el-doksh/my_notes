@extends('admin.layouts.master')
@section('title')@lang('Dashboard') @endsection
@section('PageContent')

@section('buttons')
    <h2 class="main-content-title tx-24 mg-b-5">@lang('Welcome') {{auth()->user()->name}} </h2>
    <p class="main-notification-text"> {{ Auth::user()->roles->first() ? __(Auth::user()->roles->first()->name) : "" }}</p>
@endsection
@push('css')
<style>
    .select2-container .select2-selection--single{
        width: 180px; !important
    }
</style>
@endpush
@push('scripts')
<!-- Internal Chartjs charts js-->
<script src="{{asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
@endpush
    <div class="row row-sm">
        
        @canAny(['statistics.users_count', 'statistics.shares_count'])
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                @canAny('statistics.users_count')
                <div class="col-lg-6 col-md-6">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="card-item">
                                <div class="card-item-icon card-icon">
                                    <i class="ti-user sidemenu-icon menu-icon "></i>
                                </div>
                                <div class="card-item-title mb-2">
                                    <label class="main-content-label tx-13 font-weight-bold mb-1">@lang('Registed users count')</label>
                                </div>
                                <div class="card-item-body">
                                    <div class="card-item-stat">
                                        <h4 class="font-weight-bold">{{$users_count}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcanAny
                @canAny('statistics.shares_count')
                <div class="col-lg-6 col-md-6">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="card-item">
                                <div class="card-item-icon card-icon">
                                    <i class="ti-share sidemenu-icon menu-icon "></i>
                                </div>
                                <div class="card-item-title mb-2">
                                    <label class="main-content-label tx-13 font-weight-bold mb-1">@lang('App shares count')</label>
                                </div>
                                <div class="card-item-body">
                                    <div class="card-item-stat">
                                        <h4 class="font-weight-bold">{{$shares_count}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcanAny
            </div>
        </div>
        @endcanAny
        @canAny('statistics.top_users_shares')
        <div class="col-lg-6 col-md-12">
            <div class="card custom-card overflow-hidden">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <div class="m-0">
                                        <h6 class="main-content-label mb-1">@lang('Top users who shared the Application')</h6>
                                    </div>
                                    <div class="m-0">
                                        <select class="form-control select2-with-search" id="year">
                                            @foreach ( range(\Carbon\Carbon::now()->year, 2010); as $year)                                    
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <div class="chartjs-wrapper-demo">
                                    <canvas id="chartLine"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
        </div>
        @endcanAny
        @canAny('statistics.top_5_maps_views')
        <div class="col-lg-6 col-md-12">
            <div class="card custom-card overflow-hidden">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <div class="m-0">
                                        <h6 class="main-content-label mb-1">@lang('Top 10 maps viewed / shared & added to favourites')
                                        </h6>
                                    </div>
                                    <div class="m-0">
                                        <select class="form-control select2-with-search" id="country_id">
                                            <option value="0">@lang('All countries')</option>
                                            @foreach ($countries as $country)                                    
                                                <option value="{{$country->id}}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-5">
                                <div class="chartjs-wrapper-demo">
                                    <canvas id="chartBar"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
        </div>
        @endcanAny
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                @foreach ($statistic as $item)
                    @canAny(['statistics.'.$item['can']])
                    <div class="col-lg-4 col-md-6">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="card-item">
                                    <div class="card-item-icon card-icon">
                                        <i class="{{$item['icon']}} sidemenu-icon menu-icon "></i>
                                    </div>
                                    <div class="card-item-title mb-2">
                                        <label class="main-content-label tx-13 font-weight-bold mb-1">{{$item['title']}}</label>
                                    </div>
                                    <div class="card-item-body">
                                        <div class="card-item-stat">
                                            <h4 class="font-weight-bold">{{$item['count']}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcanAny
                @endforeach
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    window.onload = function()
    {
        getMapsData()
        getUsersData()
    };

    $('#country_id').change(function(){
        getMapsData(this.value);
    });

    async function getMapsData(countryId = null)
    {
        var xLine = [];
        var yLine = [
            {
                'label': "@lang('Views count')",
                'color' : '#6259ca',
                'value': [],
            },
            {
                'label': "@lang('Favourites count')",
                'color' : '#1d212f',
                'value': [],
            },
            {
                'label': "@lang('Shares count')",
                'color' : '#ca2d1e',
                'value': [],
            }
        ];

        await $.ajax({
            url: "{{ route('admin.home.maps_statistics') }}",
            method: "POST",
            headers : {
                'hasNoPermissions' : true,
            },
            data:{
                _token : "{{ csrf_token() }}",
                country_id: countryId
            },
            success:function(response) {
                if(response.success ) {
                    $.each(response.maps, function (key, value) {
                        xLine.push(value.name)
                        yLine[0].value.push(value.views)
                        yLine[1].value.push(value.count)
                        yLine[2].value.push(value.shares)
                    });
                    renderBarChart(xLine, yLine)
                }
            },
        });
    }
    
    var barChart = new Chart(document.getElementById('chartBar'), {
        type: 'bar',
        data: {},
        options: {}
    });

    function renderBarChart(xLine , yLine)
    {
        var dataset = [];
        yLine.forEach(( key, value ) => {
            dataset.push({
				label: key.label,
				data: key.value,
				borderColor: key.color,
				borderWidth: "0",
				backgroundColor: key.color,
            })
        });
        barChart.data = {
            labels: xLine,
            datasets:dataset
        }
        barChart.options = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: "#77778e",
                    },
                    gridLines: {
                        color: 'rgba(119, 119, 142, 0.2)'
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontColor: "#77778e",
                    },
                    gridLines: {
                        color: 'rgba(119, 119, 142, 0.2)'
                    },
                }]
            },
            legend: {
                labels: {
                    fontColor: "#77778e"
                },
            },
        }
        barChart.update();
    }
    
    $('#year').change(function(){
        getUsersData(this.value);
    });
    
    async function getUsersData(year = null)
    {
        var xLine = ["@lang('January')", "@lang('Feburary')", "@lang('March')",
                        "@lang('April')", "@lang('May')", "@lang('June')",
                        "@lang('July')", "@lang('August')", "@lang('September')",
                        "@lang('October')", "@lang('November')", "@lang('December')"];
        var yLine = [];
        await $.ajax({
            url: "{{ route('admin.home.users_statistics') }}",
            method: "POST",
            headers : {
                'hasNoPermissions' : true,
            },
            data:{
                _token : "{{ csrf_token()  }}",
                year: year
            },
            success:function(response) {
                if(response.success ) {
                    for ( let month = 1; month <= 12; month++ ) {
                        const users = response.users;
                        let obj = users.find(o => o.month === month);
                        if (obj == undefined) {
                            yLine.push(0)
                        } else {
                            yLine.push(obj.count)
                        }
                    }
                    renderLineChart(xLine, yLine)
                }
            },
        });
    }

    function renderLineChart(xLine, yLine)
    {
        var ctx = document.getElementById('chartLine').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: xLine,
                datasets: [{
                    label: "{{__('Shares count')}}",
                    data: yLine,
                    borderWidth: 2,
                    backgroundColor: 'transparent',
                    borderColor: '#6259ca',
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointRadius: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        ticks: {
                            fontColor: "#77778e",
                            },
                        display: true,
                        gridLines: {
                            color: 'rgba(119, 119, 142, 0.2)'
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            fontColor: "#77778e",
                            },
                        display: true,
                        gridLines: {
                            color: 'rgba(119, 119, 142, 0.2)'
                        },
                        scaleLabel: {
                            display: false,
                            labelString: 'Thousands',
                            fontColor: 'rgba(119, 119, 142, 0.2)'
                        }
                    }]
                },
                legend: {
                    labels: {
                        fontColor: "#77778e"
                    },
                },
            }
        });
    }
</script>
@endpush