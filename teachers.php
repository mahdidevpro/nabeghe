<?php
include ('database/pdo_connection.php');
include ('database/jdf.php');
$getId = $_GET['id'];

$select = $coon->prepare("SELECT users.*,teacher.image AS image FROM `users` JOIN teacher ON users.id=teacher.user_id ");
$select->execute();
$teachers = $select->fetchAll(PDO::FETCH_ASSOC);

$select = $coon->prepare("SELECT teacher.*,users.username AS username FROM `teacher` JOIN users ON user_id=users.id  WHERE user_id=?");
$select->bindValue(1, $getId);
$select->execute();
$teach = $select->fetchAll(PDO::FETCH_ASSOC);

$select = $coon->prepare("SELECT course.* FROM `course` JOIN users ON teacher_id=users.id WHERE users.id=?");
$select->bindValue(1, $getId);
$select->execute();
$technumber = $select->rowCount();

$courses = $select->fetchAll(PDO::FETCH_ASSOC);
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
            <div class="space-y-14">
                <div class="max-w-7xl space-y-14 px-4 mx-auto">

                    <div class="bg-gradient-to-l from-secondary to-background rounded-2xl p-5">
                        <?php foreach ($teach as $b) { ?>

                            <div
                                class="flex md:flex-nowrap flex-wrap md:flex-row flex-col items-center justify-center gap-10 py-16">

                                <div class="relative bg-background rounded-xl p-4">
                                    <div class="relative mb-3 z-20">
                                        <div class="w-[50%] h-[300px] sm:h-[250px] sm:w-[100%]">
                                            <img src="<?= $b['image'] ?>" style="max-width: 800px;max-height: 350px;"
                                                class=" rounded-xl " alt="..." />
                                        </div>
                                    </div>

                                </div>
                                <div class="space-y-5">
                                    <h2 class="font-black sm:text-5xl text-3xl text-foreground">
                                        <?= $b['username'] ?><br />

                                    </h2>
                                    <h2 class="font-black sm:text-5xl text-3xl text-foreground">

                                    </h2>
                                    <h2 class="font-black sm:text-5xl text-3xl text-foreground">

                                    </h2>
                                    <h2 class="font-black sm:text-5xl text-3xl text-foreground">

                                    </h2>
                                    <div class="font-black sm:text-5xl text-3xl text-foreground">

                                    </div>
                                    <p class="sm:text-base text-sm text-muted" style="width: 620px;">
                                        <?= $b['description'] ?>
                                    </p>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <div class="flex items-center gap-1 text-muted">
                                            <span class="font-semibold text-xs">تاریخ عضویت :
                                            </span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-calendar-check-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                                            </svg>
                                            <span class="font-semibold text-xs"><?= jdate("Y/m/d", $b['date']) ?>
                                            </span>
                                        </div>
                                        <span class="block w-1 h-1 bg-muted-foreground rounded-full"></span>
                                        <div class="flex items-center gap-1 text-muted">
                                            <span class="font-semibold text-xs"> دوره ها :
                                            </span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                class="w-5 h-5">
                                                <path fill-rule="evenodd"
                                                    d="M9.664 1.319a.75.75 0 0 1 .672 0 41.059 41.059 0 0 1 8.198 5.424.75.75 0 0 1-.254 1.285 31.372 31.372 0 0 0-7.86 3.83.75.75 0 0 1-.84 0 31.508 31.508 0 0 0-2.08-1.287V9.394c0-.244.116-.463.302-.592a35.504 35.504 0 0 1 3.305-2.033.75.75 0 0 0-.714-1.319 37 37 0 0 0-3.446 2.12A2.216 2.216 0 0 0 6 9.393v.38a31.293 31.293 0 0 0-4.28-1.746.75.75 0 0 1-.254-1.285 41.059 41.059 0 0 1 8.198-5.424ZM6 11.459a29.848 29.848 0 0 0-2.455-1.158 41.029 41.029 0 0 0-.39 3.114.75.75 0 0 0 .419.74c.528.256 1.046.53 1.554.82-.21.324-.455.63-.739.914a.75.75 0 1 0 1.06 1.06c.37-.369.69-.77.96-1.193a26.61 26.61 0 0 1 3.095 2.348.75.75 0 0 0 .992 0 26.547 26.547 0 0 1 5.93-3.95.75.75 0 0 0 .42-.739 41.053 41.053 0 0 0-.39-3.114 29.925 29.925 0 0 0-5.199 2.801 2.25 2.25 0 0 1-2.514 0c-.41-.275-.826-.541-1.25-.797a6.985 6.985 0 0 1-1.084 3.45 26.503 26.503 0 0 0-1.281-.78A5.487 5.487 0 0 0 6 12v-.54Z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="font-semibold text-xs"><?= $technumber ?> </span>
                                        </div>
                                    </div>
                                    <a href="<?= base_url ?>series.php"
                                        class="inline-flex items-center justify-center gap-1 h-11 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4">
                                        <span class="font-semibold text-sm">شروع یادگیری برنامه‌نویسی</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
                                            <path fill-rule="evenodd"
                                                d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>

                    </div>


                    <div class="space-y-8">

                        <div
                            class="flex items-center justify-between gap-8 bg-gradient-to-l from-secondary to-background rounded-2xl p-5">
                            <div class="flex items-center gap-5">
                                <span
                                    class="flex items-center justify-center w-12 h-12 bg-primary text-primary-foreground rounded-full">

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M9.664 1.319a.75.75 0 0 1 .672 0 41.059 41.059 0 0 1 8.198 5.424.75.75 0 0 1-.254 1.285 31.372 31.372 0 0 0-7.86 3.83.75.75 0 0 1-.84 0 31.508 31.508 0 0 0-2.08-1.287V9.394c0-.244.116-.463.302-.592a35.504 35.504 0 0 1 3.305-2.033.75.75 0 0 0-.714-1.319 37 37 0 0 0-3.446 2.12A2.216 2.216 0 0 0 6 9.393v.38a31.293 31.293 0 0 0-4.28-1.746.75.75 0 0 1-.254-1.285 41.059 41.059 0 0 1 8.198-5.424ZM6 11.459a29.848 29.848 0 0 0-2.455-1.158 41.029 41.029 0 0 0-.39 3.114.75.75 0 0 0 .419.74c.528.256 1.046.53 1.554.82-.21.324-.455.63-.739.914a.75.75 0 1 0 1.06 1.06c.37-.369.69-.77.96-1.193a26.61 26.61 0 0 1 3.095 2.348.75.75 0 0 0 .992 0 26.547 26.547 0 0 1 5.93-3.95.75.75 0 0 0 .42-.739 41.053 41.053 0 0 0-.39-3.114 29.925 29.925 0 0 0-5.199 2.801 2.25 2.25 0 0 1-2.514 0c-.41-.275-.826-.541-1.25-.797a6.985 6.985 0 0 1-1.084 3.45 26.503 26.503 0 0 0-1.281-.78A5.487 5.487 0 0 0 6 12v-.54Z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <div class="flex flex-col font-black text-2xl space-y-2">
                                    <span class="font-black xs:text-2xl text-lg text-primary">دوره های</span>
                                    <span class="font-semibold xs:text-base text-sm text-foreground">
                                        <?= $b['username'] ?></span>
                                </div>
                            </div>

                        </div>

                        <div class="swiper col3-swiper-slider">
                            <div class="swiper-wrapper">

                                <?php
                                foreach ($courses as $course): ?>
                                    <div class="swiper-slide">

                                        <div class="relative">
                                            <div class="relative z-10">
                                                <span class="block">
                                                    <img src="<?= $course['image'] ?>" class="max-w-full rounded-3xl"
                                                        alt="..." />
                                                </span>
                                                <div
                                                    class="absolute left-3 top-3 h-11 inline-flex items-center justify-center gap-1 bg-black/20 rounded-full text-white transition-all hover:opacity-80 px-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" class="w-6 h-6">
                                                        <path fill-rule="evenodd"
                                                            d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="font-semibold text-sm">
                                                        <?php if ($course['type'] == 1) {
                                                            echo 'فرانت اند';
                                                        } else if ($course['type'] == 2) {
                                                            echo 'بک اند';
                                                        } else if ($course['type'] == 3) {
                                                            echo 'موبایل';
                                                        } else if ($course['type'] == 4) {
                                                            echo 'برنامه نویسی';
                                                        } ?></span>
                                                </div>
                                            </div>
                                            <div class="bg-background rounded-b-3xl -mt-12 pt-12">
                                                <div
                                                    class="bg-gradient-to-b from-background to-secondary rounded-b-3xl space-y-2 p-5 mx-5">
                                                    <div class="flex items-center gap-2">
                                                        <span class="block w-1 h-1 bg-success rounded-full"></span>
                                                        <span class="font-bold text-xs text-success">
                                                            <?php if ($course['status'] == 0) {
                                                                echo ('در حال برگزاری');
                                                            } elseif ($course['status'] == 1) {
                                                                echo ('تکمیل شده');
                                                            } ?></span>
                                                    </div>
                                                    <h2 class="font-bold text-sm">
                                                        <span
                                                            class="line-clamp-1 text-foreground transition-colors hover:text-primary">
                                                            <?= $course['title'] ?></span>
                                                    </h2>
                                                </div>
                                                <div class="space-y-3 p-5">

                                                    <div class="flex items-center justify-between gap-5">
                                                        <div class="flex items-center gap-3">
                                                            <?php foreach ($teachers as $teacher) {
                                                                if ($course['teacher_id'] == $teacher['id']) { ?>
                                                                    <div
                                                                        class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                                                        <img src="<?= $teacher['image'] ?>"
                                                                            class="w-full h-full object-cover" alt="..." />
                                                                    </div>
                                                                    <div class="flex flex-col items-start space-y-1">
                                                                        <span
                                                                            class="line-clamp-1 font-semibold text-xs text-muted">مدرس
                                                                            دوره:</span>
                                                                        <a
                                                                            class="line-clamp-1 font-bold text-xs text-foreground hover:text-primary">
                                                                            <?= $teacher['username'] ?>
                                                                        </a>
                                                                    </div>
                                                                <?php }
                                                            } ?>
                                                        </div>
                                                        <?php if ($course['value'] > 0) { ?>
                                                            <div class="flex flex-col items-end justify-center h-14">
                                                                <span class="line-through text-muted"><?php
                                                                echo number_format($course['offvalue']) . "<br>";
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
                                                    <div class="flex gap-3 mt-3">
                                                        <a href="<?= base_url ?>course-detail.php?id=<?= $course['id'] ?>"
                                                            class="w-full h-11 inline-flex items-center justify-center gap-1 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4">
                                                            <span class="line-clamp-1 font-semibold text-sm">مشاهده
                                                                دوره</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" class="w-5 h-5">
                                                                <path fill-rule="evenodd"
                                                                    d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        </a>
                                                        <button type="button"
                                                            class="flex-shrink-0 w-11 h-11 inline-flex items-center justify-center bg-secondary rounded-full text-muted transition-colors hover:text-red-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" class="w-5 h-5">
                                                                <path
                                                                    d="m9.653 16.915-.005-.003-.019-.01a20.759 20.759 0 0 1-1.162-.682 22.045 22.045 0 0 1-2.582-1.9C4.045 12.733 2 10.352 2 7.5a4.5 4.5 0 0 1 8-2.828A4.5 4.5 0 0 1 18 7.5c0 2.852-2.044 5.233-3.885 6.82a22.049 22.049 0 0 1-3.744 2.582l-.019.01-.005.003h-.002a.739.739 0 0 1-.69.001l-.002-.001Z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                <?php endforeach; ?>

                            </div>

                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
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