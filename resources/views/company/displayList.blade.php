@foreach($data as $employeeId => $employeeData)
    <ul>
        <li>
            {!! $employeeData['name'] !!}
            @if ($employeeData['child'])
                @include('company.displayList', [
                    'data' => $employeeData['child'],
                ])
            @endif
            {{--@if($employeeData['groups'])--}}
                {{--@include('company.displayList', [--}}
                    {{--'data' => $employeeData['groups']--}}
                {{--])--}}
            {{--@endif--}}
        </li>
    </ul>
@endforeach
