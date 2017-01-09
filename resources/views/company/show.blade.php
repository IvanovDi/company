<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/vakata-jstree-9770c67/dist/themes/default/style.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
<?php
function hasRelations($relations, $name)
{
    foreach ($relations[$name] as $employee) {
        echo "<li>" . $employee;
        if ($relations[$employee]) {
            echo '<ul>';
            hasRelations($relations, $employee);
            echo '</ul>';
        }
        echo '</li>';
    }
}

?>
    <div class="container">
        <div id="data">
            <ul>
                @foreach($data as $item)
                    @if($item->relation === null)
                    <li>
                        {!! $item->first_name . ' ' . $item->last_name!!}
                        <ul>
                            <li>{!! $item->group->name !!}</li>
                            <li>{!! $item->positions[0]->name !!}</li>

                            @if($relations[$item->first_name])
                                <li>
                                    Relation
                                    <ul>
                                        {{ hasRelations($relations, $item->first_name) }}
                                        {{--@foreach($relations[$item->first_name] as $employee)--}}
                                            {{--<li>--}}
                                                {{--{!! $employee !!}--}}
                                                {{--@if($relations[$employee])--}}
                                                    {{--<ul>--}}
                                                        {{--@foreach($relations[$employee] as $employee)--}}
                                                            {{--<li>{!! $employee !!}</li>--}}
                                                        {{--@endforeach--}}
                                                    {{--</ul>--}}
                                                {{--@endif--}}
                                            {{--</li>--}}
                                        {{--@endforeach--}}
                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#data').jstree({

            });
        });
    </script>
    <script src="/css/vakata-jstree-9770c67/dist/jstree.min.js"></script>
</body>
</html>