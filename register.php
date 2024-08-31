<?php
include ("database/pdo_connection.php");
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['login'])) {
    header("location:home.php");
    exit();
}

$error = null;
$errorStrLen = null;
$successSign = null;

if (
    isset($_POST['username']) && !empty($_POST['username']) &&
    isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['password']) && !empty($_POST['password']) &&
    isset($_POST['confirm']) && !empty($_POST['confirm'])
) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm'];

    // بررسی مطابقت رمز عبور و تکرار آن
    if ($password === $confirmPassword) {
        // بررسی طول رمز عبور
        if (strlen($password) >= 4) {
            // بررسی موجودیت ایمیل در دیتابیس
            $sql = "SELECT * FROM users WHERE email=?";
            $statement = $coon->prepare($sql);
            $statement->execute([$email]);
            $user = $statement->fetch();

            if (!$user) {
                // هش کردن رمز عبور
                $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
                // بررسی موفقیت در هش کردن رمز عبور
                if ($passwordHashed) {
                    $active = rand(100000, 999999);

                    // درج اطلاعات کاربر در دیتابیس
                    $result = $coon->prepare("INSERT INTO users (username, email, password, active) VALUES (?, ?, ?, ?)");
                    $executed = $result->execute([$username, $email, $passwordHashed, $active]);

                    if ($executed) {
                        // ارسال ایمیل با استفاده از PHPMailer
                        $mail = new PHPMailer(true);
                        try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'mahdicalaf85@gmail.com';
                            $mail->Password = 'hlno fzlp yufb smmi';
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;

                            $mail->setFrom('mahdicalaf85@gmail.com', 'Academy Genius');
                            $mail->addAddress($email);

                            $mail->isHTML(true);
                            $mail->Subject = 'Academy Genius - Activation Code';
                            $mail->Body = "کد فعالسازی شما: $active";
                            $mail->AltBody = 'کد فعالسازی برای ثبت نام در نابغه: ' . $active;

                            $mail->send();
                            echo 'ایمیل با موفقیت ارسال شد.';
                        } catch (Exception $e) {
                            echo "خطا در ارسال ایمیل: {$mail->ErrorInfo}";
                        }

                        // تنظیم جلسه و هدایت به صفحه تأیید
                        $_SESSION['alert_register'] = true;
                        header("location:validation.php");
                        exit();
                    } else {
                        $error = "خطا در ثبت اطلاعات در دیتابیس.";
                    }
                } else {
                    $error = "خطا در هش کردن رمز عبور.";
                }
            } else {
                $error = "این ایمیل قبلاً ثبت شده است.";
            }
        } else {
            $errorStrLen = "رمز عبور باید حداقل 4 کاراکتر باشد.";
        }
    } else {
        $error = "رمز عبور و تکرار آن باید یکسان باشند.";
    }
}
?>

<!doctype html>
<html lang="fa-IR">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg" />
    <link rel="stylesheet" href="assets/css/dependencies/swiper-bundle.min.css" />
    <link rel="stylesheet" href="assets/css/dependencies/plyr.min.css" />
    <link rel="stylesheet" href="assets/css/dependencies/fancybox.min.css" />
    <link rel="stylesheet" href="assets/css/fonts.css" />
    <link rel="stylesheet" href="assets/css/app.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>قالب آموزشی نابغه - ورود و ثبت نام</title>
</head>

<body>

    <div class="min-h-screen flex items-center justify-center bg-background p-5">
        <div class="  space-y-5" style="width: 800px;">
            <div class="bg-gradient-to-b from-secondary to-background rounded-3xl space-y-5 px-5 pb-5">
                <div class="bg-background rounded-b-3xl space-y-2 p-5" style="text-align: center;">
                    <a href="home.html" class="inline-flex items-center gap-2 text-primary" style="direction: rtl;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path
                                d="M12 .75a8.25 8.25 0 0 0-4.135 15.39c.686.398 1.115 1.008 1.134 1.623a.75.75 0 0 0 .577.706c.352.083.71.148 1.074.195.323.041.6-.218.6-.544v-4.661a6.714 6.714 0 0 1-.937-.171.75.75 0 1 1 .374-1.453 5.261 5.261 0 0 0 2.626 0 .75.75 0 1 1 .374 1.452 6.712 6.712 0 0 1-.937.172v4.66c0 .327.277.586.6.545.364-.047.722-.112 1.074-.195a.75.75 0 0 0 .577-.706c.02-.615.448-1.225 1.134-1.623A8.25 8.25 0 0 0 12 .75Z" />
                            <path fill-rule="evenodd"
                                d="M9.013 19.9a.75.75 0 0 1 .877-.597 11.319 11.319 0 0 0 4.22 0 .75.75 0 1 1 .28 1.473 12.819 12.819 0 0 1-4.78 0 .75.75 0 0 1-.597-.876ZM9.754 22.344a.75.75 0 0 1 .824-.668 13.682 13.682 0 0 0 2.844 0 .75.75 0 1 1 .156 1.492 15.156 15.156 0 0 1-3.156 0 .75.75 0 0 1-.668-.824Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex flex-col items-start">
                            <span class="font-semibold text-sm text-muted">آکــــادمـــی</span>
                            <span class="font-black text-xl">نـــابــــغه</span>
                        </span>
                    </a>
                </div>

                <!-- auth:verification:form -->
                <form method="post" class="space-y-3" style="direction: rtl;">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-1">
                            <div class="w-1 h-1 bg-foreground rounded-full"></div>
                            <div class="w-2 h-2 bg-foreground rounded-full"></div>
                        </div>
                        <div class="font-black text-foreground">ثبت نام</div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div class="flex items-center relative">
                            <input name="username" type="text" value="" placeholder="نام کاربری را وارد کنید ..."
                                class="form-textarea w-full !ring-0 !ring-offset-0 bg-secondary border-0 focus:border-border border-border rounded-xl text-sm text-foreground p-5">
                        </div>
                        <div class="flex items-center relative">
                            <input name="email" type="text" value="" placeholder="ایمیل خود را وارد کنید ..."
                                class="form-textarea w-full !ring-0 !ring-offset-0 bg-secondary border-0 focus:border-border border-border rounded-xl text-sm text-foreground p-5">
                        </div>
                        <div class="flex items-center relative">
                            <input required type="text" dir="rtl"
                                class="form-textarea w-full !ring-0 !ring-offset-0 bg-secondary border-0 focus:border-border border-border rounded-xl text-sm text-foreground p-5"
                                name="password" id="password" type="password"
                                placeholder="کلمه عبور  را وارد کنید..." />
                            <span id="toggle-password" class="toggle-password">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>

                        <div class="flex items-center relative">

                            <input required type="password" dir="rtl"
                                class="form-textarea w-full !ring-0 !ring-offset-0 bg-secondary border-0 focus:border-border border-border rounded-xl text-sm text-foreground p-5"
                                name="confirm" id="repassword" placeholder="تکرار کلمه عبور را وارد کنید..." />
                            <span id="toggle-repassword" class="toggle-password">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                    </div>


                    <!-- form:field:wrapper -->

                    <style>
                        .password-container {
                            position: relative;
                            width: 300px;
                        }

                        .toggle-password {
                            position: absolute;
                            top: 34px;
                            left: 10px;
                            transform: translateY(-50%);
                            cursor: pointer;
                            font-size: 20px;
                        }
                    </style>




                    <!-- end form:field:wrapper -->

                    <!-- form:submit button -->
                    <button type="submit"
                        class="flex items-center justify-center gap-1 w-full h-10 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4">
                        <span class="font-semibold text-sm">برو بریم</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <!-- end form:submit button -->
                </form>
                <div class="bg-secondary rounded-xl space-y-5 p-5">
                    <div class="font-medium text-xs text-center text-muted">
                        اگر قبلا ثبت نام کرده ای همین الان
                        <a href="login.php"
                            class="text-foreground transition-colors hover:text-primary hover:underline">وارد</a>
                        نابغه شو
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="assets/js/dependencies/alpinejs.min.js"></script>
    <script src="assets/js/dependencies/swiper-bundle.min.js"></script>
    <script src="assets/js/dependencies/plyr.min.js"></script>
    <script src="assets/js/dependencies/fancybox.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if ($error) { ?>
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
                title: ' ایمیل یا رمزعبور اشتباه است '
            });
        </script>
    <?php } ?>

    <?php if ($errorStrLen) { ?>
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
                title: 'رمز عبور باید بیشتر از 4 کاراکتر باشد'
            });
        </script>
    <?php } ?>
</body>


</html>