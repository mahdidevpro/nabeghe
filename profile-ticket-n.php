<?php
include ('database/pdo_connection.php');
include ('database/jdf.php');
$id = $_SESSION['id'];
$main = $_GET['main'];

if (!isset($_SESSION['login'])) {
    header("location:404.php");

}

if (isset($_POST['sub'])) {
    $content = $_POST['content'];
    $result = $coon->prepare('INSERT INTO ticket SET title=? , content=? , sender=? , reply=? , main=? ,date=?');
    $result->bindValue(1, "");
    $result->bindValue(2, $content);
    $result->bindValue(3, $id);
    $result->bindValue(4, $main);
    $result->bindValue(5, $main);
    $result->bindValue(6, time());
    $result->execute();
}

$result = $coon->prepare("SELECT ticket.* , users.username AS user_name ,users.role AS Role FROM  ticket JOIN users ON users.id=ticket.sender WHERE main=$main ORDER BY id ASC ");
$result->execute();
$ticket_tis = $result->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="assets/css/style.css" />
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

                            <?php include ("usersss.php") ?>
                        </ul>
                    </div>

                    <div class="lg:col-span-9 md:col-span-8">
                        <div class="space-y-10">
                            <div class="bg-background  rounded-3xl p-5 mb-5">



                            </div>

                            <div class="space-y-5">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-1">
                                        <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                        <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                    </div>
                                    <div class="font-black text-foreground">مدیریت تیکت ها</div>

                                </div>




                                <div>
                                    <div class=" ">

                                        <div
                                            class="border-0 focus:border-border border-border rounded-xl text-sm text-foreground p-5 chat-area">
                                            <?php foreach ($ticket_tis as $ticket_ti): ?>

                                                <div
                                                    class=" <?php if ($ticket_ti['Role'] == 3) { ?>chat-messagess <?php } else { ?> chat-messages<?php } ?> ">
                                                    <div class="message"><?= $ticket_ti['content'] ?></div>
                                                </div>

                                            <?php endforeach ?>

                                        </div>
                                        <form action="" method="post">
                                            <div class="user-input bg-secondary">
                                                <input type="text" name="content" class="w-full border-2"
                                                    placeholder="متن مورد نظر خود را وارد کنید ...">
                                                <button name="sub" type="submit" id="send-button"
                                                    class="bg-primary">ارسال</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <script>
                                    function sendMessage() {
                                        const messageInput = document.getElementById('message-input');
                                        const message = messageInput.value.trim();
                                        if (message !== '') {
                                            const chatMessages = document.querySelector('.chat-messages');
                                            const messageElement = document.createElement('div');
                                            messageElement.classList.add('message');
                                            messageElement.textContent = message;
                                            chatMessages.appendChild(messageElement);
                                            messageInput.value = '';
                                            chatMessages.scrollTop = chatMessages.scrollHeight;
                                        }
                                    }

                                    document.getElementById('send-button').addEventListener('click', sendMessage);
                                    document.getElementById('message-input').addEventListener('keydown', (event) => {
                                        if (event.key === 'Enter') {
                                            event.preventDefault();
                                            sendMessage();
                                        }
                                    });
                                </script>

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