<table dir="rtl">
    <thead>
    <tr style="background-color: burlywood">
        <th>@lang('Name')</th>
        <th>@lang('Email')</th>
        <th>@lang('Phone')</th>
        <th>@lang('Gender')</th>
        <th>@lang('Nationality')</th>
        <th>@lang('Birthdate')</th>
        <th>@lang('Created At')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lists as $list)
        <tr>
            <td>{{ $list->full_name }}</td>
            <td>{{ $list->email }}</td>
            <td>{{ $list->phone }}</td>
            <td>{{ __($list->gender) }}</td>
            <td>{{ $list->country ? $list->country->nationality : "" }}</td>
            <td>{{ $list->birthday }}</td>
            <td>{{ $list->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>