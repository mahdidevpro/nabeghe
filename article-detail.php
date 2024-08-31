<?php

include ("database/pdo_connection.php");

$max_views = 0;
$max_product = null;
$getId = $_GET['id'];

$select = $coon->prepare('SELECT * FROM article WHERE id=? ORDER BY date ASC');
$select->bindValue(1, $getId);
$select->execute();
$articles = $select->fetchAll(PDO::FETCH_ASSOC);




$writer = $coon->prepare("SELECT * FROM  writer");
$writer->execute();

$writers = $writer->fetchAll(PDO::FETCH_ASSOC);


$views = $coon->prepare("INSERT INTO views SET view_post=?");
$views->bindValue(1, $getId);
$views->execute();



$counter = $coon->prepare("SELECT COUNT(*) FROM views WHERE view_post=?");
$counter->bindValue(1, $getId);
$counter->execute();
$counters = $counter->fetch(PDO::FETCH_ASSOC);
foreach ($counters as $counter) {
}
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
                        <?php foreach ($articles as $article): ?>
                        <div class="relative">
                            <div class="relative z-10">
                                <div>
                                    <img src="<?= $article['image'] ?>" class="max-w-full rounded-3xl" alt="..." />
                                </div>
                            </div>
                            <div class="-mt-12 pt-12">
                                <div
                                    class="bg-gradient-to-b from-background to-secondary rounded-b-3xl space-y-2 p-5 mx-5">
                                    <div class="flex items-center gap-2">
                                        <span class="block w-1 h-1 bg-success rounded-full"></span>
                                    </div>

                                    <h1 class="font-bold text-xl text-foreground">
                                        <?= $article['title'] ?>
                                    </h1>


                                </div>
                                <div class="space-y-10 py-5">


                                    <div class="space-y-5"
                                        x-data="{ activeTab: 'tabOne', scroll: function() { document.getElementById(this.activeTab).scrollIntoView({ behavior: 'smooth' }) } }">
                                        <div class="space-y-8">
                                            <div class="bg-background rounded-3xl p-5" id="tabOne">

                                                <div class="description">
                                                    <p>

                                                        <?= $article['caption'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="bg-background rounded-3xl p-5" id="tabTwo">
                                                <div class="flex flex-col space-y-3">
                                                    <div class="w-full" x-data="{ open: true }">
                                                        <button type="button"
                                                            class="w-full h-14 flex items-center justify-between gap-x-2 relative bg-secondary rounded-2xl transition hover:text-foreground px-5"
                                                            x-bind:class="open ? 'text-foreground' : 'text-muted'"
                                                            x-on:click="open = !open">
                                                            <span class="flex items-center gap-3 text-right">
                                                                <div class="flex flex-wrap items-center gap-3">

                                                                    <span
                                                                        class="block w-1 h-1 bg-muted-foreground rounded-full"></span>
                                                                    <div class="flex items-center gap-1 text-muted">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="16" height="16" fill="currentColor"
                                                                            class="bi bi-calendar-week-fill"
                                                                            viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2M9.5 7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m3 0h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5M2 10.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5" />
                                                                        </svg>
                                                                        <span
                                                                            class="font-semibold text-xs"><?= $article['date'] ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex items-center gap-1 text-muted">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="16" height="16" fill="currentColor"
                                                                            class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                                                            <path
                                                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                                                        </svg>
                                                                        <span
                                                                            class="font-semibold text-xs"><?= $counter ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="w-1 h-1 bg-muted-foreground rounded-full">
                                                                </div>
                                                            </span>

                                                        </button>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                                alt="..." />
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
                                                            class="w-full h-full object-cover" alt="..." />
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
                                                        class="w-full h-full object-cover" alt="..." />
                                                </div>
                                                <div class="flex flex-col items-start space-y-1">
                                                    <h2 class="font-bold text-sm">
                                                        <a href="<?= base_url ?>article-detail.php?id=<?= $article['id'] ?>"
                                                            class="line-clamp-1 text-foreground transition-colors hover:text-primary">
                                                            <?= $article['title'] ?>
                                                        </a>
                                                    </h2>
                                                    <span class="line-clamp-1 font-semibold text-xs text-muted">
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