<?php

require_once '../include/pdo.php';

$newsId = isset($_GET[id]) ? $_GET['id']: 1;

// 
function parseNewsView($table) {
    global $pdo;
    global $newsId;
    $sth = $pdo->prepare("SELECT id, title, content FROM news WHERE id = $newsId");
    $sth->execute();
    return $sth->fetchAll();
}
// 

$newsView = parseNewsView('news');

?>
<?php foreach ($newsView as $topic): ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title><?= $topic[title] ?> - Новости</title>
</head>
<body>
    <header class="header"></header>
    <main class="main">
        <section class="main__content">
            <div class="main__content_inner">
                <!--  -->
                <div class="news-view">
                    <h1 class="news-view__head"><?= $topic[title] ?></h1>
                    <!--  -->
                    <div class="news-view__item">
                        <div class="news-view__item_text">
                        <?= $topic[content] ?>
                        </div>
                    </div>
                    <!--  -->
                    <div class="news-view__footer">
                        <div class="news-view_footer_body">
                            <!--  -->
                            <a href="/news/news.php" class="news-view_footer_body_item">Все новости >></a>
                            <!--  -->
                        </div>
                    </div>
                </div>
                <!--  -->
            </div>
        </section>
    </main>
    <footer class="footer"></footer>
</body>
</html><?php endforeach; ?>