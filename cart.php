<?php
include ('database/pdo_connection.php');
$total = 0;
$not = 0;
$yes = 0;
if (!isset($_SESSION['login'])) {
    header("location:home.php");

}
$coun = 1;
$getId = $_SESSION['id'];

$select = $coon->prepare('SELECT * , store.id FROM store JOIN course ON course_id = course.id WHERE user_id=? AND statuse=0');
$select->bindValue(1, $getId);
$select->execute();
$number = $select->rowCount();
$items = $select->fetchAll(PDO::FETCH_ASSOC);

$select = $coon->prepare("SELECT users.*,teacher.image AS image FROM `users` JOIN teacher ON users.id=teacher.user_id ");
$select->execute();
$teachers = $select->fetchAll(PDO::FETCH_ASSOC);

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
    <title>قالب آموزشی نابغه - سبد خرید</title>
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
            <div x-data="{ modalOpen: false }">

                <div class="max-w-7xl space-y-14 px-4 mx-auto">
                    <?php if (!empty($items)) { ?>


                        <div class="flex md:flex-nowrap flex-wrap items-start gap-5">

                            <div class="md:w-8/12 w-full">
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
                                        <div class="flex flex-col space-y-2">
                                            <span class="font-black xs:text-2xl text-lg text-primary">سبد خرید شما</span>
                                            <span class="font-semibold text-xs text-muted"><?= $number ?> دوره به سبد اضافه
                                                کرده
                                                اید</span>
                                        </div>
                                    </div>
                                </div>


                                <?php

                                foreach ($items as $item): ?>
                                    <div class="divide-y divide-dashed divide-border">
                                        <div class="flex sm:flex-nowrap flex-wrap items-start gap-8 relative py-6">
                                            <div class="sm:w-4/12 w-full relative z-10">
                                                <a href="<?= base_url ?>course-detail.html" class="block">
                                                    <img src="<?= $item['image'] ?>" class="max-w-full rounded-3xl" alt="..." />
                                                </a>
                                                <button type="button"
                                                    class="flex-shrink-0 absolute right-1/2 translate-x-1/2 -translate-y-6 w-11 h-11 inline-flex items-center justify-center bg-error rounded-full text-error-foreground shadow-2xl"
                                                    x-on:click="modalOpen = true">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18 18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="sm:w-8/12 w-full">

                                                <div class="bg-gradient-to-b from-secondary to-background rounded-3xl">

                                                    <div class="bg-background rounded-b-3xl space-y-2 p-5 mx-5">

                                                        <div class="flex items-center gap-2">

                                                            <span class="block w-1 h-1 bg-success rounded-full"></span>
                                                            <span class="font-bold text-xs text-success"><?php if ($item['status'] == 0) {
                                                                echo 'در حال برگزاری';
                                                            } else {
                                                                echo 'تکمیل شده';
                                                            } ?></span>
                                                        </div>
                                                        <h2 class="font-bold text-sm">
                                                            <span href="course-detail.html"
                                                                class="line-clamp-1 text-foreground transition-colors hover:text-primary"><?= $item['title'] ?>
                                                            </span>
                                                        </h2>
                                                    </div>
                                                    <div class="space-y-3 p-5">
                                                        <div class="flex items-center justify-between gap-5">
                                                            <div class="flex items-center gap-3">
                                                                <?php foreach ($teachers as $teacher) {
                                                                    if ($item['teacher_id'] == $teacher['id']) { ?>
                                                                        <div
                                                                            class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                                                            <img src="<?= $teacher['image'] ?>"
                                                                                class="w-full h-full object-cover" alt="..." />
                                                                        </div>
                                                                        <div class="flex flex-col items-start space-y-1">
                                                                            <span
                                                                                class="line-clamp-1 font-semibold text-xs text-muted">مدرس
                                                                                دوره:</span>
                                                                            <a href="<?= base_url ?>teachers.php?id=<?= $teacher['id'] ?>"
                                                                                class="line-clamp-1 font-bold text-xs text-foreground hover:text-primary">
                                                                                <?= $teacher['username'] ?></a>
                                                                        </div>
                                                                    <?php }
                                                                } ?>
                                                            </div>
                                                            <div class="flex flex-col items-end justify-center h-14">
                                                                <span class="line-through text-muted"><?php
                                                                if ($item['offvalue'] > 0) {
                                                                    echo number_format($item['offvalue']) . "<br>";
                                                                }
                                                                ?></span>
                                                                <div class="flex items-center gap-1">
                                                                    <span class="font-black text-xl text-foreground"><?php
                                                                    echo number_format($item['value']) . "<br>";
                                                                    ?></span>
                                                                    <span class="text-xs text-muted">تومان</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div x-cloak x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto">
                                            <div class="flex items-center justify-center min-h-screen px-4">
                                                <div x-show="modalOpen"
                                                    x-transition:enter="transition ease-out duration-300 transform"
                                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave="transition ease-in duration-200 transform"
                                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    class="relative w-full max-w-sm my-20 overflow-hidden transition-all transform bg-background border border-border rounded-2xl shadow-2xl z-20">
                                                    <div class="relative p-4">
                                                        <button
                                                            class="absolute left-4 text-muted-foreground focus:outline-none hover:text-error"
                                                            x-on:click="modalOpen = false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                                class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M6 18L18 6M6 6l12 12">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <div class="p-6">
                                                        <div class="flex flex-col items-center justify-center space-y-5">
                                                            <div
                                                                class="flex items-center justify-center w-14 h-14 bg-error rounded-full text-error-foreground">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                                    class="w-6 h-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                </svg>
                                                            </div>
                                                            <h3 class="font-bold text-foreground">آیا از حذف دوره از سبد اطمینان
                                                                دارید؟</h3>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-x-4 border-t border-border p-4">
                                                        <button type="button"
                                                            class="flex items-center justify-center gap-x-2 w-full bg-background border border-border rounded-xl text-foreground py-2 px-4"
                                                            x-on:click="modalOpen = false">
                                                            <span class="font-bold text-xs">لغو</span>
                                                        </button>

                                                        <button type="button"
                                                            class="flex items-center justify-center gap-x-2 w-full bg-error border border-transparent rounded-xl text-error-foreground py-2 px-4"
                                                            x-on:click="modalOpen = false">
                                                            <a href="<?= base_url ?>deletestore.php?id=<?= $item['id'] ?>"
                                                                class="font-bold text-xs">آره،حذف کن</a>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="fixed inset-0 bg-secondary/80 cursor-pointer transition-all z-10"
                                                    x-bind:class="modalOpen ? 'opacity-100 visible' : 'opacity-0 invisible'"
                                                    x-on:click="modalOpen = false">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                    $total += $item['value'];
                                endforeach; ?>
                            </div>


                            <div class="md:w-4/12 w-full md:sticky md:top-24">
                                <div class="space-y-5">
                                    <div class="bg-gradient-to-b from-secondary to-background rounded-2xl px-5 pb-5">
                                        <div class="bg-background rounded-b-3xl space-y-2 p-5 mb-5">
                                            <div class="flex items-center gap-3">
                                                <div class="flex items-center gap-1">
                                                    <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                                    <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                                </div>
                                                <div class="font-black text-foreground">اطلاعات پرداخت</div>
                                            </div>
                                        </div>
                                        <?php
                                        $discountAmount = 0; // مقدار پیش‌فرض
                                    
                                        if (isset($_POST['off'])) {
                                            $code = $_POST['code'];
                                            $select = $coon->prepare('SELECT * FROM percent WHERE code=? LIMIT 1');
                                            $select->bindValue(1, $code);
                                            $select->execute();
                                            $items = $select->fetch(PDO::FETCH_ASSOC);
                                            if ($items !== false) {  // بررسی اینکه $items نال یا فالس نباشد
                                                $off = $items['perc'];
                                                $discountAmount = ($total / 100) * $off;
                                                $total = $total - $discountAmount;
                                                $yes = true;
                                            } else {
                                                $not = true;
                                            }
                                        }
                                        ?>


                                        <div class="space-y-5">
                                            <form method="post">
                                                <div class="flex items-center gap-3 relative">
                                                    <span class="absolute right-3 text-muted">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5">
                                                            <path fill-rule="evenodd"
                                                                d="M4.5 2A2.5 2.5 0 0 0 2 4.5v3.879a2.5 2.5 0 0 0 .732 1.767l7.5 7.5a2.5 2.5 0 0 0 3.536 0l3.878-3.878a2.5 2.5 0 0 0 0-3.536l-7.5-7.5A2.5 2.5 0 0 0 8.38 2H4.5ZM5 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                    <input type="text"
                                                        class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-background border-0 focus:border-border rounded-xl text-sm text-foreground pr-10"
                                                        placeholder="کد تخفیف" name="code" <?php if (isset($code)) { ?>
                                                            value="<?= $code ?>" <?php } ?> />
                                                    <button type="submit" name="off"
                                                        class="h-11 inline-flex items-center justify-center gap-1 bg-primary rounded-xl text-primary-foreground transition-all hover:opacity-80 px-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </form>
                                            <div class="flex flex-col space-y-2">
                                                <div class="flex items-center justify-between gap-3">
                                                    <div class="font-bold text-xs text-foreground">جمع کل</div>
                                                    <div class="flex items-center gap-1">
                                                        <span class="font-black text-base text-foreground"><?php
                                                        echo number_format($total) . "<br>";
                                                        ?></span>
                                                        <span class="text-xs text-muted">تومان</span>
                                                    </div>
                                                </div>
                                                <div class="flex items-center justify-between gap-3">
                                                    <div class="font-bold text-xs text-foreground">تخفیف</div>
                                                    <div class="flex items-center gap-1">
                                                        <span class="font-black text-base text-foreground">

                                                            <?php
                                                            echo number_format($discountAmount) . "<br>";
                                                            ?></span>
                                                        <span class="text-xs text-muted">تومان</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="h-px bg-secondary"></div>
                                            <div class="flex items-center justify-between gap-3 text-primary">
                                                <div class="font-bold text-sm text-foreground">مبلغ قابل پرداخت</div>
                                                <div class="flex items-center gap-1">
                                                    <span class="font-black text-xl text-foreground"><?php
                                                    echo number_format($total) . "<br>";
                                                    ?></span>
                                                    <span class="text-xs text-muted">تومان</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <form method="post" action="pay.php">
                                        <input type="hidden" name="total" value="<?= $total ?>">
                                        <input type="hidden" name="user" value="<?= $_SESSION['id'] ?>">
                                        <button type="submit" name="pay"
                                            class="w-full h-11 inline-flex items-center justify-center gap-1 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4">
                                            <span class="font-semibold text-sm">تکمیل فرایند خرید</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                class="w-5 h-5">
                                                <path fill-rule="evenodd"
                                                    d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div style="  display: flex;justify-content: center;flex-direction: column">
                            <img style="height: 400px;" src="assets/images/basket.svg" alt="">
                            <span style="color: white;text-align: center;" class="font-black xs:text-2xl text-lg "> سبد خرید
                                شما خالی میباشد</span>

                        </div>
                    <?php } ?>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/app.js"></script>
    <?php
    if (isset($_SESSION['sweetalert'])) { ?>
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
                icon: "success",
                title: " دوره به سبد خرید اضافه شد "
            });
        </script>
    <?php }
    unset($_SESSION['sweetalert']);
    ?>
    <?php
    if ($not) { ?>
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
                title: " کد تخفیف نامعتبر است"
            });
        </script>
    <?php }
    ?>
    <?php
    if ($yes) { ?>
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
                icon: "success",
                title: " کد تخفیف با موفقیت اعمال شد "
            });
        </script>
    <?php }
    ?>
</body>


</html>