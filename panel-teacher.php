<?php 
include ('database/pdo_connection.php')
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
                                    <img src="assets/images/avatars/01.jpg" class="w-full h-full object-cover"
                                        alt="..." />
                                </div>
                                <div class="flex flex-col items-start space-y-1">
                                    <span class="text-xs text-muted">خوش آمدید</span>
                                    <span class="line-clamp-1 font-semibold text-sm text-foreground cursor-default">جلال
                                        بهرامی راد</span>
                                </div>
                            </div>
                        </div>
                        <ul class="flex flex-col space-y-3 bg-secondary rounded-2xl p-5">
                            <li>
                                <a href="<?= base_url?>profile.php"
                                    class="w-full h-11 inline-flex items-center text-right gap-3 bg-primary rounded-full text-primary-foreground px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M1.5 7.125c0-1.036.84-1.875 1.875-1.875h6c1.036 0 1.875.84 1.875 1.875v3.75c0 1.036-.84 1.875-1.875 1.875h-6A1.875 1.875 0 0 1 1.5 10.875v-3.75Zm12 1.5c0-1.036.84-1.875 1.875-1.875h5.25c1.035 0 1.875.84 1.875 1.875v8.25c0 1.035-.84 1.875-1.875 1.875h-5.25a1.875 1.875 0 0 1-1.875-1.875v-8.25ZM3 16.125c0-1.036.84-1.875 1.875-1.875h5.25c1.036 0 1.875.84 1.875 1.875v2.25c0 1.035-.84 1.875-1.875 1.875h-5.25A1.875 1.875 0 0 1 3 18.375v-2.25Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-semibold text-xs">پیشخوان</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url?> profile-courses.php"
                                    class="w-full h-11 inline-flex items-center text-right gap-3 bg-background rounded-full text-muted transition-colors hover:bg-primary hover:text-primary-foreground px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5">
                                        </path>
                                    </svg>
                                    <span class="font-semibold text-xs">دوره ها</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url?>user_agent.php"
                                    class="w-full h-11 inline-flex items-center text-right gap-3 bg-background rounded-full text-muted transition-colors hover:bg-primary hover:text-primary-foreground px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cpu-fill" viewBox="0 0 16 16">
  <path d="M6.5 6a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
  <path d="M5.5.5a.5.5 0 0 0-1 0V2A2.5 2.5 0 0 0 2 4.5H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2A2.5 2.5 0 0 0 4.5 14v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14a2.5 2.5 0 0 0 2.5-2.5h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14A2.5 2.5 0 0 0 11.5 2V.5a.5.5 0 0 0-1 0V2h-1V.5a.5.5 0 0 0-1 0V2h-1V.5a.5.5 0 0 0-1 0V2h-1zm1 4.5h3A1.5 1.5 0 0 1 11 6.5v3A1.5 1.5 0 0 1 9.5 11h-3A1.5 1.5 0 0 1 5 9.5v-3A1.5 1.5 0 0 1 6.5 5"/>
</svg>
                                    <span class="font-semibold text-xs">دستگاه های فعال</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url?>profile-financial.php"
                                    class="w-full h-11 inline-flex items-center text-right gap-3 bg-background rounded-full text-muted transition-colors hover:bg-primary hover:text-primary-foreground px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3">
                                        </path>
                                    </svg>
                                    <span class="font-semibold text-xs">مالی و اشتراک</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url?>profile-tiket.php"
                                    class="w-full h-11 inline-flex items-center text-right gap-3 bg-background rounded-full text-muted transition-colors hover:bg-primary hover:text-primary-foreground px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                    </svg>
                                    <span class="font-semibold text-xs">مدیریت تیکت ها</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url?>profile-notifications.php"
                                    class="w-full h-11 inline-flex items-center text-right gap-3 bg-background rounded-full text-muted transition-colors hover:bg-primary hover:text-primary-foreground px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0">
                                        </path>
                                    </svg>
                                    <span class="font-semibold text-xs">اعلانات</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url?>profile-edit.php"
                                    class="w-full h-11 inline-flex items-center text-right gap-3 bg-background rounded-full text-muted transition-colors hover:bg-primary hover:text-primary-foreground px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125">
                                        </path>
                                    </svg>
                                    <span class="font-semibold text-xs">ویرایش پروفایل</span>
                                </a>
                            </li>
                            <li>
                                <button type="button"
                                    class="w-full h-11 inline-flex items-center text-right gap-3 bg-background rounded-full text-muted transition-colors hover:bg-primary hover:text-primary-foreground px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15">
                                        </path>
                                    </svg>
                                    <span class="font-semibold text-xs">خروج از حساب</span>
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="lg:col-span-9 md:col-span-8">
                        <div class="space-y-10">
                            <div class="grid lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-5 mb-8">
                                <div class="flex items-center gap-3 bg-secondary rounded-2xl cursor-default p-3">
                                    <span
                                        class="flex items-center justify-center w-12 h-12 bg-background rounded-full text-cyan-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
                                            <path
                                                d="M10 1a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 1ZM5.05 3.05a.75.75 0 0 1 1.06 0l1.062 1.06A.75.75 0 1 1 6.11 5.173L5.05 4.11a.75.75 0 0 1 0-1.06ZM14.95 3.05a.75.75 0 0 1 0 1.06l-1.06 1.062a.75.75 0 0 1-1.062-1.061l1.061-1.06a.75.75 0 0 1 1.06 0ZM3 8a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 3 8ZM14 8a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 14 8ZM7.172 10.828a.75.75 0 0 1 0 1.061L6.11 12.95a.75.75 0 0 1-1.06-1.06l1.06-1.06a.75.75 0 0 1 1.06 0ZM10.766 7.51a.75.75 0 0 0-1.37.365l-.492 6.861a.75.75 0 0 0 1.204.65l1.043-.799.985 3.678a.75.75 0 0 0 1.45-.388l-.978-3.646 1.292.204a.75.75 0 0 0 .74-1.16l-3.874-5.764Z">
                                            </path>
                                        </svg>
                                    </span>
                                    <div class="flex flex-col items-start text-right space-y-1">
                                        <span class="font-bold text-xs text-muted line-clamp-1">باقیمانده اشتراک</span>
                                        <span class="font-bold text-sm text-foreground line-clamp-1">عضو ویژه
                                            نیستید</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 bg-secondary rounded-2xl cursor-default p-3">
                                    <span
                                        class="flex items-center justify-center w-12 h-12 bg-background rounded-full text-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
                                            <path fill-rule="evenodd"
                                                d="M9.664 1.319a.75.75 0 0 1 .672 0 41.059 41.059 0 0 1 8.198 5.424.75.75 0 0 1-.254 1.285 31.372 31.372 0 0 0-7.86 3.83.75.75 0 0 1-.84 0 31.508 31.508 0 0 0-2.08-1.287V9.394c0-.244.116-.463.302-.592a35.504 35.504 0 0 1 3.305-2.033.75.75 0 0 0-.714-1.319 37 37 0 0 0-3.446 2.12A2.216 2.216 0 0 0 6 9.393v.38a31.293 31.293 0 0 0-4.28-1.746.75.75 0 0 1-.254-1.285 41.059 41.059 0 0 1 8.198-5.424ZM6 11.459a29.848 29.848 0 0 0-2.455-1.158 41.029 41.029 0 0 0-.39 3.114.75.75 0 0 0 .419.74c.528.256 1.046.53 1.554.82-.21.324-.455.63-.739.914a.75.75 0 1 0 1.06 1.06c.37-.369.69-.77.96-1.193a26.61 26.61 0 0 1 3.095 2.348.75.75 0 0 0 .992 0 26.547 26.547 0 0 1 5.93-3.95.75.75 0 0 0 .42-.739 41.053 41.053 0 0 0-.39-3.114 29.925 29.925 0 0 0-5.199 2.801 2.25 2.25 0 0 1-2.514 0c-.41-.275-.826-.541-1.25-.797a6.985 6.985 0 0 1-1.084 3.45 26.503 26.503 0 0 0-1.281-.78A5.487 5.487 0 0 0 6 12v-.54Z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <div class="flex flex-col items-start text-right space-y-1">
                                        <span class="font-bold text-xs text-muted line-clamp-1">درحال یادگیری</span>
                                        <span class="font-bold text-sm text-foreground line-clamp-1">۷ دوره</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 bg-secondary rounded-2xl cursor-default p-3">
                                    <span
                                        class="flex items-center justify-center w-12 h-12 bg-background rounded-full text-yellow-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
                                            <path fill-rule="evenodd"
                                                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <div class="flex flex-col items-start text-right space-y-1">
                                        <span class="font-bold text-xs text-muted line-clamp-1">امتیازات</span>
                                        <span class="font-bold text-sm text-foreground line-clamp-1">۸۵,۴۸۰ ستاره</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 bg-secondary rounded-2xl cursor-default p-3">
                                    <span
                                        class="flex items-center justify-center w-12 h-12 bg-background rounded-full text-violet-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
                                            <path
                                                d="M1 4.25a3.733 3.733 0 0 1 2.25-.75h13.5c.844 0 1.623.279 2.25.75A2.25 2.25 0 0 0 16.75 2H3.25A2.25 2.25 0 0 0 1 4.25ZM1 7.25a3.733 3.733 0 0 1 2.25-.75h13.5c.844 0 1.623.279 2.25.75A2.25 2.25 0 0 0 16.75 5H3.25A2.25 2.25 0 0 0 1 7.25ZM7 8a1 1 0 0 1 1 1 2 2 0 1 0 4 0 1 1 0 0 1 1-1h3.75A2.25 2.25 0 0 1 19 10.25v5.5A2.25 2.25 0 0 1 16.75 18H3.25A2.25 2.25 0 0 1 1 15.75v-5.5A2.25 2.25 0 0 1 3.25 8H7Z">
                                            </path>
                                        </svg>
                                    </span>
                                    <div class="flex flex-col items-start text-right space-y-1">
                                        <span class="font-bold text-xs text-muted line-clamp-1">موجودی کیف پول</span>
                                        <div class="flex items-center gap-1">
                                            <span class="font-bold text-sm text-foreground">۱,۰۷۹,۰۰۰</span>
                                            <span class="text-xs text-muted">تومان</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-5">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-1">
                                        <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                        <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                    </div>
                                    <div class="font-black text-foreground">دوره های در حال یادگیری</div>
                                </div>
                                <div class="swiper col3-swiper-slider">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="relative">
                                                <div class="relative z-10">
                                                    <a href="<?= base_url?>course-detail.php" class="block">
                                                        <img src="assets/images/courses/01.jpg"
                                                            class="max-w-full rounded-3xl" alt="..." />
                                                    </a>
                                                    <a href="<?= base_url?>course-category.php"
                                                        class="absolute left-3 top-3 h-11 inline-flex items-center justify-center gap-1 bg-black/20 rounded-full text-white transition-all hover:opacity-80 px-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="currentColor" class="w-6 h-6">
                                                            <path fill-rule="evenodd"
                                                                d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="font-semibold text-sm">فرانت اند</span>
                                                    </a>
                                                </div>
                                                <div class="bg-background rounded-b-3xl -mt-12 pt-12">
                                                    <div
                                                        class="bg-gradient-to-b from-background to-secondary rounded-b-3xl space-y-2 p-5 mx-5">
                                                        <div class="flex items-center gap-2">
                                                            <span class="block w-1 h-1 bg-success rounded-full"></span>
                                                            <span class="font-bold text-xs text-success">تکمیل
                                                                شده</span>
                                                        </div>
                                                        <h2 class="font-bold text-sm">
                                                            <a href="<?= base_url?>course-detail.php"
                                                                class="line-clamp-1 text-foreground transition-colors hover:text-primary">دوره
                                                                پروژه محور React و Next</a>
                                                        </h2>
                                                    </div>
                                                    <div class="space-y-3 p-5">
                                                        <div class="flex flex-wrap items-center gap-3">
                                                            <div class="flex items-center gap-1 text-muted">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20" fill="currentColor"
                                                                    class="w-5 h-5">
                                                                    <path
                                                                        d="M7 3.5A1.5 1.5 0 0 1 8.5 2h3.879a1.5 1.5 0 0 1 1.06.44l3.122 3.12A1.5 1.5 0 0 1 17 6.622V12.5a1.5 1.5 0 0 1-1.5 1.5h-1v-3.379a3 3 0 0 0-.879-2.121L10.5 5.379A3 3 0 0 0 8.379 4.5H7v-1Z">
                                                                    </path>
                                                                    <path
                                                                        d="M4.5 6A1.5 1.5 0 0 0 3 7.5v9A1.5 1.5 0 0 0 4.5 18h7a1.5 1.5 0 0 0 1.5-1.5v-5.879a1.5 1.5 0 0 0-.44-1.06L9.44 6.439A1.5 1.5 0 0 0 8.378 6H4.5Z">
                                                                    </path>
                                                                </svg>
                                                                <span class="font-semibold text-xs">۵ فصل</span>
                                                            </div>
                                                            <span
                                                                class="block w-1 h-1 bg-muted-foreground rounded-full"></span>
                                                            <div class="flex items-center gap-1 text-muted">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20" fill="currentColor"
                                                                    class="w-5 h-5">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                                <span class="font-semibold text-xs">۲۵ ساعت</span>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center justify-between gap-5">
                                                            <div class="flex items-center gap-3">
                                                                <div
                                                                    class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                                                    <img src="assets/images/avatars/01.jpg"
                                                                        class="w-full h-full object-cover" alt="..." />
                                                                </div>
                                                                <div class="flex flex-col items-start space-y-1">
                                                                    <span
                                                                        class="line-clamp-1 font-semibold text-xs text-muted">مدرس
                                                                        دوره:</span>
                                                                    <a href="<?= base_url?>lecturer.php"
                                                                        class="line-clamp-1 font-bold text-xs text-foreground hover:text-primary">جلال
                                                                        بهرامی راد</a>
                                                                </div>
                                                            </div>
                                                            <div class="flex flex-col items-end justify-center h-14">
                                                                <span class="line-through text-muted">۱,۱۹۹,۰۰۰</span>
                                                                <div class="flex items-center gap-1">
                                                                    <span
                                                                        class="font-black text-xl text-foreground">۱,۰۷۹,۰۰۰</span>
                                                                    <span class="text-xs text-muted">تومان</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="space-y-3 mt-3">
                                                            <div class="flex flex-col">
                                                                <span class="text-xs text-primary">۷۵.۵% مشاهده
                                                                    شده</span>
                                                                <div
                                                                    class="relative w-full h-1.5 bg-border rounded-full overflow-hidden">
                                                                    <span class="absolute right-0 h-full bg-primary"
                                                                        style="width: 75.5%;"></span>
                                                                </div>
                                                            </div>
                                                            <a href="<?= base_url?>course-episodes.php"
                                                                class="w-full h-11 inline-flex items-center justify-center gap-1 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4">
                                                                <span class="font-semibold text-sm">ادامه یادگیری</span>
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20" fill="currentColor"
                                                                    class="w-5 h-5">
                                                                    <path fill-rule="evenodd"
                                                                        d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="relative">
                                                <div class="relative z-10">
                                                    <a href="<?= base_url?>course-detail.php" class="block">
                                                        <img src="assets/images/courses/02.jpg"
                                                            class="max-w-full rounded-3xl" alt="..." />
                                                    </a>
                                                    <a href="<?= base_url?>course-category.php"
                                                        class="absolute left-3 top-3 h-11 inline-flex items-center justify-center gap-1 bg-black/20 rounded-full text-white transition-all hover:opacity-80 px-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="currentColor" class="w-6 h-6">
                                                            <path fill-rule="evenodd"
                                                                d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="font-semibold text-sm">برنامه نویسی</span>
                                                    </a>
                                                </div>
                                                <div class="bg-background rounded-b-3xl -mt-12 pt-12">
                                                    <div
                                                        class="bg-gradient-to-b from-background to-secondary rounded-b-3xl space-y-2 p-5 mx-5">
                                                        <div class="flex items-center gap-2">
                                                            <span class="block w-1 h-1 bg-success rounded-full"></span>
                                                            <span class="font-bold text-xs text-success">تکمیل
                                                                شده</span>
                                                        </div>
                                                        <h2 class="font-bold text-sm">
                                                            <a href="<?= base_url?>course-detail.php"
                                                                class="line-clamp-1 text-foreground transition-colors hover:text-primary">قدم
                                                                صفر برنامه نویسی</a>
                                                        </h2>
                                                    </div>
                                                    <div class="space-y-3 p-5">
                                                        <div class="flex flex-wrap items-center gap-3">
                                                            <div class="flex items-center gap-1 text-muted">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20" fill="currentColor"
                                                                    class="w-5 h-5">
                                                                    <path
                                                                        d="M7 3.5A1.5 1.5 0 0 1 8.5 2h3.879a1.5 1.5 0 0 1 1.06.44l3.122 3.12A1.5 1.5 0 0 1 17 6.622V12.5a1.5 1.5 0 0 1-1.5 1.5h-1v-3.379a3 3 0 0 0-.879-2.121L10.5 5.379A3 3 0 0 0 8.379 4.5H7v-1Z">
                                                                    </path>
                                                                    <path
                                                                        d="M4.5 6A1.5 1.5 0 0 0 3 7.5v9A1.5 1.5 0 0 0 4.5 18h7a1.5 1.5 0 0 0 1.5-1.5v-5.879a1.5 1.5 0 0 0-.44-1.06L9.44 6.439A1.5 1.5 0 0 0 8.378 6H4.5Z">
                                                                    </path>
                                                                </svg>
                                                                <span class="font-semibold text-xs">۵ فصل</span>
                                                            </div>
                                                            <span
                                                                class="block w-1 h-1 bg-muted-foreground rounded-full"></span>
                                                            <div class="flex items-center gap-1 text-muted">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20" fill="currentColor"
                                                                    class="w-5 h-5">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                                <span class="font-semibold text-xs">۲۵ ساعت</span>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center justify-between gap-5">
                                                            <div class="flex items-center gap-3">
                                                                <div
                                                                    class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                                                    <img src="assets/images/avatars/01.jpg"
                                                                        class="w-full h-full object-cover" alt="..." />
                                                                </div>
                                                                <div class="flex flex-col items-start space-y-1">
                                                                    <span
                                                                        class="line-clamp-1 font-semibold text-xs text-muted">مدرس
                                                                        دوره:</span>
                                                                    <a href="<?= base_url?>lecturer.php"
                                                                        class="line-clamp-1 font-bold text-xs text-foreground hover:text-primary">جلال
                                                                        بهرامی راد</a>
                                                                </div>
                                                            </div>
                                                            <div class="flex flex-col items-end justify-center h-14">
                                                                <div class="flex items-center gap-1">
                                                                    <span
                                                                        class="font-black text-xl text-success">رایگان!</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="space-y-3 mt-3">
                                                            <div class="flex flex-col">
                                                                <span class="text-xs text-primary">۴۹% مشاهده
                                                                    شده</span>
                                                                <div
                                                                    class="relative w-full h-1.5 bg-border rounded-full overflow-hidden">
                                                                    <span class="absolute right-0 h-full bg-primary"
                                                                        style="width: 49%;"></span>
                                                                </div>
                                                            </div>
                                                            <a href="<?= base_url?>course-episodes.php"
                                                                class="w-full h-11 inline-flex items-center justify-center gap-1 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4">
                                                                <span class="font-semibold text-sm">ادامه یادگیری</span>
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20" fill="currentColor"
                                                                    class="w-5 h-5">
                                                                    <path fill-rule="evenodd"
                                                                        d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
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
</body>


</html>