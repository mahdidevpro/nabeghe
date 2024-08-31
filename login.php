<?php
include("database/pdo_connection.php");

if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
}

if (isset($_SESSION['login'])) {
    header("location:home.php");
    exit();
}

$error = null;

if (
    isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['password']) && !empty($_POST['password'])
) {
    if (isset($_POST['sub'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $result = $coon->prepare("SELECT * FROM users WHERE email=?");
        $result->bindValue(1, $email);
        $result->execute();

        if ($result->rowCount() >= 1) {
            $user = $result->fetch(PDO::FETCH_ASSOC);

            // بررسی مطابقت رمز عبور با استفاده از password_verify
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $_POST['email'];
                $_SESSION['login'] = true;
                $_SESSION['alert_login'] = true;
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['password'] = $user['password'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['status'] = $user['status'];
                setcookie("email", $user['email'], time() + 86400);

                header("location: home.php");
                exit();
            } else {
                $error = true; // رمز عبور اشتباه است
            }
        } else {
            $error = true; // کاربر با این ایمیل یافت نشد
        }
    }
} else {
    if (!empty($_POST)) {
        $error = "فرم را پر کنید";
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
        <div class="w-full max-w-sm space-y-5">
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
                        <div class="font-black text-foreground">ورود </div>
                    </div>

                    <div class="text-sm text-muted space-y-3">
                        <p>درود 👋</p>
                        <p>لطفا ایمیل خود را وارد کنید</p>
                    </div>

                    <!-- form:field:wrapper -->
                    <div class="flex items-center relative">
                        <input required type="text" dir="rtl"
                            class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-secondary border-border focus:border-border rounded-xl text-sm text-foreground placeholder:text-right px-5"
                            name="email" type="email" id="email" placeholder="ایمیل" />
                    </div>
                    <div class="text-sm text-muted space-y-3">
                        <p>لطفا رمز عبور خود را وارد کنید</p>
                    </div>

                    <!-- form:field:wrapper -->
                    <div class="flex items-center relative">
                        <input required type="text" dir="rtl"
                            class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-secondary border-border focus:border-border rounded-xl text-sm text-foreground placeholder:text-right px-5"
                            name="password" id="password" type="password" placeholder="رمزعبور" />
                        <span id="toggle-password" class="toggle-password">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                    <style>
                        .password-container {
                            position: relative;
                            width: 300px;
                        }

                        .toggle-password {
                            position: absolute;
                            top: 26px;
                            left: 10px;
                            transform: translateY(-50%);
                            cursor: pointer;
                            font-size: 20px;
                        }
                    </style>
                    <button type="submit" name="sub"
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
                        اگر قبلا ثبت نام نکرده ای همین الان
                        <a href="register.php"
                            class="text-foreground transition-colors hover:text-primary hover:underline">ثبت نام</a>
                        کن
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
                title: " ایمیل یا رمزعبور اشتباه است "
            });
        </script>
    <?php } ?>
    <?php
    if (isset($_SESSION['alert_valid'])) { ?>
        <script>
            const Toasts = Swal.mixin({
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
            Toasts.fire({
                icon: "success",
                title: "عضویت شما با موفقیت انجام شد"
            });
        </script>
    <?php }
    unset($_SESSION['alert_valid']);
    ?>
</body>


</html>