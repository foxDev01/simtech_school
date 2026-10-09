<?php
require_once 'connect.php';

/**
 * Экранирует значение для безопасного вывода в HTML.
 */
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// кол во записей на 1 странице
$limit = 4;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}

$number = ($page - 1) * $limit; // с какого номера списка начинать вывод в таблицу

$bid = [];
$stmt = $conn->prepare("SELECT * FROM feedback ORDER BY id ASC LIMIT ?, ?");
if ($stmt !== false) {
    $stmt->bind_param('ii', $number, $limit);
    $stmt->execute();
    $bid = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

$total_record = (int) $conn->query("SELECT COUNT(*) FROM feedback")->fetch_row()[0];
$total_page   = max(1, (int) ceil($total_record / $limit));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
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
        <tbody>
            <?php foreach ($bid as $row): ?>
                <tr>
                    <td><?= e($row['id']) ?></td>
                    <td><?= e($row['fname']) ?></td>
                    <td><?= e($row['lname']) ?></td>
                    <td><?= e($row['email']) ?></td>
                    <td><?= e($row['tel']) ?></td>
                    <td><?= e($row['tim']) ?></td>
                    <td><?= e($row['occasion']) ?></td>
                    <td><?php if ($row['files'] !== ''): ?><a href="upload/<?= e(rawurlencode($row['files'])) ?>"><?= e($row['files']) ?></a><?php endif; ?></td>
                    <td><?= e($row['msg']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php if ($total_page > 1): ?>
    <nav>
        <?php if ($page > 1): ?>
            <a href="table.php?page=<?= $page - 1 ?>" class="btn btn-danger">&lt;&lt;</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_page; $i++): ?>
            <a href="table.php?page=<?= $i ?>" class="btn btn-<?= $i === $page ? 'secondary' : 'primary' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_page): ?>
            <a href="table.php?page=<?= $page + 1 ?>" class="btn btn-danger">&gt;&gt;</a>
        <?php endif; ?>
    </nav>
<?php endif; ?>

<div><a href="form.php" class="btn btn-link" role="button">Назад к форме</a></div>

</body>
</html>
