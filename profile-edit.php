<?php
include('database/pdo_connection.php');
$getId = $_SESSION['id'];
$error = null;
$succses = null;
if (!isset($_SESSION['login'])) {
    header("location:404.php");

}
// دریافت اطلاعات کاربر
$select = $coon->prepare("SELECT * FROM users WHERE id = ?");
$select->bindValue(1, $getId, PDO::PARAM_INT);
$select->execute();
$user = $select->fetch(PDO::FETCH_ASSOC);
$_SESSION['user_info'] = $user;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['sub'])) {
        // به‌روزرسانی اطلاعات کاربر
        $username = $_POST['username'];
        $email = $_POST['email'];

        $update = $coon->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $update->bindValue(1, $username, PDO::PARAM_STR);
        $update->bindValue(2, $email, PDO::PARAM_STR);
        $update->bindValue(3, $getId, PDO::PARAM_INT);
        $update->execute();
        $succses = true;
    }

    // پردازش آپلود فایل
    if (isset($_FILES['avatar'])) {
        $target_dir = "assets/image/";
        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));



        // بررسی اندازه فایل (در اینجا حداکثر 5MB)
        if ($_FILES["avatar"]["size"] > 5000000) {
            $uploadOk = 0;
        }

        // اجازه فرمت‌های خاصی از فایل‌ها
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            $uploadOk = 0;
        }

        // بررسی اینکه آیا فایل در مسیر هدف وجود ندارد
        if (file_exists($target_file)) {
            $uploadOk = 0;
        } else {
            // حذف عکس قبلی
            if (!empty($user['image']) && file_exists($user['image'])) {
                unlink($user['image']);
            }

            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                htmlspecialchars(basename($_FILES["avatar"]["name"]));
                $update = $coon->prepare("UPDATE users SET avatar = ? WHERE id = ?");
                $update->bindValue(1, $target_file, PDO::PARAM_STR);
                $update->bindValue(2, $getId, PDO::PARAM_INT);
                $update->execute();
            } else {
                $error = true;
            }
        }
    }
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
    <title>قالب آموزشی نابغه - پروفایل - داشبورد</title>


</head>

<body>

    <div class="flex flex-col min-h-screen bg-background">
        <header class="bg-background/80 backdrop-blur-xl border-b border-border sticky top-0 z-30"
            x-data="{ offcanvasOpen: false, openSearchBox: false }">

            <?php
            include("navbar.php");
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
                                    <span class="text-xs text-muted">خوش آمدید</span>
                                    <span
                                        class="line-clamp-1 font-semibold text-sm text-foreground cursor-default"><?= htmlspecialchars($user['username']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <ul class="flex flex-col space-y-3 bg-secondary rounded-2xl p-5">

                            <?php include("usersss.php") ?>
                        </ul>
                    </div>

                    <div class="lg:col-span-9 md:col-span-8">
                        <div class="space-y-10">
                            <div class="bg-background rounded-3xl p-5 mb-5">
                            </div>
                            <div class="space-y-5">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-1">
                                        <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                        <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                    </div>
                                    <div class="font-black text-foreground"> ویرایش پروفایل</div>

                                </div>
                                <form method="post" enctype="multipart/form-data" class="flex flex-col space-y-5">
                                    <div class="bg-background border border-border rounded-3xl p-5 mb-5">
                                        <div class="grid grid-cols-1 md:grid-cols-1 gap-5">
                                            <div class="flex gap-4 items-center w-full">
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
                                                <div class="flex flex-col gap-2 w-full" style="margin-right: 20px;">
                                                    <input type="file"
                                                        class="form-textarea w-full !ring-0 !ring-offset-0 bg-secondary border-0 focus:border-border border-border rounded-xl text-sm text-foreground p-5"
                                                        accept="image/png,image/gif,image/jpeg" name="avatar"
                                                        id="avatar">
                                                    <p class="font-black text-xs text-foreground">فایل‌های مجاز: JPG،
                                                        PNG و GIF. حداکثر اندازه مجاز: 5MB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-background border border-border rounded-3xl p-5 mb-5">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                            <div>
                                                <div class="font-black text-xs text-foreground">نام کاربری</div>
                                                <input name="username" type="text"
                                                    value="<?= htmlspecialchars($user['username']); ?>"
                                                    placeholder="عنوان مورد نظر خود را وارد کنید ..."
                                                    class="form-textarea w-full !ring-0 !ring-offset-0 bg-secondary border-0 focus:border-border border-border rounded-xl text-sm text-foreground p-5"
                                                    style="margin-top: 10px;">
                                            </div>
                                            <div>
                                                <div class="font-black text-xs text-foreground">ایمیل</div>
                                                <input name="email" type="email"
                                                    value="<?= htmlspecialchars($user['email']); ?>"
                                                    placeholder="عنوان مورد نظر خود را وارد کنید ..."
                                                    class="form-textarea w-full !ring-0 !ring-offset-0 bg-secondary border-0 focus:border-border border-border rounded-xl text-sm text-foreground p-5"
                                                    style="margin-top: 10px;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-background border border-border rounded-3xl p-5 mb-5">
                                        <div class="grid grid-cols-1 md:grid-cols-1 gap-5">
                                            <button type="submit" name="sub"
                                                class="h-10 inline-flex items-center justify-center gap-1 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4">
                                                <span class="font-semibold text-sm">ثبت اطلاعات</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-5 h-5">
                                                    <path fill-rule="evenodd"
                                                        d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php
        include("footer.php");
        ?>
    </div>


    <script src="assets/js/dependencies/alpinejs.min.js"></script>
    <script src="assets/js/dependencies/swiper-bundle.min.js"></script>
    <script src="assets/js/dependencies/plyr.min.js"></script>
    <script src="assets/js/dependencies/fancybox.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if ($succses == true) { ?>
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
                title: "اطلاعات کاربر با موفقیت به‌روزرسانی شد."
            });
        </script>
    <?php }
    ?>
    <?php
    if ($error == true) { ?>
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
                title: "متاسفانه اپلود شما با خطا مواجه شد"
            });
        </script>
    <?php }
    ?>
</body>


</html>