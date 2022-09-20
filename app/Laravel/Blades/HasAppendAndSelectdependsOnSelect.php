@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')

<div class="row row-sm">
    <div class="col-lg-12 col-md-12">
        <div class="card custom-card">
            @if(isset($question))
                <form action="{{ route('admin.questions.update', $question) }}" method="post" enctype="multipart/form-data">
                @method('PUT')
            @else 
                <form action="{{ route('admin.questions.store') }}" method="post" enctype="multipart/form-data">
            @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                @include('admin.component.inc.lang', [
                                    'data' => $localeFields,
                                    'model' => isset($question) ? $question : null,
                                    'group_key' => 'questions'
                                ])
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category_id">@lang('Category') <span class="tx-danger">*</span></label>
                                <select name="category_id[]" id="category_id" class="form-control select2">
                                    <option value="-1" disabled selected> @lang('Choose')</option>
                                    @foreach ($main_categories as $main_category)
                                        <option value="{{ $main_category->id }}"
                                            @if(old('category_id') == $main_category->id || isset($question) && in_array($main_category->id, $question->categories->pluck('id')->toArray()) ) selected @endif
                                        >{{ $main_category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sub_category_id">@lang('Stage') <span class="tx-danger">*</span></label>
                                <select name="category_id[]" id="sub_category_id" class="form-control select2">
                                    <option value="-1" disabled selected> @lang('Choose')</option>
                                </select>
                                @error('sub_category_id')
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="level_id">@lang('Level') <span class="tx-danger">*</span></label>
                                <select name="level_id" id="level_id" class="form-control select2">
                                    <option value="-1" disabled selected> @lang('Choose')</option>
                                </select>
                                @error('level_id')
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="answer_type">@lang('Answer Type') <span class="tx-danger">*</span></label>
                                <select name="answer_type" id="answer_type" class="form-control select2">
                                    @foreach ($answer_types as $answer_type)
                                        <option value="{{$answer_type}}"
                                            @if(old('answer_type') == $answer_type || isset($question) && $question->answer_type == $answer_type) selected @endif
                                        >@lang($answer_type)</option>
                                    @endforeach
                                </select>
                                @error('answer_type')
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            @include('admin.component.form_fields.input', [
                                'type'  => 'number',
                                'label' => 'Time to answer question',
                                'placeholder' => 0,
                                'min' => 0,
                                'name'  => 'time_of_answer_question',
                                'value' => old('time_of_answer_question') ?? (isset($question) ? $question->time_of_answer_question : config('asga.time_of_answer_question'))
                            ])
                        </div>
                        <div class="col-md-12">
                            @include('admin.component.form_fields.image', [
                                'label' => 'Image',
                                'name' => 'image',
                                'value' => old('image') ?? (isset($question) ? $question->image : null)
                            ])
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <h4 class="text-center mb-3 ">@lang('Answers') </h4>
                            <div class="answers-list">
                                @if(isset($question) && count($question->answers) > 0)
                                    @foreach ($question->answers as $answer)
                                        @include('admin.pages.questions.answers', [
                                            'key' => $loop->index,
                                            'model' => $answer,
                                        ])
                                    @endforeach
                                @else
                                    @include('admin.pages.questions.answers', [
                                        'key' => 0
                                    ])
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-warning" onclick="AddAnswer()">
                                <i class="la la-plus"></i> 
                                @lang('Add Answer')
                            </button>
                            <div id="deleted_answers_ids"></div>
                            @error('answers')
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-5">
                            @include('admin.component.form_fields.switch', [
                                'label' => 'Public',
                                'name' => 'public',
                                'value' => old('public') ?? (isset($question) ? $question->public : 0)
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-footer mb-1">
                    @csrf
                    <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                    <a href="{{ route('admin.questions.index')}}" class="btn btn-danger">@lang('Cancel')</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>

    var current_level_id = "{{isset($question) && $question->levels->first() ? $question->levels->first()->id : null }}";

    $('#category_id').change(function(){
        category_subs();
    });
    $('#sub_category_id').change(function(){

        get_levels(current_level_id);
    });
    
    async function category_subs(sub_category_id = null)
    {
        $.ajax({
            method : "GET",
            url : "{{ route('admin.categories.subs') }}",
            data : {
                category_id: $('#category_id').val(),
            },
            success: function(response){
                if( response.success ) {
                    $('#sub_category_id').empty();
                    $('#sub_category_id').append(`
                        <option disabled selected value="-1">@lang('Choose')</option>
                    `)
                    $.each(response.data, function(key, value){
                        $('#sub_category_id').append(`
                            <option value="${value.id}">${value.name}</option>
                        `);
                    });
                    if(sub_category_id) {
                        $('#sub_category_id').val(sub_category_id).change();
                    }
                }
            }
        })
    }

    async function get_levels(level_id = null)
    {
        $.ajax({
            method : "GET",
            url : "{{ route('admin.categories.levels') }}",
            data : {
                category_id: $('#sub_category_id').val(),
            },
            success: function(response){
                if( response.success ) {
                    $('#level_id').empty();
                    $('#level_id').append(`
                        <option disabled selected value="-1">@lang('Choose')</option>
                    `)
                    $.each(response.data, function(key, value){
                        $('#level_id').append(`
                            <option value="${value.id}">${value.name}</option>
                        `);
                    });
                    if(level_id) {
                        $('#level_id').val(level_id).change();
                    }
                }
            }
        })
    }

    var answersCount = "{{isset($question) ? $question->answers->count() : 1}}";
    function AddAnswer()
    {
        $.ajax({
            method : "GET",
            url : "{{ route('admin.questions.add_answer') }}",
            data : {
                question_id: $('#question_id').val(),
                key: answersCount,
            },
            beforeSend: function(){
                $('.answers-list').append(`
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                `);
            },
            success: function(response){
                if( response.success ) {
                    $('.answers-list').append(response.data);
                }
                answersCount++;
                $('.spinner-border').remove();
            },
            completed:function(){
                $('.spinner-border').remove();
            }
        })
    }

    function deleteAnswer(id)
    {
        let answerId = $('#answers_id_'+id).val();
        if(answerId != undefined) {
            $('#deleted_answers_ids').append(`
                <input type="hidden" name="deleted_answers[]" value="${answerId}">
            `);
        }
        $('#answer_div_'+id).remove();
    }

</script>
@if( old('level_id') )
<script>
    get_levels("{{old('level_id')}}")
</script>
@elseif( isset($question) )
<script>
    let sub_category_id = "{{ $question->sub_categories->first() ? $question->sub_categories->first()->id : null }}";
    category_subs(sub_category_id);
</script>
@endif
@endpush