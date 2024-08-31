<?php
$coun = 0;


$select = $coon->prepare("SELECT * FROM  menu ORDER BY sort ");
$select->execute();

$menus = $select->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['login'])) {
    $getId = $_SESSION['id'];
    $select = $coon->prepare('SELECT *  FROM store  WHERE user_id=? AND statuse=0');
    $select->bindValue(1, $getId);
    $select->execute();
    $number = $select->rowCount();
}



?>

<header class="bg-background/80 backdrop-blur-xl border-b border-border sticky top-0 z-30"
    x-data="{ offcanvasOpen: false, openSearchBox: false }">

    <div class="max-w-7xl relative px-4 mx-auto">
        <div class="flex items-center gap-8 h-20">
            <div class="flex items-center gap-3">
                <button type="button"
                    class="lg:hidden inline-flex items-center justify-center relative w-10 h-10 bg-secondary rounded-full text-foreground"
                    x-on:click="offcanvasOpen = true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <a href="<?= base_url ?>home.php" class="inline-flex items-center gap-2 text-primary">
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
            <div class="lg:flex hidden items-center gap-5">
                <ul class="flex items-center gap-5">
                    <li class="relative group/submenu">
                        <?php foreach ($menus as $menu) {
                            if ($menu['z'] == 0) { ?>
                                <a href="<?php if ($menu['src']) {
                                    echo base_url, $menu['src'];
                                } elseif ($menu['src'] == null) {
                                    echo '#';
                                } ?>"
                                    class="inline-flex items-center gap-1 text-muted transition-colors hover:text-foreground">
                                    <span class="font-semibold text-sm"><?= $menu['title'] ?></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-5 h-5 transition-transform group-hover/submenu:rotate-180">
                                        <?php foreach ($menus as $z) {
                                            if ($menu['id'] == $z['z']) { ?>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            <?php }
                                        } ?>
                                    </svg>
                                </a>
                                <ul
                                    class="absolute top-full right-0 w-56 bg-background border border-border rounded-xl shadow-2xl shadow-black/5 opacity-0 invisible transition-all group-hover/submenu:opacity-100 group-hover/submenu:visible p-3 mt-2">
                                    <?php foreach ($menus as $item) {
                                        if ($menu['id'] == $item['z']) { ?>
                                            <li>
                                                <a href="<?= base_url ?>series.php?slug=<?= $item['src'] ?>"
                                                    class="flex items-center gap-2 w-full text-foreground transition-colors hover:text-primary px-3 py-2">
                                                    <span class="font-semibold text-xs"><?= $item['title'] ?></span>
                                                </a>
                                            </li>
                                        <?php }
                                    } ?>
                                </ul>
                            </li>
                        <?php }
                        } ?>
                </ul>
            </div>
            <div class="flex items-center md:gap-5 gap-3 mr-auto">
                <button type="button"
                    class="hidden lg:inline-flex items-center justify-center w-10 h-10 bg-secondary rounded-full text-foreground"
                    id="dark-mode-button">
                    <span class="light-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </span>
                    <span class="dark-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                        </svg>
                    </span>
                </button>
                <button type="button"
                    class="hidden lg:inline-flex items-center justify-center w-10 h-10 bg-secondary rounded-full text-foreground"
                    x-on:click="openSearchBox = true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>



                <?php if (isset($_SESSION['login'])) { ?>
                    <a href="<?= base_url ?>cart.php"
                        class="inline-flex items-center justify-center relative w-10 h-10 bg-secondary rounded-full text-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <span class="absolute -top-1 left-0 flex h-5 w-5">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span
                                class="relative inline-flex items-center justify-center rounded-full h-5 w-5 bg-primary text-primary-foreground font-bold text-xs">
                                <?= $number ?>
                            </span>


                        </span>
                    </a>
                    <div class="relative" x-data="{ isOpen: false }">
                        <button class="flex items-center sm:gap-3 gap-1" x-on:click="isOpen = !isOpen">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                <?php
                                if (isset($_SESSION['user_info'])) {
                                    $user = $_SESSION['user_info'];
                                    if ($user['avatar'] != null) { ?>
                                        <img src="<?= htmlspecialchars($user['avatar']); ?>" class="w-full h-full object-cover"
                                            alt="...">
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
                                    <?php }
                                } ?>
                            </div>
                            <span class="xs:flex flex-col items-start hidden text-xs space-y-1">
                                <span class="font-semibold text-foreground"><?php echo $_SESSION['username'] ?></span>
                                <span class="font-semibold text-muted">خوش آمـــدید</span>
                            </span>
                            <span class="text-foreground transition-transform" x-bind:class="isOpen ? 'rotate-180' : ''">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span>
                        </button>
                        <div class="absolute top-full left-0 pt-3" x-show="isOpen" x-on:click.outside="isOpen = false">

                            <div class="w-56 bg-background border border-border rounded-xl shadow-2xl shadow-black/5 p-3">
                                <a href="<?= base_url ?>profile.php"
                                    class="flex items-center gap-2 w-full text-foreground transition-colors hover:text-primary px-3 py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                                    </svg>
                                    <span class="font-semibold text-xs"> پروفایل</span>
                                </a>
                                <a href="<?= base_url ?>profile-password.php"
                                    class="flex items-center gap-2 w-full text-foreground transition-colors hover:text-primary px-3 py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-pen-fill" viewBox="0 0 16 16">
                                        <path
                                            d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001" />
                                    </svg>
                                    <span class="font-semibold text-xs"> تغییر کلمه عبور </span>
                                </a>
                                <a href="<?= base_url ?>profile-tiket.php"
                                    class="flex items-center gap-2 w-full text-foreground transition-colors hover:text-primary px-3 py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                    </svg>
                                    <span class="font-semibold text-xs">مدیریت تیکت ها</span>
                                </a>
                                <div
                                    class="flex items-center gap-2 w-full text-foreground transition-colors hover:text-primary px-3 py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-person-circle" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                        <path fill-rule="evenodd"
                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                    </svg>
                                    <span class="font-semibold text-xs"> <?php if ($_SESSION['role'] == 3) { ?> مدیر
                                        <?php } elseif ($_SESSION['role'] == 2) { ?> مدرس<?php } else { ?>کاربر
                                            عادی<?php } ?></span>
                                </div>
                                <?php if ($_SESSION['role'] == 3) { ?>
                                    <a href="<?= base_url ?>Panel/index.php"
                                        class="flex items-center gap-2 w-full text-foreground transition-colors hover:text-primary px-3 py-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-diagram-2" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H11a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 5 7h2.5V6A1.5 1.5 0 0 1 6 4.5zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5zM3 11.5A1.5 1.5 0 0 1 4.5 10h1A1.5 1.5 0 0 1 7 11.5v1A1.5 1.5 0 0 1 5.5 14h-1A1.5 1.5 0 0 1 3 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1A1.5 1.5 0 0 1 9 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                                        </svg>
                                        <span class="font-semibold text-xs"> مدیریت سایت </span>
                                    </a>
                                <?php } ?>
                                <?php if ($_SESSION['role'] == 2) { ?>
                                    <a href="<?= base_url ?>Panel/index.php?id=<?= $getId ?>"
                                        class="flex items-center gap-2 w-full text-foreground transition-colors hover:text-primary px-3 py-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-diagram-2" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H11a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 5 7h2.5V6A1.5 1.5 0 0 1 6 4.5zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5zM3 11.5A1.5 1.5 0 0 1 4.5 10h1A1.5 1.5 0 0 1 7 11.5v1A1.5 1.5 0 0 1 5.5 14h-1A1.5 1.5 0 0 1 3 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1A1.5 1.5 0 0 1 9 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                                        </svg>
                                        <span class="font-semibold text-xs"> پنل کاربری </span>
                                    </a>
                                <?php } ?>
                                <button type="button"
                                    class="flex items-center gap-2 w-full text-red-500 transition-colors hover:text-red-700 px-3 py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                    </svg>
                                    <a class="font-semibold text-xs" href="<?= base_url ?>logout.php">خروج از حساب</a>

                                </button>
                            </div>

                        </div>
                    </div>
                <?php } else { ?>
                    <a href="<?= base_url ?>login.php" type="submit"
                        class="h-10 inline-flex items-center justify-center gap-1 bg-primary text-primary-foreground transition-all hover:opacity-80 px-4 mr-auto"
                        style="border-radius: 10%;">
                        <span class="font-semibold text-sm">ورود / عضویت </span>

                    </a>
                <?php } ?>


            </div>
        </div>

        <div class="absolute inset-x-4 hidden lg:flex flex-col h-full bg-background transition-all"
            x-bind:class="openSearchBox ? 'top-0' : '-top-full'">
            <form action="series.php" method="post" class="h-full">
                <div class="flex items-center h-full relative">
                    <input type="text" name="search"
                        class="form-input w-full !ring-0 !ring-offset-0 bg-background border-0 focus:border-0 text-foreground"
                        placeholder="نام دوره،مقاله و یا دسته بندی را وارد نمایید.." />
                    <button type="button"
                        class="absolute left-0 inline-flex items-center justify-center w-9 h-9 bg-secondary rounded-full text-muted transition-colors hover:text-red-500"
                        x-on:click="openSearchBox = false">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div x-cloak>

        <div class="fixed inset-y-0 right-0 xs:w-80 w-72 h-screen bg-background rounded-l-2xl overflow-y-auto transition-transform z-50"
            x-bind:class="offcanvasOpen ? '!translate-x-0' : 'translate-x-full'">

            <div class="flex items-center justify-between gap-x-4 sticky top-0 bg-background p-4 z-10">
                <a href="<?= base_url ?>home.php" class="inline-flex items-center gap-2 text-primary">
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


                <button x-on:click="offcanvasOpen = false"
                    class="text-foreground focus:outline-none hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="space-y-5 p-4">
                <form action="#">
                    <div class="flex items-center relative">
                        <input type="text"
                            class="form-input w-full h-10 !ring-0 !ring-offset-0 bg-secondary border border-border focus:border-border rounded-xl text-sm text-foreground pr-10"
                            placeholder="دنبال چی میگردی؟" />
                        <span class="absolute right-3 text-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </div>
                </form>
                <div class="h-px bg-border"></div>
                <label class="relative w-full flex items-center justify-between cursor-pointer">
                    <span class="font-bold text-sm text-foreground">تم تاریک</span>
                    <input type="checkbox" class="sr-only peer" id="dark-mode-checkbox" />
                    <div
                        class="w-11 h-5 relative bg-background border-2 border-border peer-focus:outline-none rounded-full peer peer-checked:after:left-[26px] peer-checked:after:bg-background after:content-[''] after:absolute after:left-0.5 after:top-0.5 after:bg-border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-primary peer-checked:border-primary">
                    </div>
                </label>
                <div class="h-px bg-border"></div>
                <?php foreach ($menus as $menu) {
                    if ($menu['z'] == 0) { ?>

                        <ul class="flex flex-col space-y-1">
                            <li x-data="{ open: false }">
                                <a href="<?php if ($menu['src']) {
                                    echo base_url, $menu['src'];
                                } elseif ($menu['src'] == null) {
                                    echo '#';
                                } ?>" type="button"
                                    class="w-full flex items-center gap-x-2 relative transition-all hover:text-foreground py-2"
                                    x-bind:class="open ? 'text-foreground' : 'text-muted'" x-on:click="open = !open">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M3 9a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 9Zm0 6.75a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="font-semibold text-xs"> <?php echo $menu['title'] ?> </span>
                                    <span class="absolute left-3" x-bind:class="open ? 'rotate-180' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <?php
                                            foreach ($menus as $item) {
                                                if ($menu['id'] == $item['z']) { ?>

                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                                <?php }
                                            } ?>

                                        </svg>
                                    </span>
                                </a>
                                <?php foreach ($menus as $ul) {
                                    if ($menu['id'] == $ul['z']) { ?>

                                        <ul class="flex flex-col relative before:content-[''] before:absolute before:inset-y-3 before:right-3 before:w-px before:bg-zinc-200 dark:before:bg-zinc-900 py-3 pr-5"
                                            x-show="open">


                                            <li>
                                                <a href="<?= base_url ?>series?slug=<?= $ul['src'] ?>"
                                                    class="w-full flex items-center gap-x-2 bg-transparent rounded-xl text-zinc-400 transition-all group/nav-item hover:text-black dark:hover:text-white py-2 px-3">
                                                    <span
                                                        class="inline-flex w-2 h-px bg-zinc-200 dark:bg-zinc-800 transition-all group-hover/nav-item:w-4 "></span>
                                                    <span class="font-medium text-xs"><?php echo $ul['title'] ?> </span>
                                                </a>
                                            </li>

                                        </ul>
                                    <?php }
                                } ?>

                            </li>

                        </ul>
                    <?php }
                } ?>

            </div>
        </div>


        <div class="fixed inset-0 h-screen bg-secondary/80 cursor-pointer transition-all duration-1000 z-40"
            x-bind:class="offcanvasOpen ? 'opacity-100 visible' : 'opacity-0 invisible'"
            x-on:click="offcanvasOpen = false">
        </div>
    </div>
</header>