<?php 
include ('database/pdo_connection.php');
$select=$coon->prepare("SELECT users.*,teacher.image AS image FROM `users` JOIN teacher ON users.id=teacher.user_id ");
$select->execute();
$teachers=$select->fetchAll(PDO::FETCH_ASSOC);
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
                <div class="grid  grid-cols-1 items-start gap-5">
                 <div class="grid lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-5 mb-8"></div>

                    <div class="lg:col-span-9 md:col-span-8">
                          <div class="lg:col-span-9 md:col-span-8">
                        <div class="space-y-10">
                            <div class="grid lg:grid-cols-3 sm:grid-cols-1 grid-cols-1 gap-5 mb-8">
                                <?php foreach($teachers as $teacher){ ?>
                                <div class="flex items-center gap-3 bg-secondary rounded-2xl cursor-default p-3">
                                    <span class="flex  items-center justify-center w-12 h-12 bg-background  rounded-full text-yellow-500">
                                      <img src="<?=$teacher['image']?>" class="w-full h-full object-cover rounded-full"
                                      alt="..." />
                                      </span>
                                    <div class="flex flex-col items-start text-right space-y-1">
                                        <span class="font-bold text-xs text-muted line-clamp-1"><?=$teacher['email']?></span>
                                        <span class="font-bold text-sm text-foreground line-clamp-1"><?=$teacher['username']?></span>
                                    </div>
                                    <a href="<?=base_url?>teachers.php?id=<?=$teacher['id']?>" type="submit"  class="h-10 inline-flex items-center justify-center gap-1 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4 mr-auto">
                                                            <span   class="font-semibold text-sm">مشاهده رزومه
                                                                </span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" class="w-5 h-5">
                                                                <path fill-rule="evenodd"
                                                                    d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        </a>
                                </div>
                                <?php } ?>
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