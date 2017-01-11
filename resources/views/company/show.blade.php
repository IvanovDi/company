<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
<?php
    function hasRelations($relations, $name, $groups)
    {
        foreach ($relations[$name] as $employee) {
            if($employee instanceof App\Employee) {
                $name = $employee->first_name;
                echo "<li>" . $employee->first_name . ' ' . $employee->last_name;
                if (!empty($relations[$name])) {
                    echo '<ul>';
                    hasRelations($relations, $name, $groups);
                    echo '</ul>';
                    echo '</li>';
                }
            }
            if(!empty($employee[0])){
                foreach($employee as $empl) {
                    echo "<li>" . $empl->name;
                    $name = $empl->name;
                    foreach($empl->employees as $result) {
                        echo "<ul><li>" . $result->first_name . "</li></ul>";
                    }
//                    if (!empty($relations[$name])) {
//                        echo '<ul>';
//                        hasRelations($relations, $name, $groups);
//                        echo '</ul>';
//                        echo '</li>';
//                    }
                }

            }
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
                            <li>group - {!! $item->group->name ? $item->group->name : " " !!}</li>
                            <li>position - {!! $item->positions[0]->name !!}</li>
                            @if($relations[$item->first_name])
                                <li>
                                    Relation
                                    <ul>
                                        {{ hasRelations($relations, $item->first_name, $groups) }}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
</body>
</html>