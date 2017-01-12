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
    function hasRelations($relations, $name)
    {
        foreach ($relations[$name] as $employee) {
            $tmp_employee = '';
            if($employee instanceof App\Employee) {
                $name = $employee->first_name;
                if ($employee->team_lead) {
                    $team_lead = '<span style="color:red;"> team lead </span>';
                } else {
                    $team_lead = ' ';
                }
                echo "<li> people - " . $employee->first_name . ' ' . $employee->last_name . $team_lead;
                if (!empty($relations[$name])) {
                    echo '<ul>';
                    hasRelations($relations, $name);
                    echo '</ul></li>';
                }
            }
            $tmp_employee = $relations[$name];
            if(!empty($employee[0])){
                foreach($employee as $empl) {
                    echo "<li> group - " . $empl->name;
                    $name_group = $empl->name;

                    foreach($empl->employees as $result) {
                        if ($result->team_lead) {
                            $team_lead = '<span style="color:red;"> team lead </span>';
                        } else {
                            $team_lead = ' ';
                        }
                        echo "<ul><li> people - " . $result->first_name . ' ' . $team_lead . "</li></ul>";
                    }
                    if (!empty($tmp_employee[$name_group])) {
                        echo '<ul>';
                        dd($tmp_employee[$name_group]);
                        hasRelations($tmp_employee[$name_group], $name);
                        echo '</ul></li>';
                    }
                }

            }
        }
    }
?>
    <div class="container">
        <div id="data">
            <ul>
                @foreach($data as $item)
                    @if($item->group->name === "" && $item->relation === null)
                        @if ($item->team_lead)
                        <?php $team_lead = '<span style="color:red;"> team lead </span>'; ?>
                        @else
                            <?php $team_lead = ' '; ?>
                        @endif
                    <li>
                        {!! $item->first_name . ' ' . $item->last_name . '('. $item->positions[0]->name .')' . $team_lead!!}
                        <ul>
                                @if($relations[$item->first_name])
                                {{ hasRelations($relations, $item->first_name, $groups) }}
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