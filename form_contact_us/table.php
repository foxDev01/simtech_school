 <?php  require_once 'connect.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans&display=swap" rel="stylesheet">  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="table.css">
    <title>Document</title>
</head>
<body>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>id</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Время</th>
                <th>Повод</th>
                <th>Файл</th>
                <th>Письмо</th>
            </tr>
        </thead>

            <?php 
             // кол во записей на 1 странице 
            if ($_GET['page']) {
                    $page = $_GET['page'];
                  } else {
                    $page = 1;
                  }
            $limit = 4;
            $number = ($page-1)* $limit;// с какого номера списка начинать вывод в таблицу
            
            $bid = mysqli_query($conn,"SELECT * from feedback LIMIT $number, $limit");
            $bid = mysqli_fetch_all($bid);
            foreach($bid as $bid){ ?>
                <tr>
                    <td><?=$bid[0]?></td>
                    <td><?=$bid[1]?></td>
                    <td><?=$bid[2]?></td>
                    <td><?=$bid[3]?></td>
                    <td><?=$bid[4]?></td>
                    <td><?=$bid[5]?></td>
                    <td><?=$bid[6]?></td>
                    <td> <a href="upload/<?=$bid[7]?>"><?=$bid[7]?></a></td>
                    <td><?=$bid[8]?></td>
                </tr>
                <?php
            }
            ?>
    </table>

<?php


$pr_query = "select * from feedback ";
$pr_result = mysqli_query($conn,$pr_query);
$total_record = mysqli_num_rows($pr_result );

$total_page = ceil($total_record/$limit);

                if($page>1)
                {
                    echo "<a href='table.php?page=".($page-1)."' class='btn btn-danger'><<</a> ";
                }


    for($i = 1;$i < $total_page; $i++)
                {
                    echo "<a href='table.php?page=".$i."' class='btn btn-primary'>$i</a>";
                }

                if($i>$page)
                {
                    echo " <a href='table.php?page=".($page+1)."' class='btn btn-danger'>>></a>";
                }
?>
<div><a href="form.php" class="btn btn-link" role="button" >Назад к форме</a></div>

            
</body>
</html>