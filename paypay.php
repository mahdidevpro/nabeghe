<?php
include('database/pdo_connection.php');
$user = $_GET['user'];
if (!isset($_POST['transid'])) {
    header('location:404.php');
}
$data = [
    'pin' => 'aqayepardakht',
    'amount' => $_GET['amount'],
    'transid' => $_POST['transid']
];
$data = json_encode($data);
$ch = curl_init('https://panel.aqayepardakht.ir/api/verify');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    )
);
$result = curl_exec($ch);
curl_close($ch);
if ($result === "1") {
    $result = $coon->prepare("UPDATE store SET status=? WHERE user_id=?");
    $result->bindValue(1, 1);
    $result->bindValue(2, $user);
    $result->execute();
    header("Location: cart.php");
    // پرداخت با موفقیت انجام شده است
} elseif ($result === "0") {
    //    پرداخت انجام نشده است
}