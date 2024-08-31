<?php
$email = null;
$select = $coon->prepare("SELECT * FROM setting ");
$select->execute();
$settings = $select->fetchAll(PDO::FETCH_ASSOC);

$select = $coon->prepare("SELECT * FROM  menu ORDER BY sort ");
$select->execute();
$menus = $select->fetchAll(PDO::FETCH_ASSOC);
if (isset($_POST['sub'])) {
    $email = $_POST['email'];
    $select = $coon->prepare('INSERT INTO newsletters SET email=?');
    $select->bindValue(1, $email);
    $select->execute();
    $email = true;
}
?>

<footer class="pt-20">
    <div class="max-w-7xl px-4 mx-auto">
        <div class="flex items-center gap-3">
            <div class="flex-grow border-t border-border border-dashed"></div>
            <button type="button"
                class="flex-shrink-0 h-11 inline-flex items-center gap-3 bg-secondary rounded-full text-foreground transition-colors hover:text-primary px-4"
                id="scrollToTopBtn">
                <span class="text-xs">برگشت به بالا</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                </svg>
            </button>
        </div>
        <div class="flex lg:flex-nowrap flex-wrap gap-8 py-10">
            <div class="md:w-5/12 w-full">
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
            <?php foreach ($settings as $setting) { ?>
                <div class="md:w-7/12 w-full">
                    <div class="flex flex-wrap items-center gap-10">
                        <div class="flex items-center gap-5">
                            <span class="flex items-center justify-center w-12 h-12 bg-secondary rounded-full text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M2 3.5A1.5 1.5 0 0 1 3.5 2h1.148a1.5 1.5 0 0 1 1.465 1.175l.716 3.223a1.5 1.5 0 0 1-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 0 0 6.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 0 1 1.767-1.052l3.223.716A1.5 1.5 0 0 1 18 15.352V16.5a1.5 1.5 0 0 1-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 0 1 2.43 8.326 13.019 13.019 0 0 1 2 5V3.5Z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <div class="flex flex-col font-black space-y-2">
                                <span class="text-sm text-primary">شماره تلفن</span>
                                <span class="text-foreground"><?= $setting['call_number'] ?></span>
                            </div>
                        </div>
                        <div class="flex items-center gap-5">
                            <span class="flex items-center justify-center w-12 h-12 bg-secondary rounded-full text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <div class="flex flex-col font-black space-y-2">
                                <span class="text-sm text-primary">ساعات کاری</span>
                                <span class="text-foreground"><?= $setting['hours_work'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="flex md:flex-nowrap flex-wrap gap-8">
            <div class="md:w-5/12 w-full">
                <div class="bg-secondary rounded-3xl space-y-5 p-8">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-1">
                            <div class="w-1 h-1 bg-foreground rounded-full"></div>
                            <div class="w-2 h-2 bg-foreground rounded-full"></div>
                        </div>
                        <div class="font-black text-foreground">دربــــاره</div>
                    </div>
                    <p class="font-semibold text-sm text-muted">
                        <?= $setting['about'] ?>
                    </p>
                </div>
            </div>
            <div class="md:w-7/12 w-full">
                <div class="grid sm:grid-cols-5 gap-8">
                    <div class="sm:col-span-2 space-y-5">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1">
                                <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                <div class="w-2 h-2 bg-foreground rounded-full"></div>
                            </div>
                            <div class="font-black text-foreground">لینک های مفید</div>
                        </div>
                        <ul class="flex flex-col space-y-1">
                            <?php foreach ($menus as $menu) {
                                if ($menu['z'] == 0) { ?>
                                    <li>
                                        <a href="<?php if ($menu['src']) {
                                            echo base_url, $menu['src'];
                                        } elseif ($menu['src'] == null) {
                                            echo '#';
                                        } ?>"
                                            class="inline-flex font-semibold text-sm text-muted hover:text-primary"><?= $menu['title'] ?></a>
                                    </li>
                                <?php }
                            } ?>
                        </ul>
                    </div>
                    <div class="sm:col-span-3 space-y-5">
                        <div class="space-y-5">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1">
                                    <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                    <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                </div>
                                <div class="font-black text-foreground">خبرنامه</div>
                            </div>
                            <p class="text-sm text-muted">
                                برای اطلاع از جدیدترین اخبار و جشنوراه‌های تخفیفی نابغه ایمیل خود
                                را وارد کنید.
                            </p>

                            <form method="post">
                                <div class="flex items-center gap-3 relative">
                                    <span class="absolute right-3 text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
                                            <path
                                                d="M3 4a2 2 0 0 0-2 2v1.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 7.162V6a2 2 0 0 0-2-2H3Z">
                                            </path>
                                            <path
                                                d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z">
                                            </path>
                                        </svg>
                                    </span>
                                    <input type="email" name="email"
                                        class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-secondary border-0 focus:border-border rounded-xl text-sm text-foreground pr-10"
                                        placeholder="آدرس ایمیل" />
                                    <button type="submit" name="sub"
                                        class="h-11 inline-flex items-center justify-center gap-3 bg-primary rounded-xl whitespace-nowrap text-xs text-primary-foreground transition-all hover:opacity-80 px-4">ثبت
                                        ایمیل</button>
                                </div>
                            </form>
                        </div>
                        <div class="space-y-5">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1">
                                    <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                    <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                </div>
                                <div class="font-black text-foreground">شبکه های اجتماعی</div>
                            </div>
                            <ul class="flex flex-wrap items-center gap-5">
                                <li>
                                    <a href="#"
                                        class="flex items-center justify-center w-12 h-12 bg-secondary rounded-full text-foreground transition-colors hover:text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="w-5 h-5">
                                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex items-center justify-center w-12 h-12 bg-secondary rounded-full text-foreground transition-colors hover:text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="w-5 h-5">
                                            <path d="m22 2-7 20-4-9-9-4Z"></path>
                                            <path d="M22 2 11 13"></path>
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex items-center justify-center w-12 h-12 bg-secondary rounded-full text-foreground transition-colors hover:text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="w-5 h-5">
                                            <path
                                                d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17">
                                            </path>
                                            <path d="m10 15 5-3-5-3z"></path>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3 py-5">
            <p class="text-xs text-muted">&#169; کليه حقوق محفوظ است</p>
            <div class="flex-grow border-t border-border border-dashed"></div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if ($email) { ?>
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
            title: "ایمیل شما با موفقیت ثبت شد"
        });
    </script>
<?php } ?>