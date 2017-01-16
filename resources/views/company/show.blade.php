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
    function buildTree($id, $relations, $groupsContent)
    {
        if(empty($relations[$id])) {
            return;
        }
        foreach ($relations[$id]  as $item) {

            if(isset($item['isgroup'])) {
                if($item['id'] !== 1) {
                    echo '<li> this is gouprs -  ' . $item['name']. '</li>';
                    if(!empty($groupsContent[$item['id']])) {
                        foreach($groupsContent[$item['id']] as $employee) {
                            if(!empty($employee)) {
                                echo '<ul><li>' .$employee['name']. '</ul></li>';
                            }
                        }
                    }
                return;
                }
            } else {
                if($item['group'] === 1 && $item['relation_id'] === 0)
                    echo '<li> '.  $item['name'] ;

                echo "<ul>";
                    buildTree($item['id'], $relations, $groupsContent);
                echo "</ul>";
            }
            echo ' </li>';
        }
        
    }

?>
    <div class="container">
        <div id="data">
            <ul>
                {{ buildTree(0, $relations, $groupsContent) }}
            </ul>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#data').jstree({

            });
        });
    </script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>--}}
</body>
</html>