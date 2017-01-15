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
    function buildTree($id, $relations)
    {
        if(empty($relations[$id])) {
            return;
        }
        foreach ($relations[$id]  as $item) {
            echo '<li> '. $item['name'] . ' </li>';
            echo "<ul><li>";
                buildTree($item['id'], $relations);
            echo "</li></ul>";
        }
        
    }

?>
    <div class="container">
        <div id="data">
            <ul>             
                {{ buildTree(0, $relations)}}
            </ul>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#data').jstree({

            });
        });
    </script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script> -->
</body>
</html>