<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/app.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>add new Employee</h1>
                <form action="{!! route('employee.store') !!}" method="post">
                    {{csrf_field()}}
                    <label for="first_name">First Name</label><br>
                    <input type="text" id="first_name" name="first_name"><br>
                    <label for="last_name">Last Name</label><br>
                    <input type="text" id="last_name" name="last_name"><br>
                    <label for="relation">Relation</label><br>
                    <select name="relation"  id="relation">
                        <option selected value=""></option>
                        @foreach($relations as $relation)
                            <option name="{!! $relation->first_name . ' ' . $relation->last_name !!}">{!! $relation->first_name . ' ' . $relation->last_name !!} </option>
                        @endforeach
                    </select><br>

                    <label for="position">Position</label><br>
                     <select name="position"  id="position">
                        @foreach($positions as $position)
                             <option name="{!! $position->name !!}">{!! $position->name !!} </option>
                        @endforeach
                    </select><br>
                    <label for="group">Select Group</label><br>
                    <select name="group"  id="group">
                        @foreach($groups as $group)
                            <option name="{!! $group->name !!}">{!! $group->name !!}</option>
                        @endforeach
                    </select><br><br>
                    <input type="submit" name="submit" value="add new">
                </form>
            </div>
            <div class="col-md-6">
                <h2>show Employee</h2>
                <form action="{!! route('employee.show', 1) !!}" method="get">
                    <input type="submit" name="send" value="show">
                </form>
                <h2>show Group</h2>
                <form action="{!! route('group.show', 1) !!}" method="get">
                    <input type="submit" name="send" value="show">
                </form>
            </div>
        </div>
            <div class="row">
                <div class="col-md-6">
                    <h2>add new Position</h2>
                    <form action="{!! route('position.store')!!}" method="post">
                        {{csrf_field()}}
                        <label for="position">title position</label>
                        <input type="text" id="position" name="position_name">
                        <input type="submit" value="add">
                    </form>
                </div>
                <div class="col-md-6">
                    <h2>add new Group</h2>
                    <form action="{!! route('group.store')!!}" method="post">
                        {{csrf_field()}}
                        <label for="group">title group</label>
                        <br><input type="text" id="group" name="group_name"><br>
                        <label for="relation">Relation</label><br>
                        <select name="relation"  id="relation">
                            <option selected value=""></option>
                            @foreach($relations as $relation)
                                <option name="{!! $relation->first_name . ' ' . $relation->last_name !!}">{!! $relation->first_name . ' ' . $relation->last_name !!} </option>
                            @endforeach
                        </select><br>
                        <input type="submit" value="add">
                    </form>
                </div>
            </div>


    </div>
</body>
</html>