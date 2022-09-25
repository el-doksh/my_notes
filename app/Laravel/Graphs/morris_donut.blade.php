<div class="card custom-card">
    <div class="card-body">
        <div>
            <h6 class="main-content-label mb-1">{{$title}}</h6>
            <p class="text-muted card-sub-title">{{$description}}</p>
        </div>
        <div class="morris-wrapper-demo" id="donute-{{$name}}"></div>
    </div>
</div>
@push('scripts')
    <!-- Internal Morris Chart js-->
    <script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/morris.js/morris.min.js') }}"></script>
    <script>
        $( function() {
            let data = [];
            let colors = [];
            const moris_data = JSON.parse(@json($data));
            $.each(moris_data, function(key, value) {
                data.push({
                    'label' : value.label,
                    'value' : value.value
                })
                colors.push(value.color);
            })
            new Morris.Donut({
                element: 'donute-{{$name}}',
                labelColor: '#77778e',
                resize: true,
                data: data,
                colors:colors
            });
        })
    </script>
@endpush
@push('css')
    <!-- Internal Morrirs Chart css-->
    <link href="{{ asset('assets/plugins/morris.js/morris.css') }}" rel="stylesheet">
@endpush