<?php
include ('database/pdo_connection.php');
include ('database/jdf.php');
$id = $_SESSION['id'];

if (!isset($_SESSION['login'])) {
    header("location:404.php");

}
function limit_words($string, $word_limit)
{
    $words = explode(" ", $string);
    return implode(" ", array_splice($words, 0, $word_limit));
}
$result = $coon->prepare("SELECT * FROM ticket WHERE sender=? AND reply=0");
$result->bindValue(1, $id);
$result->execute();
$ticket_pros = $result->fetchAll(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" href="assets/css/style.css" />
    <title>قالب آموزشی نابغه - پروفایل - داشبورد</title>


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
                <div class="grid md:grid-cols-12 grid-cols-1 items-start gap-5">
                    <div class="lg:col-span-3 md:col-span-4 md:sticky md:top-24">
                        <div class="flex items-center gap-5 mb-5">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                    <?php if ($user['avatar'] != null) { ?>
                                        <img src="<?= htmlspecialchars($user['avatar']); ?>"
                                            class="w-full h-full object-cover" alt="...">
                                    <?php } elseif ($user['avatar'] == null) {
                                        $username = $user['username'];
                                        $initial = strtoupper($username[0]); ?>
                                        <div class="flex items-center gap-3 sm:w-auto w-full">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden flex items-center justify-center bg-secondary text-foreground">
                                                <span class="text-lg font-bold"><?= $initial ?></span>
                                            </div>
                                            <div class="flex flex-col items-start space-y-1">
                                                <a href="#"
                                                    class="line-clamp-1 font-semibold text-sm text-foreground hover:text-primary"><?= $username ?>
                                                </a>
                                                <span class="text-xs text-muted"></span>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="flex flex-col items-start space-y-1">
                                    <span class="text-xs text-muted">خوش
                                        آمدید</span>
                                    <span
                                        class="line-clamp-1 font-semibold text-sm text-foreground cursor-default"><?= htmlspecialchars($user['username']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <ul class="flex flex-col space-y-3 bg-secondary rounded-2xl p-5">

                            <?php include ("usersss.php") ?>
                        </ul>
                    </div>

                    <div class="lg:col-span-9 md:col-span-8">
                        <div class="space-y-10">
                            <div class="bg-background  rounded-3xl p-5 mb-5">



                            </div>

                            <div class="space-y-5">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-1">
                                        <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                        <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                    </div>
                                    <div class="font-black text-foreground">مدیریت تیکت ها</div>
                                    <a href="<?= base_url ?>add-ticket.php" type="submit"
                                        class="h-10 inline-flex items-center justify-center gap-1 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4 mr-auto">
                                        <span class="font-semibold text-sm">ثبت تیکت جدید
                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
                                            <path fill-rule="evenodd"
                                                d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </div>
                                <div
                                    class="main-container form-textarea w-full !ring-0 !ring-offset-0 bg-secondary border-0 focus:border-border border-border rounded-xl text-sm text-foreground p-5">
                                    <table class="table-container">
                                        <tr class="table-row  font-black text-xs text-foreground">
                                            <th class="row-item">عنوان</th>
                                            <th class="row-item">توضیحات</th>
                                            <th class="row-item"> تاریخ</th>
                                            <th class="row-item">عملیات</th>
                                        </tr>
                                        <?php foreach ($ticket_pros as $ticket_pro): ?>
                                            <tr class="table-row">
                                                <td class="row-item"><?= $ticket_pro['title'] ?></td>
                                                <td class="row-item"> <?php $content = $ticket_pro['content'];
                                                echo limit_words($content, 3) . " ...";
                                                ?></td>
                                                <td class="row-item"><?= jdate('Y/m/d', $ticket_pro['date']) ?></td>
                                                <td class="row-item"><a
                                                        href="<?= base_url ?>profile-ticket-n.php?main=<?= $ticket_pro['main'] ?>"
                                                        type="submit"
                                                        class="h-6  inline-flex items-center justify-center gap-1 bg-primary rounded-full text-primary-foreground transition-colors hover:opacity-80 px-4 mr-left">نمایش</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
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