<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
                    <label for="position">Position</label><br>
                    <input type="text" name="position" id="position"><br>
                    <label for="relation">Relation</label><br>
                    <input type="text" id="relation" name="relation"><br>
                    <label for="group">Select Group</label><br>
                    <select name="group"  id="group">
                        <option value="foo">foo</option>
                        <option value="ree">ree</option>
                    </select><br>
                    <input type="submit" name="submit" value="add new">
                </form>
            </div>
            <div class="col-md-6">
                <h2>show</h2>
                <form action="{!! route('employee.show', 1) !!}" method="get">
                    <input type="submit" name="send" value="show">
                </form>
            </div>
        </div>
    </div>
</body>
</html>