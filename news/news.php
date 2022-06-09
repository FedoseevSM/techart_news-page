<?php

require_once '../include/pdo.php';

$page = isset($_GET[page]) ? $_GET['page']: 1;

// 
function countRows($table){
    global $pdo;
    $rows = $pdo->prepare("SELECT COUNT(*) FROM news");
    $rows->execute();
    return $rows->fetchColumn();
}
//

$limit = 5;
$offset = $limit * ($page - 1);
$totalPages = ceil(countRows('news') / $limit);

// 
function parseNews($table) {
    global $pdo;
    global $limit;
    global $offset;
    $sth = $pdo->prepare("SELECT id, idate, title, announce, content FROM news ORDER BY idate DESC LIMIT $limit OFFSET $offset");
    $sth->execute();
    return $sth->fetchAll();
}
// 

$news = parseNews('news');

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Новости</title>
</head>
<body>
    <header class="header"></header>
    <main class="main">
        <section class="main__content">
            <div class="main__content_inner">
                <!--  -->
                <div class="news">
                    <h1 class="news__head">Новости</h1>
                    <!--  -->
                    <?php foreach ($news as $topic): ?>
                    <div class="news__item">
                        <div class="news__item_title">
                            <time class="news__item_title-time">
                                <?= date('d.m.Y', $topic[idate]) ?>
                            </time>
                            <a href="/news/view.php?id=<?= $topic[id] ?>" class="news__item_title-text">
                                <h2><?= $topic[title] ?></h2>
                            </a>
                        </div>
                        <p class="news__item_text">
                        <?= $topic[announce] ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                    <!--  -->
                    <div class="news__footer">
                        <p class="news__footer_title">Страницы:</p>
                        <div class="news__footer_body">
                            <!--  -->
                            <?php foreach(range(1, $totalPages) as $pagination ): ?>
                            <a href="<?= '?page=' . $pagination ?>" <?php if($_GET['page'] == $pagination) {echo "class='news__footer_body_item-active news__footer_body_item'";} ?> class="news__footer_body_item"><?= $pagination ?></a>
                            <?php endforeach; ?>
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
</html>