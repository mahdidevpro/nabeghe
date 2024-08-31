<?php

include ("database/pdo_connection.php");

$max_views = 0;
$max_product = null;

$select = $coon->prepare('SELECT * FROM article  ORDER BY date ASC');
$select->execute();
$articles = $select->fetchAll(PDO::FETCH_ASSOC);


function limit_words($string, $word_limit)
{
    $words = explode(" ", $string);
    return implode(" ", array_splice($words, 0, $word_limit));
}

$writer = $coon->prepare("SELECT * FROM  writer");
$writer->execute();

$writers = $writer->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg" />
    <link rel="stylesheet" href="assets/css/dependencies/swiper-bundle.min.css" />
    <link rel="stylesheet" href="assets/css/dependencies/plyr.min.css" />
    <link rel="stylesheet" href="assets/css/dependencies/fancybox.min.css" />
    <link rel="stylesheet" href="assets/css/fonts.css" />
    <link rel="stylesheet" href="assets/css/app.css" />
    <title>قالب آموزشی نابغه - جزئیات دوره</title>
</head>

<body>

    <div class="flex flex-col min-h-screen bg-background">
        <header class="bg-background/80 backdrop-blur-xl border-b border-border sticky top-0 z-30"
            x-data="{ offcanvasOpen: false, openSearchBox: false }">
            <?php
            include ("navbar.php");
            ?>

        </header>

        <main class="flex-auto py-5">
            <div class="max-w-7xl space-y-14 px-4 mx-auto">
                <div class="flex md:flex-nowrap flex-wrap items-start gap-5">
                    <div class="md:w-8/12 w-full">
                        <?php foreach ($articles as $artic): ?>
                            <article style="margin-top: 20px;"
                                class="bg-secondary rounded-2xl flex flex-col-reverse md:flex-row p-4 gap-4 text-h7 items-center mb-4">
                                <div class="flex flex-col gap-3 md:w-1/2">
                                    <h2 class="font-bold text-sm">
                                        <a href="<?= base_url ?>article-detail.php?id=<?= $artic['id'] ?>"
                                            class="line-clamp-1 text-foreground transition-colors hover:text-primary px-4">
                                            <?= $artic['title'] ?>
                                        </a>
                                    </h2>
                                    <div class="icons sm:hidden flex gap-2 text-xs items-center px-4">
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                                viewBox="0 0 19 19" fill="none">
                                                <circle cx="9.91602" cy="4.58398" r="3" fill="#464646"></circle>
                                                <path
                                                    d="M15.916 13.209C15.916 15.0729 15.916 16.584 9.91602 16.584C3.91602 16.584 3.91602 15.0729 3.91602 13.209C3.91602 11.345 6.60231 9.83398 9.91602 9.83398C13.2297 9.83398 15.916 11.345 15.916 13.209Z"
                                                    fill="#464646"></path>
                                            </svg>
                                            <?php foreach ($writers as $writer) {
                                                if ($artic['writer'] == $writer['id']) { ?>
                                                    <span class="line-clamp-1 text-foreground transition-colors hover:text-primary">
                                                        <?= $writer['username']; ?>
                                                    </span>
                                                <?php }
                                            } ?>
                                        </div>
                                        <div class="d_dot"></div>
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                                viewBox="0 0 19 19" fill="none">
                                                <path
                                                    d="M7.025 2.51852C7.025 2.23215 6.78995 2 6.5 2C6.21005 2 5.975 2.23215 5.975 2.51852V3.61035C4.96747 3.69003 4.30604 3.88559 3.8201 4.36553C3.33416 4.84547 3.13616 5.49873 3.05548 6.49383H16.9445C16.8638 5.49873 16.6658 4.84547 16.1799 4.36553C15.694 3.88559 15.0325 3.69003 14.025 3.61035V2.51852C14.025 2.23215 13.7899 2 13.5 2C13.2101 2 12.975 2.23215 12.975 2.51852V3.56448C12.5093 3.55556 11.9873 3.55556 11.4 3.55556H8.6C8.01268 3.55556 7.49069 3.55556 7.025 3.56448V2.51852Z"
                                                    fill="#464646"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3 9.08642C3 8.50635 3 7.9908 3.00903 7.53086H16.991C17 7.9908 17 8.50635 17 9.08642V10.4691C17 13.0764 17 14.38 16.1799 15.19C15.3598 16 14.0399 16 11.4 16H8.6C5.96013 16 4.6402 16 3.8201 15.19C3 14.38 3 13.0764 3 10.4691V9.08642ZM13.5 10.4691C13.8866 10.4691 14.2 10.1596 14.2 9.77778C14.2 9.39595 13.8866 9.08642 13.5 9.08642C13.1134 9.08642 12.8 9.39595 12.8 9.77778C12.8 10.1596 13.1134 10.4691 13.5 10.4691ZM13.5 13.2346C13.8866 13.2346 14.2 12.925 14.2 12.5432C14.2 12.1614 13.8866 11.8519 13.5 11.8519C13.1134 11.8519 12.8 12.1614 12.8 12.5432C12.8 12.925 13.1134 13.2346 13.5 13.2346ZM10.7 9.77778C10.7 10.1596 10.3866 10.4691 10 10.4691C9.6134 10.4691 9.3 10.1596 9.3 9.77778C9.3 9.39595 9.6134 9.08642 10 9.08642C10.3866 9.08642 10.7 9.39595 10.7 9.77778ZM10.7 12.5432C10.7 12.925 10.3866 13.2346 10 13.2346C9.6134 13.2346 9.3 12.925 9.3 12.5432C9.3 12.1614 9.6134 11.8519 10 11.8519C10.3866 11.8519 10.7 12.1614 10.7 12.5432ZM6.5 10.4691C6.8866 10.4691 7.2 10.1596 7.2 9.77778C7.2 9.39595 6.8866 9.08642 6.5 9.08642C6.1134 9.08642 5.8 9.39595 5.8 9.77778C5.8 10.1596 6.1134 10.4691 6.5 10.4691ZM6.5 13.2346C6.8866 13.2346 7.2 12.925 7.2 12.5432C7.2 12.1614 6.8866 11.8519 6.5 11.8519C6.1134 11.8519 5.8 12.1614 5.8 12.5432C5.8 12.925 6.1134 13.2346 6.5 13.2346Z"
                                                    fill="#464646"></path>
                                            </svg>
                                            <span class="line-clamp-1 text-foreground transition-colors hover:text-primary">
                                                <?= $artic['date'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    <p class="hidden md:block text-sm px-4 line-clamp-1 text-foreground transition-colors">
                                        <?php
                                        $content = $artic['caption'];
                                        echo limit_words($content, 15) . " ...";
                                        ?>
                                    </p>
                                </div>
                                <a href="http://localhost/nabeghe/article-detail.php?id=758"
                                    class="min-w-[310px] sm:min-w-[130px] flex md:w-1/2 px-4">
                                    <img alt="<?= $artic['title'] ?>" style="max-width: 390px;" loading="eager"
                                        class="rounded-3xl w-full max-h-[140px] sm:h-[130px]" src="<?= $artic['image'] ?>">
                                </a>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <div class="md:w-4/12 w-full md:sticky md:top-24 space-y-8">
                        <div class="bg-gradient-to-b from-secondary to-background rounded-2xl px-5 pb-5">
                            <div class="bg-background rounded-b-3xl space-y-2 p-5 mb-5">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-1">
                                        <div class="w-1 h-1 bg-foreground rounded-full">
                                        </div>
                                        <div class="w-2 h-2 bg-foreground rounded-full">
                                        </div>
                                    </div>
                                    <div class="font-black text-foreground">محبوب
                                        ترین مقالات</div>
                                </div>
                            </div>
                            <div class="swiper-slide">

                                <div class="relative">
                                    <?php
                                    $select = $coon->prepare("SELECT * FROM article ORDER BY date DESC LIMIT 1 ");
                                    $select->execute();
                                    $articlls = $select->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($articlls as $article): ?>

                                        <div class="relative z-10">
                                            <a href="<?= base_url ?>article-detail.php?id=<?= $article['id'] ?>"
                                                class="block">
                                                <img src="<?= $article['image'] ?>" class="max-w-full rounded-3xl"
                                                    alt="<?= $article['title'] ?>" />
                                            </a>

                                        </div>
                                        <div class="bg-background rounded-b-3xl -mt-12 pt-12">
                                            <div
                                                class="bg-gradient-to-b from-background to-secondary rounded-b-3xl space-y-2 p-5 mx-5">
                                                <div class="flex items-center gap-2">
                                                    <span class="block w-1 h-1 bg-success rounded-full"></span>
                                                </div>
                                                <h2 class="font-bold text-sm">
                                                    <span
                                                        class="line-clamp-1 text-foreground transition-colors hover:text-primary">
                                                        <?= $article['title'] ?>
                                                    </span>
                                                </h2>
                                            </div>
                                            <div class="space-y-3 p-5">

                                                <div class="flex items-center justify-between gap-5">
                                                    <?php foreach ($writers as $writer) {
                                                        if ($article['writer'] == $writer['id']) { ?>
                                                            <div class="flex items-center gap-3">
                                                                <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                                                    <img src=" <?= $writer['image']; ?> "
                                                                        class="w-full h-full object-cover"
                                                                        alt="<?= $writer['username']; ?>" />
                                                                </div>
                                                                <div class="flex flex-col items-start space-y-1">
                                                                    <span class="line-clamp-1 font-semibold text-xs text-muted">
                                                                        نویسنده
                                                                        :</span>
                                                                    <span"
                                                                        class="line-clamp-1 font-bold text-xs text-foreground hover:text-primary">
                                                                        <?= $writer['username']; ?>
                                                                        </span>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    } ?>
                                                    <div class="flex flex-col items-end justify-center h-14">
                                                        <div class="flex items-center gap-1 text-muted">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-calendar-week-fill"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2M9.5 7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m3 0h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5M2 10.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5" />
                                                            </svg>
                                                            <span class="font-semibold text-xs"><?= $article['date'] ?>

                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <?php
                                    $select = $coon->prepare("SELECT * FROM article ORDER BY id ASC LIMIT 6 ");
                                    $select->execute();
                                    $articlels = $select->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($articlels as $article):

                                        ?>
                                        <button style="height: 86px;margin-top: 20px;" type="button"
                                            class="w-full h-14 flex items-center justify-between gap-x-2 relative bg-secondary rounded-2xl transition hover:text-foreground px-5"
                                            x-bind:class="open ? 'text-foreground' : 'text-muted'"
                                            x-on:click="open = !open">
                                            <div class="flex items-center justify-between gap-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex-shrink-0 " style="height: 70px;width: 71px;">
                                                        <img src="<?= $article['image'] ?>"
                                                            class="w-full h-full object-cover"
                                                            alt="<?= $article['title'] ?>" />
                                                    </div>
                                                    <div class="flex flex-col items-start space-y-1">
                                                        <h2 class="font-bold text-sm">
                                                            <a href="<?= base_url ?>article-detail.php?id=<?= $article['id'] ?>"
                                                                class="line-clamp-1 text-foreground transition-colors hover:text-primary">
                                                                <?= $article['title'] ?>
                                                            </a>
                                                        </h2><span class="line-clamp-1 font-semibold text-xs text-muted">
                                                            نویسنده
                                                            :
                                                            <?php foreach ($writers as $writer) {
                                                                if ($article['writer'] == $writer['id']) {
                                                                    echo $writer['username'];
                                                                }
                                                            } ?>
                                                        </span>

                                                    </div>

                                                </div>

                                                <div class="flex flex-col items-end justify-center h-14">

                                                </div>
                                            </div>
                                        </button>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>

        <?php
        include ("footer.php");
        ?>
    </div>


    <script src="assets/js/dependencies/alpinejs.min.js"></script>
    <script src="assets/js/dependencies/swiper-bundle.min.js"></script>
    <script src="assets/js/dependencies/plyr.min.js"></script>
    <script src="assets/js/dependencies/fancybox.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>


</html>