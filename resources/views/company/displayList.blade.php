@foreach($data as $employeeId => $employeeData)
    <ul>
        <li>
            {!! $employeeData['name'] !!}
            @if($employeeData['team_lead'] === 1)
                <span style="color: red;">Team Lead</span>
            @endif
            @if (isset($employeeData['groups']) && $employeeData['groups'])
                <ul>
                    <li>
                        Groups
                        <ul>
                            @foreach($employeeData['groups'] as $groupId => $groupData)
                                <li>{!! $groupData['name'] !!}
                                @if (isset($groupData['employees']) && $groupData['employees'])
                                    @include('company.displayList', [
                                       'data' => $employeeData['child'],
                                    ])
                                @endif
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            @endif
            @if ($employeeData['child'])
                @include('company.displayList', [
                    'data' => $employeeData['child'],
                ])
            @endif
        </li>
    </ul>
@endforeach
