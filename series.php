<?php
include ("database/pdo_connection.php");

$select = $coon->prepare("SELECT * FROM  menu ");
$select->execute();
$menus = $select->fetchAll(PDO::FETCH_ASSOC);

$slug = isset($_GET['slug']) ? $_GET['slug'] : false;
$search = isset($_POST['search']) ? $_POST['search'] : false;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$catsort = isset($_POST['catsort']) ? $_POST['catsort'] : false;
$typecourse = isset($_POST['typecourse']) ? $_POST['typecourse'] : false;

// تعیین شروط برای دسته‌بندی، جستجو و فیلتر در حال یادگیری
$conditions = [];
$params = [];

if ($slug) {
    $conditions[] = "menu.src = :slug";
    $params[':slug'] = $slug;
}

if ($search) {
    $conditions[] = "course.title LIKE :search";
    $params[':search'] = '%' . $search . '%';
}

$orderBy = "course.update_date DESC";

switch ($catsort) {
    case 1:
        $orderBy = "course.id DESC";
        break;
    case 2:
        $orderBy = "course.id ASC";
        break;
    case 3:
        $conditions[] = "course.status = :status";
        $params[':status'] = 0;
        $orderBy = "course.update_date DESC";
        break;
    case 4:
        $conditions[] = "course.status = :status";
        $params[':status'] = 1;
        $orderBy = "course.update_date DESC";
        break;
}

if ($typecourse == 2) {
    $orderBy = "course.value > 0 DESC, " . $orderBy;
} elseif ($typecourse == 1) {
    $orderBy = "course.value <= 0 DESC, " . $orderBy;
}

$countSql = "SELECT COUNT(*) AS total FROM course 
             JOIN menu ON menu.id = course.cat";

if (count($conditions) > 0) {
    $countSql .= " WHERE " . implode(' AND ', $conditions);
}

$countStmt = $coon->prepare($countSql);
$countStmt->execute($params);
$totalRecords = $countStmt->fetchColumn();

$recordsPerPage = 6;
$totalPages = ceil($totalRecords / $recordsPerPage);

$offset = ($page - 1) * $recordsPerPage;

$sql = "SELECT course.*, menu.src AS category 
        FROM course 
        JOIN menu ON menu.id = course.cat";

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " ORDER BY $orderBy 
            LIMIT 6 OFFSET $offset ";

$select = $coon->prepare($sql);
$select->bindValue(':limit', $recordsPerPage, PDO::PARAM_INT);
$select->bindValue(':offset', $offset, PDO::PARAM_INT);
$select->execute($params);
$courses = $select->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT SUM(CASE WHEN value <= 0 THEN 1 ELSE 0 END) AS total_value_le_0, SUM(CASE WHEN value > 0 THEN 1 ELSE 0 END) AS total_value_gt_0 FROM course";
$result = $coon->prepare($sql);
$result->execute();
$numbercourse = $result->fetch(PDO::FETCH_ASSOC);
$totalValueLe0 = $numbercourse['total_value_le_0'];
$totalValueGt0 = $numbercourse['total_value_gt_0'];

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
    <title>قالب آموزشی نابغه - لیست دوره ها</title>
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
                <div class="space-y-8">
                    <div class="flex items-center gap-5">
                        <span
                            class="flex items-center justify-center w-12 h-12 bg-primary text-primary-foreground rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M9.664 1.319a.75.75 0 0 1 .672 0 41.059 41.059 0 0 1 8.198 5.424.75.75 0 0 1-.254 1.285 31.372 31.372 0 0 0-7.86 3.83.75.75 0 0 1-.84 0 31.508 31.508 0 0 0-2.08-1.287V9.394c0-.244.116-.463.302-.592a35.504 35.504 0 0 1 3.305-2.033.75.75 0 0 0-.714-1.319 37 37 0 0 0-3.446 2.12A2.216 2.216 0 0 0 6 9.393v.38a31.293 31.293 0 0 0-4.28-1.746.75.75 0 0 1-.254-1.285 41.059 41.059 0 0 1 8.198-5.424ZM6 11.459a29.848 29.848 0 0 0-2.455-1.158 41.029 41.029 0 0 0-.39 3.114.75.75 0 0 0 .419.74c.528.256 1.046.53 1.554.82-.21.324-.455.63-.739.914a.75.75 0 1 0 1.06 1.06c.37-.369.69-.77.96-1.193a26.61 26.61 0 0 1 3.095 2.348.75.75 0 0 0 .992 0 26.547 26.547 0 0 1 5.93-3.95.75.75 0 0 0 .42-.739 41.053 41.053 0 0 0-.39-3.114 29.925 29.925 0 0 0-5.199 2.801 2.25 2.25 0 0 1-2.514 0c-.41-.275-.826-.541-1.25-.797a6.985 6.985 0 0 1-1.084 3.45 26.503 26.503 0 0 0-1.281-.78A5.487 5.487 0 0 0 6 12v-.54Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div class="flex flex-col space-y-2">
                            <span class="font-black xs:text-2xl text-lg text-primary">دوره های آموزشی</span>
                            <span class="font-semibold text-xs text-muted">دوره ببین، تمرین کن، برنامه نویس شو</span>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-12 grid-cols-1 items-start gap-5">
                        <div class="md:block hidden lg:col-span-3 md:col-span-4 md:sticky md:top-24">
                            <div class="w-full flex flex-col space-y-3 mb-3">
                                <span class="font-bold text-sm text-foreground">جستجو دوره</span>
                                <form method="post">
                                    <div class="flex items-center relative">
                                        <input type="text" name="search"
                                            class="form-input w-full !ring-0 !ring-offset-0 h-10 bg-secondary !border-0 rounded-xl text-sm text-foreground"
                                            <?php if ($search) { ?> value="<?= $search ?>" <?php } ?>
                                            placeholder="عنوان دوره..">
                                        <button class="absolute left-3 text-muted">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd"
                                                    d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>

                                </form>
                            </div>





                            <div class="flex flex-col divide-y divide-border">
                                <div class="w-full space-y-2 py-3" x-data="{ open: true }">
                                    <button type="button"
                                        class="w-full h-11 flex items-center justify-between gap-x-2 relative bg-secondary rounded-2xl transition hover:text-primary px-3"
                                        x-bind:class="open ? 'text-primary' : 'text-foreground'"
                                        x-on:click="open = !open">
                                        <span class="flex items-center gap-x-2">
                                            <span class="flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                                </svg>
                                            </span>
                                            <span class="font-semibold text-sm text-right">نوع دوره</span>
                                        </span>
                                        <span class="" x-bind:class="open ? 'rotate-180' : ''">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="bg-secondary rounded-2xl relative p-3" x-show="open">
                                        <form id="myFormm" method="post">
                                            <div class="space-y-2">
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="radio" name="typecourse" value="1"
                                                        class="form-radio !ring-0 !ring-offset-0 bg-border border-0">
                                                    <span class="text-sm text-muted">رایگان</span>
                                                    <span
                                                        class="text-sm text-muted mr-auto"><?= $totalValueLe0 ?></span>
                                                </label>
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="radio" name="typecourse" value=" 2"
                                                        class="form-radio !ring-0 !ring-offset-0 bg-border border-0">
                                                    <span class="text-sm text-muted">فقط نقدی</span>
                                                    <span
                                                        class="text-sm text-muted mr-auto"><?= $totalValueGt0 ?></span>
                                                </label>
                                            </div>
                                        </form>
                                    </div>
                                    <script>


                                    </script>

                                </div>

                                <div class="w-full space-y-2 py-3" x-data="{ open: false }">
                                    <button type="button"
                                        class="w-full h-11 flex items-center justify-between gap-x-2 relative bg-secondary rounded-2xl transition hover:text-primary px-3"
                                        x-bind:class="open ? 'text-primary' : 'text-foreground'"
                                        x-on:click="open = !open">
                                        <span class="flex items-center gap-x-2">
                                            <span class="flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                                </svg>
                                            </span>
                                            <span class="font-semibold text-sm text-right">دسته بندی دوره</span>
                                        </span>
                                        <span class="" x-bind:class="open ? 'rotate-180' : ''">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </span>
                                    </button>

                                    <div class="bg-secondary rounded-2xl relative p-3" x-show="open">
                                        <?php foreach ($menus as $menu) {
                                            if ($menu['z'] == 0 && $menu['sort'] == 1) { ?>

                                                <div class="space-y-2">
                                                    <?php foreach ($menus as $ul) {
                                                        if ($menu['id'] == $ul['z']) { ?>

                                                            <li class="flex items-center gap-2 cursor-pointer">
                                                                <a href="<?= base_url ?>series?slug=<?= $ul['src'] ?>" value="#"
                                                                    class="flex items-center relative text-foreground transition-colors hover:text-primary p-1 ">
                                                                    <span class="font-semibold text-sm"><?php echo $ul['title'] ?>
                                                                    </span>

                                                                </a>

                                                            </li>
                                                        <?php }
                                                    } ?>
                                                </div>
                                            <?php }
                                        } ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-9 md:col-span-8">
                            <div class="flex items-center gap-3 mb-3" x-data="{ offcanvasOpen: false }">
                                <div
                                    x-data="{ range: function(start, end) { return Array(end - start + 1).fill().map((_, idx) => start + idx) } } ">

                                    <div class="flex items-center gap-3">
                                        <label
                                            class="sm:flex hidden items-center gap-1 font-semibold text-xs text-muted">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-5 h-5">
                                                <path
                                                    d="M10 3.75a2 2 0 1 0-4 0 2 2 0 0 0 4 0ZM17.25 4.5a.75.75 0 0 0 0-1.5h-5.5a.75.75 0 0 0 0 1.5h5.5ZM5 3.75a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 .75.75ZM4.25 17a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5h1.5ZM17.25 17a.75.75 0 0 0 0-1.5h-5.5a.75.75 0 0 0 0 1.5h5.5ZM9 10a.75.75 0 0 1-.75.75h-5.5a.75.75 0 0 1 0-1.5h5.5A.75.75 0 0 1 9 10ZM17.25 10.75a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5h1.5ZM14 10a2 2 0 1 0-4 0 2 2 0 0 0 4 0ZM10 16.25a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                            </svg>
                                            مرتب سازی:
                                        </label>
                                        <div class="w-52 relative" x-data="{
        open: false,
        selectedOption: 'انتخاب کنید',
        selectedValue: '<?php echo htmlspecialchars($catsort); ?>', 
        options: [
            { text: 'جدید‌ترین', value: '1' },
            { text: 'در حال برگزاری', value: '3' }, 
            { text: 'تکمیل شده', value: '4' }, 
            { text: 'قدیمی‌ترین', value: '2' }
        ],
        init() {
            this.selectedOption = this.options.find(option => option.value === this.selectedValue).text;
        },
        submitForm() {
            this.$refs.sortForm.submit();
        }
     }" x-init="init()">
                                            <form method="post" id="sortForm" x-ref="sortForm">
                                                <input name="catsort" type="hidden" x-model="selectedValue" />
                                            </form>

                                            <button type="button" x-on:click="open = !open"
                                                class="flex items-center w-full h-11 relative bg-secondary rounded-2xl font-semibold text-xs text-foreground px-4">
                                                <span class="line-clamp-1" x-text="selectedOption"></span>
                                                <span class="absolute left-3 pointer-events-none transition-transform"
                                                    x-bind:class="open ? 'rotate-180' : ''">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                    </svg>
                                                </span>
                                            </button>

                                            <div class="absolute w-full bg-background rounded-2xl shadow-lg overflow-hidden mt-2 z-30"
                                                x-show="open" x-on:click.away="open = false">
                                                <ul class="max-h-48 overflow-y-auto">
                                                    <template x-for="option in options" :key="option.value">
                                                        <li class="font-medium text-xs text-foreground cursor-pointer hover:bg-secondary px-4 py-3"
                                                            x-on:click="selectedOption = option.text; selectedValue = option.value; open = false; $nextTick(() => submitForm())"
                                                            x-text="option.text"></li>
                                                    </template>
                                                </ul>
                                            </div>
                                        </div>




                                    </div>
                                </div>

                                <button type="button"
                                    class="md:hidden flex items-center gap-1 h-11 bg-secondary rounded-2xl text-foreground px-4"
                                    x-on:click="offcanvasOpen = true">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                                    </svg>
                                    <span class="hidden sm:block font-semibold text-xs">فیلتر دوره ها</span>
                                </button>

                                <div x-cloak>
                                    <div class="fixed inset-y-0 right-0 xs:w-80 w-72 h-full bg-background rounded-l-2xl overflow-y-auto transition-transform z-50"
                                        x-bind:class="offcanvasOpen ? '!translate-x-0' : 'translate-x-full'">

                                        <div
                                            class="flex items-center justify-between gap-x-4 sticky top-0 bg-background p-4 z-10">
                                            <div class="font-bold text-sm text-foreground">فیلتر دوره ها</div>

                                            <button x-on:click="offcanvasOpen = false"
                                                class="text-black dark:text-white focus:outline-none hover:text-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="p-4">
                                            <div class="w-full flex flex-col space-y-3 mb-3">
                                                <span class="font-bold text-sm text-foreground">جستجو دوره</span>
                                                <form method="post">
                                                    <div class="flex items-center relative">
                                                        <input type="text" name="search"
                                                            class="form-input w-full !ring-0 !ring-offset-0 h-10 bg-secondary !border-0 rounded-xl text-sm text-foreground"
                                                            <?php if ($search) { ?> value="<?= $search ?>" <?php } ?>
                                                            placeholder="عنوان دوره..">
                                                        <span class="absolute left-3 text-muted">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" class="w-5 h-5">
                                                                <path fill-rule="evenodd"
                                                                    d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </form>
                                            </div>


                                            <div class="flex flex-col divide-y divide-border">
                                                <div class="w-full space-y-2 py-3" x-data="{ open: true }">
                                                    <button type="button"
                                                        class="w-full h-11 flex items-center justify-between gap-x-2 relative bg-secondary rounded-2xl transition hover:text-primary px-3"
                                                        x-bind:class="open ? 'text-primary' : 'text-foreground'"
                                                        x-on:click="open = !open">
                                                        <span class="flex items-center gap-x-2">
                                                            <span class="flex-shrink-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-5 h-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                                                </svg>
                                                            </span>
                                                            <span class="font-semibold text-sm text-right">نوع
                                                                دوره</span>
                                                        </span>
                                                        <span class="" x-bind:class="open ? 'rotate-180' : ''">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                            </svg>
                                                        </span>
                                                    </button>

                                                    <div class="bg-secondary rounded-2xl relative p-3" x-show="open">
                                                        <form id="myForm" method="post">
                                                            <div class="space-y-2">
                                                                <label class="flex items-center gap-2 cursor-pointer">
                                                                    <input type="radio" name="typecourse" value="1"
                                                                        class="form-radio !ring-0 !ring-offset-0 bg-border border-0">
                                                                    <span class="text-sm text-muted">رایگان</span>
                                                                    <span
                                                                        class="text-sm text-muted mr-auto"><?= $totalValueLe0 ?></span>
                                                                </label>
                                                                <label class="flex items-center gap-2 cursor-pointer">
                                                                    <input type="radio" name="typecourse" value=" 2"
                                                                        class="form-radio !ring-0 !ring-offset-0 bg-border border-0">
                                                                    <span class="text-sm text-muted">فقط نقدی</span>
                                                                    <span
                                                                        class="text-sm text-muted mr-auto"><?= $totalValueGt0 ?></span>
                                                                </label>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <script>
                                                        // تابع برای ارسال فرم
                                                        function submitForm(formId) {
                                                            var form = document.getElementById(formId);
                                                            form.submit();
                                                        }

                                                        // اضافه کردن رویداد change به دکمه‌های رادیو برای فرم myForm
                                                        var radioButtons1 = document.querySelectorAll(
                                                            '#myForm input[type="radio"]');
                                                        radioButtons1.forEach(function (radio) {
                                                            radio.addEventListener('change', function () {
                                                                submitForm('myForm');
                                                            });
                                                        });

                                                        // اضافه کردن رویداد change به دکمه‌های رادیو برای فرم myFormm
                                                        var radioButtons2 = document.querySelectorAll(
                                                            '#myFormm input[type="radio"]');
                                                        radioButtons2.forEach(function (radio) {
                                                            radio.addEventListener('change', function () {
                                                                submitForm('myFormm');
                                                            });
                                                        });
                                                    </script>
                                                </div>

                                                <div class="w-full space-y-2 py-3" x-data="{ open: false }">
                                                    <button type="button"
                                                        class="w-full h-11 flex items-center justify-between gap-x-2 relative bg-secondary rounded-2xl transition hover:text-primary px-3"
                                                        x-bind:class="open ? 'text-primary' : 'text-foreground'"
                                                        x-on:click="open = !open">
                                                        <span class="flex items-center gap-x-2">
                                                            <span class="flex-shrink-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-5 h-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                                                </svg>
                                                            </span>
                                                            <span class="font-semibold text-sm text-right">دسته بندی
                                                                دوره</span>
                                                        </span>
                                                        <span class="" x-bind:class="open ? 'rotate-180' : ''">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                            </svg>
                                                        </span>
                                                    </button>

                                                    <div class="bg-secondary rounded-2xl relative p-3" x-show="open">
                                                        <?php foreach ($menus as $menu) {
                                                            if ($menu['z'] == 0 && $menu['sort'] == 1) { ?>

                                                                <div class="space-y-2">
                                                                    <?php foreach ($menus as $ul) {
                                                                        if ($menu['id'] == $ul['z']) { ?>

                                                                            <li class="flex items-center gap-2 cursor-pointer">
                                                                                <a href="<?= base_url ?>series?slug=<?= $ul['src'] ?>"
                                                                                    value="#"
                                                                                    class="flex items-center relative text-foreground transition-colors hover:text-primary p-1 ">
                                                                                    <span
                                                                                        class="font-semibold text-sm"><?php echo $ul['title'] ?>
                                                                                    </span>

                                                                                </a>

                                                                            </li>
                                                                        <?php }
                                                                    } ?>
                                                                </div>
                                                            <?php }
                                                        } ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="fixed inset-0 bg-black/10 dark:bg-white/10 cursor-pointer transition-all duration-1000 z-40"
                                        x-bind:class="offcanvasOpen ? 'opacity-100 visible' : 'opacity-0 invisible'"
                                        x-on:click="offcanvasOpen = false"></div>
                                </div>
                            </div>

                            <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-x-5 gap-y-10">
                                <?php
                                foreach ($courses as $course): ?>
                                    <div class="relative">
                                        <div class="relative z-10">
                                            <a href="<?= base_url ?>course-detail.php?id=<?= $course['id'] ?>"
                                                class="block">
                                                <img src="<?= $course['image'] ?>" class="max-w-full rounded-3xl"
                                                    alt="..." />
                                            </a>
                                            <a href="<?= base_url ?>course-category.php"
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
                                            </a>
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
                                                    <a href="<?= base_url ?>course-detail.php"
                                                        class="line-clamp-1 text-foreground transition-colors hover:text-primary"><?= $course['title'] ?>
                                                    </a>
                                                </h2>
                                            </div>
                                            <div class="space-y-3 p-5">

                                                <div class="flex items-center justify-between gap-5">
                                                    <div class="flex items-center gap-3">
                                                        <?php foreach ($teachers as $teacher) {
                                                            if ($course['teacher_id'] == $teacher['id']) { ?>
                                                                <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                                                    <img src="<?= $teacher['image'] ?>"
                                                                        class="w-full h-full object-cover" alt="..." />
                                                                </div>
                                                                <div class="flex flex-col items-start space-y-1">
                                                                    <span class="line-clamp-1 font-semibold text-xs text-muted">مدرس
                                                                        دوره:</span>
                                                                    <a href="<?= base_url ?>lecturer.php"
                                                                        class="line-clamp-1 font-bold text-xs text-foreground hover:text-primary">
                                                                        <?= $teacher['username'] ?></a>
                                                                </div>
                                                            <?php }
                                                        } ?>
                                                    </div>
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
                                                <div class="flex gap-3 mt-3">
                                                    <a href="<?= base_url ?>course-detail.php?id=<?= $course['id'] ?>"
                                                        class="w-full h-11 inline-flex items-center justify-center gap-1 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4">
                                                        <span class="line-clamp-1 font-semibold text-sm">مشاهده دوره</span>
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
                                <?php endforeach; ?>
                            </div>
                            <div class="flex justify-center mt-8">
                                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                    <button type="button"
                                        class="h-8 inline-flex items-center justify-center gap-1 bg-secondary rounded-full text-primary px-4">
                                        <a href="<?= base_url ?>series.php?page=<?= $i ?>"
                                            class="hover:text-primary"><?= $i ?></a>
                                    </button>
                                <?php } ?>
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
</body>


</html>