<!DOCTYPE html>
<html>
<head>
    <title>Поиск по комментариям</title>
</head>
<body>
<h1>Поиск комментариев</h1>
<form method="GET">
    <input type="text" name="q" placeholder="Введите текст" required>
    <button type="submit">Поиск</button>
</form>

<?php
if (!empty($_GET['q'])) {
    $pdo = new PDO("mysql:host=@Mysql-8.4;dbname=inline;charset=utf8", "root", "");
    $query = '%' . $_GET['q'] . '%';

    $stmt = $pdo->prepare("
        SELECT comments.content, posts.title 
        FROM comments 
        JOIN posts ON comments.post_id = posts.id 
        WHERE comments.content LIKE :query
    ");
    $stmt->execute([':query' => $query]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Результаты поиска:</h2>";
    if ($results) {
        foreach ($results as $row) {
            echo "<div>";
            echo "<strong>Пост:</strong> " . htmlspecialchars($row['title']) . "<br>";
            echo "<strong>Комментарий:</strong> " . htmlspecialchars($row['content']);
            echo "</div><hr>";
        }
    } else {
        echo "Ничего не найдено.";
    }
}
?>
</body>
</html>
