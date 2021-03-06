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
<div class="container">
    <div id="data">
        <ul>
            @foreach($data as $item)
                <li>
                    {!! $item->name!!}
                    <ul>
                        @foreach($item->employees as $employee)
                            <li>{!! $employee->first_name . ' ' . $employee->last_name!!}</li>
                        @endforeach
                    </ul>
                </li>
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