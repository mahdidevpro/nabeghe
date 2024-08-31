<?php
include ("database/pdo_connection.php");
include ("database/jdf.php");
$coun = 1;
$sweetalerterorre = null;
$hasRegister = false;



$getId = $_GET['id'];


$select = $coon->prepare('SELECT * FROM course WHERE id=?');
$select->bindValue(1, $getId);
$select->execute();
$courses = $select->fetchAll(PDO::FETCH_ASSOC);



if (isset($_SESSION['login'])) {

    $user_id = $_SESSION['id'];
    $result = $coon->prepare('SELECT *, store.statuse AS statuse FROM store WHERE user_id=? AND course_id=?');
    $result->bindValue(1, $user_id);
    $result->bindValue(2, $getId);
    $result->execute();
    $stores = $result->fetchAll(PDO::FETCH_ASSOC);
    if (count($stores) > 0) {
        $statuse = $stores[0]['statuse'];
    } else {
        $statuse = null;
    }
    if ($result->rowCount() >= 1) {
        $hasRegister = true;
    }
}
if (isset($_POST['add'])) {

    $select = $coon->prepare('SELECT * FROM store WHERE user_id=? AND course_id=?');
    $select->bindValue(1, $_SESSION['id']);
    $select->bindValue(2, $getId);
    $select->execute();
    if ($select->rowCount() >= 1) {
        $sweetalerterorre = true;
    } else {
        $select = $coon->prepare('INSERT INTO store SET user_id=? , course_id=?');
        $select->bindValue(1, $_SESSION['id']);
        $select->bindValue(2, $getId);
        $select->execute();
        $_SESSION['sweetalert'] = true;
        header('location:cart.php');
    }


}

if (isset($_POST['start'])) {
    // اطمینان حاصل کنید که $_SESSION['id'] مقداری دارد
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];

        // ابتدا انجام INSERT
        $insertQuery = $coon->prepare('INSERT INTO store (user_id, course_id) VALUES (?, ?)');
        $insertQuery->execute([$userId, $getId]);


        // اگر value دوره برابر با 0 بود، انجام UPDATE
        $courseQuery = $coon->prepare('SELECT * FROM course WHERE id = ?');
        $courseQuery->execute([$getId]);
        $course = $courseQuery->fetch();

        if ($course && $course['value'] == 0) {
            $updateQuery = $coon->prepare('UPDATE store SET statuse = 1 WHERE user_id = ? AND course_id = ?');
            $updateQuery->execute([$userId, $getId]);
        }

        // هدایت به صفحه مورد نظر
        header('location:cart.php');
        exit; // خروج از اسکریپت PHP برای جلوگیری از ادامه اجرای کد
    } else {
        echo "Session ID is not set!";
    }
}


$select = $coon->prepare("SELECT users.*,teacher.image AS image,teacher.description AS description FROM `users` JOIN teacher ON users.id=teacher.user_id ");
$select->execute();
$teachers = $select->fetchAll(PDO::FETCH_ASSOC);

$select = $coon->prepare('SELECT * FROM menu WHERE z!=0');
$select->execute();
$cats = $select->fetchAll(PDO::FETCH_ASSOC);


$select = $coon->prepare('SELECT * FROM part WHERE course=?');
$select->bindValue(1, $getId);
$select->execute();
$numberpart = $select->rowCount();
$parts = $select->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['numberpart'] = $numberpart;

$select = $coon->prepare('SELECT COUNT(DISTINCT user_id) AS total_users FROM store WHERE course_id = ?;');
$select->bindValue(1, $getId);
$select->execute();
$total_users = $select->fetch(PDO::FETCH_ASSOC);
$totalda = $total_users['total_users'];

$select = $coon->prepare('SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(time))) AS time  FROM part WHERE course=?');
$select->bindValue(1, $getId);
$select->execute();
$parttime = $select->fetchAll(PDO::FETCH_ASSOC);



if (isset($_SESSION['login'])) {
    if (isset($_POST['sub_comment'])) {
        $content = $_POST['content'];
        $replay = $_POST['ee'];
        $result = $coon->prepare('INSERT INTO comment SET sender=? , content=? , date=? , replay=? ,course=?');
        $result->bindValue(1, $user_id);
        $result->bindValue(2, $content);
        $result->bindValue(3, time());
        $result->bindValue(4, $replay);
        $result->bindValue(5, $getId);
        $result->execute();

    }
}
$result = $coon->prepare('SELECT  comment.* , users.username as username FROM comment JOIN users ON comment.sender = users.id WHERE comment.course=? ORDER BY comment.date DESC ');
$result->bindValue(1, $getId);
$result->execute();
$comments = $result->fetchAll(PDO::FETCH_ASSOC);

$result = $coon->prepare('SELECT  comment.* , users.username as username FROM comment JOIN users ON comment.sender = users.id WHERE comment.course=? ORDER BY comment.date DESC LIMIT 1');
$result->bindValue(1, $getId);
$result->execute();
$commentids = $result->fetchAll(PDO::FETCH_ASSOC);



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
                        <?php foreach ($courses as $course): ?>
                            <div class="relative">
                                <div class="relative z-10">
                                    <div>
                                        <img src="<?= $course['image'] ?>" class="max-w-full rounded-3xl" alt="..." />
                                    </div>
                                </div>
                                <div class="-mt-12 pt-12">
                                    <div
                                        class="bg-gradient-to-b from-background to-secondary rounded-b-3xl space-y-2 p-5 mx-5">
                                        <div class="flex items-center gap-2">
                                            <span class="block w-1 h-1 bg-success rounded-full"></span>
                                            <span class="font-bold text-xs text-success">تکمیل شده</span>
                                        </div>
                                        <h1 class="font-bold text-xl text-foreground"> <?= $course['title'] ?></h1>

                                    </div>
                                    <div class="space-y-10 py-5">
                                        <div class="grid lg:grid-cols-3 grid-cols-2 gap-5">
                                            <div
                                                class="flex flex-col items-center justify-center gap-2 bg-secondary border border-border rounded-2xl cursor-default p-3">
                                                <span
                                                    class="flex items-center justify-center w-12 h-12 bg-background rounded-full text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-5 h-5">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </span>
                                                <?php foreach ($parttime as $timee) { ?>
                                                    <div
                                                        class="flex flex-col items-center justify-center text-center space-y-1">
                                                        <span class="font-bold text-xs text-muted line-clamp-1">مدت زمان
                                                            دوره</span>
                                                        <span
                                                            class="font-bold text-sm text-foreground line-clamp-1"><?= $timee['time'] ?></span>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div
                                                class="flex flex-col items-center justify-center gap-3 bg-secondary border border-border rounded-2xl cursor-default p-3">
                                                <span
                                                    class="flex items-center justify-center w-12 h-12 bg-background rounded-full text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-5 h-5">
                                                        <path fill-rule="evenodd"
                                                            d="M4.25 2A2.25 2.25 0 0 0 2 4.25v2.5A2.25 2.25 0 0 0 4.25 9h2.5A2.25 2.25 0 0 0 9 6.75v-2.5A2.25 2.25 0 0 0 6.75 2h-2.5Zm0 9A2.25 2.25 0 0 0 2 13.25v2.5A2.25 2.25 0 0 0 4.25 18h2.5A2.25 2.25 0 0 0 9 15.75v-2.5A2.25 2.25 0 0 0 6.75 11h-2.5Zm9-9A2.25 2.25 0 0 0 11 4.25v2.5A2.25 2.25 0 0 0 13.25 9h2.5A2.25 2.25 0 0 0 18 6.75v-2.5A2.25 2.25 0 0 0 15.75 2h-2.5Zm0 9A2.25 2.25 0 0 0 11 13.25v2.5A2.25 2.25 0 0 0 13.25 18h2.5A2.25 2.25 0 0 0 18 15.75v-2.5A2.25 2.25 0 0 0 15.75 11h-2.5Z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </span>
                                                <div
                                                    class="flex flex-col items-center justify-center text-center space-y-1">
                                                    <span class="font-bold text-xs text-muted line-clamp-1">تعداد
                                                        جلسات</span>
                                                    <span
                                                        class="font-bold text-sm text-foreground line-clamp-1"><?= $numberpart ?></span>
                                                </div>
                                            </div>
                                            <div
                                                class="flex flex-col items-center justify-center gap-3 bg-secondary border border-border rounded-2xl cursor-default p-3">
                                                <span
                                                    class="flex items-center justify-center w-12 h-12 bg-background rounded-full text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-back" viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z" />
                                                    </svg>
                                                </span>
                                                <?php foreach ($courses as $course): ?>
                                                    <div
                                                        class="flex flex-col items-center justify-center text-center space-y-1">
                                                        <span class="font-bold text-xs text-muted line-clamp-1">نوع دوره</span>
                                                        <span class="font-bold text-sm text-foreground line-clamp-1">
                                                            <?php if ($course['level'] == 1) {
                                                                echo 'مقدماتی';
                                                            } else if ($course['level'] == 2) {
                                                                echo 'متوسط';
                                                            } else if ($course['level'] == 3) {
                                                                echo 'پیشرفته';
                                                            } ?></span>
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex flex-col items-center justify-center gap-3 bg-secondary border border-border rounded-2xl cursor-default p-3">
                                                    <span
                                                        class="flex items-center justify-center w-12 h-12 bg-background rounded-full text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5">
                                                            <path
                                                                d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM6 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM1.49 15.326a.78.78 0 0 1-.358-.442 3 3 0 0 1 4.308-3.516 6.484 6.484 0 0 0-1.905 3.959c-.023.222-.014.442.025.654a4.97 4.97 0 0 1-2.07-.655ZM16.44 15.98a4.97 4.97 0 0 0 2.07-.654.78.78 0 0 0 .357-.442 3 3 0 0 0-4.308-3.517 6.484 6.484 0 0 1 1.907 3.96 2.32 2.32 0 0 1-.026.654ZM18 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM5.304 16.19a.844.844 0 0 1-.277-.71 5 5 0 0 1 9.947 0 .843.843 0 0 1-.277.71A6.975 6.975 0 0 1 10 18a6.974 6.974 0 0 1-4.696-1.81Z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                    <div
                                                        class="flex flex-col items-center justify-center text-center space-y-1">
                                                        <span
                                                            class="font-bold text-xs text-muted line-clamp-1">شرکت‌کنندگان</span>
                                                        <span
                                                            class="font-bold text-sm text-foreground line-clamp-1"><?= $totalda ?>
                                                            دانشجو</span>
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex flex-col items-center justify-center gap-3 bg-secondary border border-border rounded-2xl cursor-default p-3">
                                                    <span
                                                        class="flex items-center justify-center w-12 h-12 bg-background rounded-full text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5">
                                                            <path fill-rule="evenodd"
                                                                d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                    <div
                                                        class="flex flex-col items-center justify-center text-center space-y-1">
                                                        <span class="font-bold text-xs text-muted line-clamp-1">وضعیت
                                                            دوره</span>
                                                        <span class="font-bold text-sm text-foreground line-clamp-1"><?php if ($course['status'] == 0) {
                                                            echo 'در حال برگزاری';
                                                        } else {
                                                            echo 'تکمیل شده';
                                                        } ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex flex-col items-center justify-center gap-2 bg-secondary border border-border rounded-2xl cursor-default p-3">
                                                    <span
                                                        class="flex items-center justify-center w-12 h-12 bg-background rounded-full text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-calendar-check-fill"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                                                        </svg>
                                                    </span>
                                                    <div
                                                        class="flex flex-col items-center justify-center text-center space-y-1">
                                                        <span class="font-bold text-xs text-muted line-clamp-1">آخرین
                                                            بروزرسانی</span>
                                                        <span class="font-bold text-sm text-foreground line-clamp-1">
                                                            <?php echo $update_date = jdate('Y/m/d') ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>

                                        </div>

                                        <div class="space-y-5"
                                            x-data="{ activeTab: 'tabOne', scroll: function() { document.getElementById(this.activeTab).scrollIntoView({ behavior: 'smooth' }) } }">
                                            <div class="sticky top-24 z-10">
                                                <div class="relative overflow-x-auto">
                                                    <ul
                                                        class="inline-flex gap-2 bg-secondary border border-border rounded-full p-1">
                                                        <li>
                                                            <button type="button"
                                                                class="flex items-center gap-x-2 relative rounded-full py-2 px-4"
                                                                x-bind:class="activeTab === 'tabOne' ? 'text-foreground bg-background' : 'text-muted'"
                                                                x-on:click="activeTab = 'tabOne'; scroll();">
                                                                <span x-show="activeTab === 'tabOne'">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 20 20" fill="currentColor"
                                                                        class="w-5 h-5">
                                                                        <path
                                                                            d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z">
                                                                        </path>
                                                                    </svg>
                                                                </span>

                                                                <span x-show="activeTab !== 'tabOne'">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" class="w-5 h-5">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125">
                                                                        </path>
                                                                    </svg>
                                                                </span>

                                                                <span
                                                                    class="font-semibold text-sm whitespace-nowrap">معرفی</span>
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button type="button"
                                                                class="flex items-center gap-x-2 relative rounded-full py-2 px-4"
                                                                x-bind:class="activeTab === 'tabTwo' ? 'text-foreground bg-background' : 'text-muted'"
                                                                x-on:click="activeTab = 'tabTwo'; scroll();">
                                                                <span x-show="activeTab === 'tabTwo'">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 20 20" fill="currentColor"
                                                                        class="w-5 h-5">
                                                                        <path fill-rule="evenodd"
                                                                            d="M6 4.75A.75.75 0 016.75 4h10.5a.75.75 0 010 1.5H6.75A.75.75 0 016 4.75zM6 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H6.75A.75.75 0 016 10zm0 5.25a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H6.75a.75.75 0 01-.75-.75zM1.99 4.75a1 1 0 011-1H3a1 1 0 011 1v.01a1 1 0 01-1 1h-.01a1 1 0 01-1-1v-.01zM1.99 15.25a1 1 0 011-1H3a1 1 0 011 1v.01a1 1 0 01-1 1h-.01a1 1 0 01-1-1v-.01zM1.99 10a1 1 0 011-1H3a1 1 0 011 1v.01a1 1 0 01-1 1h-.01a1 1 0 01-1-1V10z"
                                                                            clip-rule="evenodd"></path>
                                                                    </svg>
                                                                </span>

                                                                <span x-show="activeTab !== 'tabTwo'">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" class="w-5 h-5">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z">
                                                                        </path>
                                                                    </svg>
                                                                </span>

                                                                <span class="font-semibold text-sm whitespace-nowrap">فهرست
                                                                    ویدیو ها</span>
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button type="button"
                                                                class="flex items-center gap-x-2 relative rounded-full py-2 px-4"
                                                                x-bind:class="activeTab === 'tabThree' ? 'text-foreground bg-background' : 'text-muted'"
                                                                x-on:click="activeTab = 'tabThree'; scroll();">
                                                                <span x-show="activeTab === 'tabThree'">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 20 20" fill="currentColor"
                                                                        class="w-5 h-5">
                                                                        <path
                                                                            d="M3.505 2.365A41.369 41.369 0 0 1 9 2c1.863 0 3.697.124 5.495.365 1.247.167 2.18 1.108 2.435 2.268a4.45 4.45 0 0 0-.577-.069 43.141 43.141 0 0 0-4.706 0C9.229 4.696 7.5 6.727 7.5 8.998v2.24c0 1.413.67 2.735 1.76 3.562l-2.98 2.98A.75.75 0 0 1 5 17.25v-3.443c-.501-.048-1-.106-1.495-.172C2.033 13.438 1 12.162 1 10.72V5.28c0-1.441 1.033-2.717 2.505-2.914Z">
                                                                        </path>
                                                                        <path
                                                                            d="M14 6c-.762 0-1.52.02-2.271.062C10.157 6.148 9 7.472 9 8.998v2.24c0 1.519 1.147 2.839 2.71 2.935.214.013.428.024.642.034.2.009.385.09.518.224l2.35 2.35a.75.75 0 0 0 1.28-.531v-2.07c1.453-.195 2.5-1.463 2.5-2.915V8.998c0-1.526-1.157-2.85-2.729-2.936A41.645 41.645 0 0 0 14 6Z">
                                                                        </path>
                                                                    </svg>
                                                                </span>

                                                                <span x-show="activeTab !== 'tabThree'">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" class="w-5 h-5">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155">
                                                                        </path>
                                                                    </svg>
                                                                </span>

                                                                <span class="font-semibold text-sm whitespace-nowrap">دیدگاه
                                                                    و پرسش</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="space-y-8">
                                                <div class="bg-background rounded-3xl p-5" id="tabOne">
                                                    <div class="flex items-center gap-3 mb-5">
                                                        <div class="flex items-center gap-1">
                                                            <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                                            <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                                        </div>
                                                        <div class="font-black text-foreground">معرفی دوره</div>
                                                    </div>
                                                    <?php foreach ($courses as $course): ?>
                                                        <div class="description">
                                                            <p>
                                                                <?= $course['content'] ?>
                                                            </p>


                                                        </div>

                                                    <?php endforeach; ?>
                                                </div>

                                                <div class="bg-background rounded-3xl p-5" id="tabTwo">
                                                    <div class="flex items-center gap-3 mb-5">
                                                        <div class="flex items-center gap-1">
                                                            <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                                            <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                                        </div>
                                                        <div class="font-black text-foreground">فهرست ویدیو ها</div>
                                                    </div>
                                                    <video src="<?= $course['intro'] ?>" class="video-item" id="intro-video"
                                                        controls>
                                                    </video>

                                                    <div class="flex flex-col relative py-3 sm:pr-8 sm:pl-16" x-show="open">
                                                        <div class="space-y-1">
                                                            <?php foreach ($parts as $part) { ?>
                                                                <div
                                                                    class="flex sm:flex-nowrap flex-wrap items-center gap-3 sm:h-12 border border-border rounded-xl p-3">
                                                                    <span class="text-xs text-muted"><?= ++$coun ?></span>
                                                                    <div class="w-1 h-1 bg-muted-foreground rounded-full">
                                                                    </div>
                                                                    <span
                                                                        class="font-semibold text-xs text-foreground line-clamp-1 transition-all ">
                                                                        <?= $part['title'] ?>
                                                                    </span>
                                                                    <span style="color: darkgreen;"
                                                                        class="font-semibold text-xs text-foreground line-clamp-1 transition-all ">
                                                                        <?php if ($part['status'] == 'free') {
                                                                            echo 'رایگان';
                                                                        } else {
                                                                            echo 'نقدی';
                                                                        } ?>
                                                                    </span>
                                                                    <div
                                                                        class="flex items-center justify-end gap-3 sm:w-auto w-full mr-auto">
                                                                        <span class="flex items-center gap-1 text-muted">
                                                                            <span class="text-xs">
                                                                                <?= $j = $part['time'];

                                                                                ?>
                                                                            </span>
                                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                                stroke="currentColor" class="w-4 h-4">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z">
                                                                                </path>
                                                                            </svg>
                                                                        </span>
                                                                        <?php if (isset($_SESSION['login'])) { ?>
                                                                            <?php if ($part['status'] == 'free') { ?>
                                                                                <span id="part-video" link="<?= $part['link'] ?>"
                                                                                    class="flex items-center h-9 gap-1 bg-secondary rounded-full text-muted transition-colors hover:text-primary px-4">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                                        height="16" fill="currentColor"
                                                                                        class="bi bi-google-play" viewBox="0 0 16 16">
                                                                                        <path
                                                                                            d="M14.222 9.374c1.037-.61 1.037-2.137 0-2.748L11.528 5.04 8.32 8l3.207 2.96zm-3.595 2.116L7.583 8.68 1.03 14.73c.201 1.029 1.36 1.61 2.303 1.055zM1 13.396V2.603L6.846 8zM1.03 1.27l6.553 6.05 3.044-2.81L3.333.215C2.39-.341 1.231.24 1.03 1.27" />
                                                                                    </svg>
                                                                                </span>
                                                                                <a href="<?= base_url . $part['link'] ?>" download
                                                                                    class="flex items-center h-9 gap-1 bg-secondary rounded-full text-muted transition-colors hover:text-primary px-4">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                                        height="16" fill="currentColor"
                                                                                        class="bi bi-file-earmark-arrow-down"
                                                                                        viewBox="0 0 16 16">
                                                                                        <path
                                                                                            d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z" />
                                                                                        <path
                                                                                            d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                                                                    </svg>
                                                                                </a>
                                                                            <?php }
                                                                            if ($part['status'] == 'cash' && $statuse == 0) { ?>
                                                                                <span id="no-cash"
                                                                                    class="flex items-center h-9 gap-1 bg-secondary rounded-full text-muted transition-colors hover:text-primary px-4">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                                        height="16" fill="currentColor"
                                                                                        class="bi bi-file-earmark-lock2-fill"
                                                                                        viewBox="0 0 16 16">
                                                                                        <path d="M7 7a1 1 0 0 1 2 0v1H7z" />
                                                                                        <path
                                                                                            d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M10 7v1.076c.54.166 1 .597 1 1.224v2.4c0 .816-.781 1.3-1.5 1.3h-3c-.719 0-1.5-.484-1.5-1.3V9.3c0-.627.46-1.058 1-1.224V7a2 2 0 1 1 4 0" />
                                                                                    </svg>
                                                                                </span>
                                                                            <?php } elseif ($part['status'] == 'cash' && $statuse == 1) { ?>
                                                                                <span id="part-video" link="<?= $part['link'] ?>"
                                                                                    class="flex items-center h-9 gap-1 bg-secondary rounded-full text-muted transition-colors hover:text-primary px-4">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                                        height="16" fill="currentColor"
                                                                                        class="bi bi-google-play" viewBox="0 0 16 16">
                                                                                        <path
                                                                                            d="M14.222 9.374c1.037-.61 1.037-2.137 0-2.748L11.528 5.04 8.32 8l3.207 2.96zm-3.595 2.116L7.583 8.68 1.03 14.73c.201 1.029 1.36 1.61 2.303 1.055zM1 13.396V2.603L6.846 8zM1.03 1.27l6.553 6.05 3.044-2.81L3.333.215C2.39-.341 1.231.24 1.03 1.27" />
                                                                                    </svg>
                                                                                </span>
                                                                                <a href="<?= base_url . $part['link'] ?>" download
                                                                                    class="flex items-center h-9 gap-1 bg-secondary rounded-full text-muted transition-colors hover:text-primary px-4">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                                        height="16" fill="currentColor"
                                                                                        class="bi bi-file-earmark-arrow-down"
                                                                                        viewBox="0 0 16 16">
                                                                                        <path
                                                                                            d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z" />
                                                                                        <path
                                                                                            d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                                                                    </svg>
                                                                                </a>
                                                                            <?php }
                                                                        } else { ?>
                                                                            <?php ?>
                                                                            <span id="no-register"
                                                                                class="flex items-center h-9 gap-1 bg-secondary rounded-full text-muted transition-colors hover:text-primary px-4">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                                    height="16" fill="currentColor"
                                                                                    class="bi bi-lock-fill" viewBox="0 0 16 16">
                                                                                    <path
                                                                                        d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2" />
                                                                                </svg>
                                                                            </span>
                                                                        <?php } ?>

                                                                    </div>

                                                                </div>
                                                            <?php } ?>

                                                            <script src="https://code.jquery.com/jquery-3.7.1.min.js"
                                                                integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
                                                                crossorigin="anonymous"></script>

                                                            <script>
                                                                $(document).on('click', '#part-video', function () {
                                                                    var link = $(this).attr('link')
                                                                    $("#intro-video").attr('src', '' + link)
                                                                })
                                                                $(document).on('click', '#no-register', function () {
                                                                    const Toast = Swal.mixin({
                                                                        toast: true,
                                                                        position: "top-end",
                                                                        showConfirmButton: false,
                                                                        timer: 3000,
                                                                        timerProgressBar: true,
                                                                        didOpen: (toast) => {
                                                                            toast.onmouseenter = Swal
                                                                                .stopTimer;
                                                                            toast.onmouseleave = Swal
                                                                                .resumeTimer;
                                                                        }
                                                                    });
                                                                    Toast.fire({
                                                                        icon: "error",
                                                                        title: "ایتدا وارد سایت شوید"
                                                                    });
                                                                })
                                                                $(document).on('click', '#no-cash', function () {
                                                                    const Toast = Swal.mixin({
                                                                        toast: true,
                                                                        position: "top-end",
                                                                        showConfirmButton: false,
                                                                        timer: 3000,
                                                                        timerProgressBar: true,
                                                                        didOpen: (toast) => {
                                                                            toast.onmouseenter = Swal
                                                                                .stopTimer;
                                                                            toast.onmouseleave = Swal
                                                                                .resumeTimer;
                                                                        }
                                                                    });
                                                                    Toast.fire({
                                                                        icon: "error",
                                                                        title: "ابتدا دوره را خریداری کنید"
                                                                    });
                                                                })
                                                            </script>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="bg-background rounded-3xl p-5" id="tabThree">
                                                    <div class="flex items-center gap-3 mb-5">
                                                        <div class="flex items-center gap-1">
                                                            <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                                            <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                                        </div>
                                                        <div class="font-black text-foreground">دیدگاه و پرسش</div>
                                                    </div>
                                                    <?php if (isset($_SESSION['login'])) { ?>
                                                        <div class="bg-background border border-border rounded-3xl p-5 mb-5">
                                                            <div class="flex items-center gap-3 mb-5">
                                                                <div class="flex items-center gap-1">
                                                                    <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                                                    <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                                                </div>
                                                                <div class="font-black text-xs text-foreground" id="comment">
                                                                    ارسال دیدگاه یا پرسش
                                                                </div>
                                                            </div>



                                                            <div class="flex flex-wrap items-center gap-3 mb-5">
                                                                <?php foreach ($commentids as $commentid) {
                                                                    $username = $commentid['username'];
                                                                    $initial = strtoupper($username[0]); // حرف اول اسم کاربر
                                                                    ?>
                                                                    <div class="flex items-center gap-3 sm:w-auto w-full">
                                                                        <div
                                                                            class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                                                            <?php
                                                                            if (isset($_SESSION['user_info'])) {
                                                                                $user = $_SESSION['user_info'];
                                                                                if ($user['avatar'] != null) { ?>
                                                                                    <img src="<?= htmlspecialchars($user['avatar']); ?>"
                                                                                        class="w-full h-full object-cover" alt="...">
                                                                                <?php } elseif ($user['avatar'] == null) {
                                                                                    $username = $user['username'];
                                                                                    $initial = strtoupper($username[0]); ?>
                                                                                    <div class="flex items-center gap-3 sm:w-auto w-full">
                                                                                        <div
                                                                                            class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden flex items-center justify-center bg-secondary text-foreground">
                                                                                            <span
                                                                                                class="text-lg font-bold"><?= $initial ?></span>
                                                                                        </div>
                                                                                        <div class="flex flex-col items-start space-y-1">
                                                                                            <a href="#"
                                                                                                class="line-clamp-1 font-semibold text-sm text-foreground hover:text-primary"><?= $username ?>
                                                                                            </a>
                                                                                            <span class="text-xs text-muted"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php }
                                                                            } ?>
                                                                        </div>
                                                                        <div class="flex flex-col items-start space-y-1">
                                                                            <a href="#"
                                                                                class="line-clamp-1 font-semibold text-sm text-foreground hover:text-primary"><?= $username ?>
                                                                            </a>
                                                                            <span class="text-xs text-muted"></span>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>




                                                                <button type="button" style="display: none;"
                                                                    class="line-clamp-1 font-semibold text-sm text-red-500 mr-auto alertg">لغو
                                                                    پاسخ</button>

                                                            </div>

                                                            <form method="post" class="flex flex-col space-y-5">
                                                                <input id="ee" name="ee" value="0" type="hidden">
                                                                <textarea name="content" rows="10" required
                                                                    class="form-textarea w-full !ring-0 !ring-offset-0 bg-secondary border-0 focus:border-border border-border rounded-xl text-sm text-foreground p-5"
                                                                    placeholder="متن مورد نظر خود را وارد کنید ..."></textarea>
                                                                <button type="submit" name="sub_comment"
                                                                    class="h-10 inline-flex items-center justify-center gap-1 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4 mr-auto">
                                                                    <span class="font-semibold text-sm">ثبت دیدگاه یا
                                                                        پرسش</span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                        fill="currentColor" class="w-5 h-5">
                                                                        <path fill-rule="evenodd"
                                                                            d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                                                                            clip-rule="evenodd"></path>
                                                                    </svg>
                                                                </button>
                                                            </form>

                                                        </div>
                                                    <?php } else { ?>
                                                        <div
                                                            class="bg-background border border-border rounded-3xl space-y-3 p-5">

                                                            <div class="flex flex-col items-center space-y-1">
                                                                <a href="#"
                                                                    class="line-clamp-1 font-semibold text-sm text-foreground hover:text-primary">برای
                                                                    ثبت کامنت و دیدن نظرات دوره باید وارد سایت شوید
                                                                </a>
                                                            </div>
                                                        </div>


                                                    <?php } ?>
                                                    <div class="space-y-3">
                                                        <div class="space-y-3">
                                                            <?php foreach ($comments as $comment) {
                                                                if ($comment['replay'] == 0) {
                                                                    $username = $comment['username'];
                                                                    $initial = strtoupper($username[0]); // حرف اول اسم کاربر
                                                                    ?>

                                                                    <div
                                                                        class="bg-background border border-border rounded-3xl space-y-3 p-5">
                                                                        <div
                                                                            class="flex sm:flex-nowrap flex-wrap sm:flex-row flex-col sm:items-center sm:justify-between gap-5 border-b border-border pb-3">
                                                                            <div class="flex items-center gap-3 sm:w-auto w-full">
                                                                                <div
                                                                                    class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden flex items-center justify-center bg-secondary text-foreground">
                                                                                    <span
                                                                                        class="text-lg font-bold"><?= $initial ?></span>
                                                                                </div>
                                                                                <div class="flex flex-col items-start space-y-1">
                                                                                    <a href="#"
                                                                                        class="line-clamp-1 font-semibold text-sm text-foreground hover:text-primary"><?= $username ?>
                                                                                    </a>
                                                                                    <span class="text-xs text-muted"></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="flex items-center gap-3 sm:mr-0 mr-auto">
                                                                                <a href="#comment" name="replay" id="replay"
                                                                                    commentid="<?= $comment['id'] ?>"
                                                                                    class="flex items-center h-9 gap-1 bg-secondary rounded-full text-muted transition-colors hover:text-primary px-4">
                                                                                    <span class="text-xs">پاسخ</span>
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        viewBox="0 0 20 20" fill="currentColor"
                                                                                        class="w-5 h-5">
                                                                                        <path fill-rule="evenodd"
                                                                                            d="M12.207 2.232a.75.75 0 0 0 .025 1.06l4.146 3.958H6.375a5.375 5.375 0 0 0 0 10.75H9.25a.75.75 0 0 0 0-1.5H6.375a3.875 3.875 0 0 1 0-7.75h10.003l-4.146 3.957a.75.75 0 0 0 1.036 1.085l5.5-5.25a.75.75 0 0 0 0-1.085l-5.5-5.25a.75.75 0 0 0-1.06.025Z"
                                                                                            clip-rule="evenodd"></path>
                                                                                    </svg>
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                        <p class="text-sm text-muted">
                                                                            <?= $comment['content'] ?>
                                                                        </p>
                                                                    </div>
                                                                    <?php foreach ($comments as $replies) {
                                                                        $username = $replies['username'];
                                                                        $initial = strtoupper($username[0]);
                                                                        if ($replies['replay'] == $comment['id']) { ?>

                                                                            <div
                                                                                class="relative before:content-[''] before:absolute before:-top-3 before:right-8 before:w-px before:h-[calc(100%-24px)] before:bg-border after:content-[''] after:absolute after:bottom-9 after:right-8 after:w-8 after:h-px after:bg-border space-y-3 pr-16">
                                                                                <div
                                                                                    class="bg-background border border-border rounded-3xl space-y-3 p-5">
                                                                                    <div
                                                                                        class="flex sm:flex-nowrap flex-wrap sm:flex-row flex-col sm:items-center sm:justify-between gap-5 border-b border-border pb-3">
                                                                                        <div
                                                                                            class="flex items-center gap-3 sm:w-auto w-full">
                                                                                            <div
                                                                                                class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden flex items-center justify-center bg-secondary text-foreground">
                                                                                                <span
                                                                                                    class="text-lg font-bold"><?= $initial ?></span>
                                                                                            </div>
                                                                                            <div
                                                                                                class="flex flex-col items-start space-y-1">
                                                                                                <a href="#"
                                                                                                    class="line-clamp-1 font-semibold text-sm text-foreground hover:text-primary"><?= $username ?>
                                                                                                </a>
                                                                                                <span class="text-xs text-muted"></span>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                    <p class="text-sm text-muted">
                                                                                        <?= $replies['content'] ?>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        <?php }
                                                                    }
                                                                }
                                                            } ?>
                                                            <script>
                                                                $(document).on("click", "#replay", function () {
                                                                    const id = $(this).attr("commentid")
                                                                    $("#ee").val(id)
                                                                    $(".alertg").slideDown()
                                                                })
                                                                $(".alertg").click(function () {
                                                                    $("#ee").val(0)
                                                                    $(".alertg").slideUp()

                                                                })
                                                            </script>
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
                                        <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                        <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                    </div>
                                    <div class="font-black text-foreground">نام نویسی در دوره</div>
                                </div>
                            </div>
                            <?php foreach ($courses as $course): ?>
                                <div class="flex items-center justify-between gap-5">
                                    <span class="font-bold text-base text-muted">هزینه ثبت نام:</span>
                                    <?php if ($course['value'] > 0) { ?>
                                        <div class="flex flex-col items-end justify-center h-14">
                                            <span class="line-through text-muted"><?php
                                            if ($course['offvalue'] > 0) {
                                                echo number_format($course['offvalue']) . "<br>";
                                            }
                                            ?></span>
                                            <div class="flex items-center gap-1">
                                                <span class="font-black text-xl text-foreground"><?php
                                                echo number_format($course['value']) . "<br>";
                                                ?></span>
                                                <span class="text-xs text-muted">تومان</span>
                                            </div>
                                        </div>
                                    <?php } elseif ($course['value'] <= 0) { ?>
                                        <div class="flex flex-col items-end justify-center h-14">
                                            <div class="flex items-center gap-1">
                                                <span class="font-black text-xl text-success">رایگان!</span>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php endforeach; ?>
                            <div class="flex gap-3 mt-3">
                                <button type="button"
                                    class="w-full h-11 inline-flex items-center justify-center gap-1 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4">

                                    <?php if (isset($_SESSION['login'])): ?>
                                        <?php if ($statuse == 0): ?>
                                            <?php if ($course['value'] == 0): ?>
                                                <form method="post">
                                                    <input class="font-semibold text-sm" value="شروع یادگیری" type="submit"
                                                        name="start">
                                                </form>
                                            <?php else: ?>
                                                <form method="post" action="">
                                                    <input class="font-semibold text-sm" value="اضافه به سبد" type="submit"
                                                        name="add">
                                                </form>
                                            <?php endif; ?>
                                        <?php elseif ($statuse == 1): ?>
                                            <a href="#">
                                                <span class="font-semibold text-sm">شما دانشجوی این دوره هستین</span>
                                            </a>

                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="<?= base_url ?>login.php">
                                            <span class="font-semibold text-sm">ابتدا وارد سایت شوید</span>
                                        </a>
                                    <?php endif; ?>


                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <button type="button"
                                    class="flex-shrink-0 w-11 h-11 inline-flex items-center justify-center bg-secondary rounded-full text-muted transition-colors hover:text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path
                                            d="m9.653 16.915-.005-.003-.019-.01a20.759 20.759 0 0 1-1.162-.682 22.045 22.045 0 0 1-2.582-1.9C4.045 12.733 2 10.352 2 7.5a4.5 4.5 0 0 1 8-2.828A4.5 4.5 0 0 1 18 7.5c0 2.852-2.044 5.233-3.885 6.82a22.049 22.049 0 0 1-3.744 2.582l-.019.01-.005.003h-.002a.739.739 0 0 1-.69.001l-.002-.001Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="space-y-5">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1">
                                    <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                    <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                </div>
                                <div class="font-black text-sm text-foreground">مدرس دوره</div>
                            </div>
                            <div class="space-y-3">
                                <?php foreach ($teachers as $teacher) {
                                    if ($course['teacher_id'] == $teacher['id']) { ?>
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                                <img src="<?= $teacher['image'] ?>" class="w-full h-full object-cover"
                                                    alt="..." />
                                            </div>
                                            <div class="flex flex-col items-start space-y-1">
                                                <a href="<?= base_url ?>lecturer.php"
                                                    class="line-clamp-1 font-bold text-sm text-foreground hover:text-primary"><?= $teacher['username'] ?></a>
                                                <a href="teachers.php?id=<?= $teacher['id'] ?>"
                                                    class="line-clamp-1 font-semibold text-xs text-primary">دیدن
                                                    رزومه</a>
                                            </div>
                                        </div>
                                        <div class="bg-secondary rounded-tl-3xl rounded-b-3xl text-sm text-muted p-5">
                                            <?= $teacher['description'] ?>
                                            :)
                                        </div>
                                    <?php }
                                } ?>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1">
                                    <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                    <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                </div>
                                <div class="font-black text-sm text-foreground"> دسته بندی</div>
                            </div>
                            <div class="space-y-3">



                                <div class="flex items-center gap-3" style="display: inline-block;">
                                    <span
                                        class="flex items-center h-9 gap-1 bg-secondary rounded-full text-muted transition-colors hover:text-primary px-4">
                                        <span class="text-xs nav-link"><?php foreach ($cats as $cat) {
                                            if ($course['cat'] == $cat['id']) {
                                                echo $cat['title'];
                                            }
                                        } ?></span>
                                    </span>

                                </div>

                            </div>
                        </div>
                        <div class="space-y-5">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1">
                                    <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                    <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                </div>
                                <div class="font-black text-sm text-foreground"> برچسب ها</div>
                            </div>
                            <div class="space-y-3">
                                <?php
                                $tags = explode(',', $course['tag']);
                                foreach ($tags as $tag): ?>

                                    <div class="flex items-center gap-3" style="display: inline-block;">
                                        <span
                                            class="flex items-center h-9 gap-1 bg-secondary rounded-full text-muted transition-colors hover:text-primary px-4">
                                            <span class="text-xs nav-link"><?= $tag ?></span>
                                        </span>

                                    </div>
                                <?php endforeach; ?>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if ($sweetalerterorre) { ?>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "قبلا  به سبد خرید اضافه شده"
            });
        </script>
    <?php } ?>
</body>


</html>