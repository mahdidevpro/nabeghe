<?php
include('database/pdo_connection.php');

$total = $_POST['total'];
if (isset($_POST['pay'])) {
    $data = [
        'pin' => 'aqayepardakht',
        'amount' => $total,
        'callback' => 'http://localhost/nabeghe/paypay.php?amount=' . $total . '&user=' . $_POST['user'],
    ];

    $data = json_encode($data);
    $ch = curl_init('https://panel.aqayepardakht.ir/api/create');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '/cacert.pem');
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
    if ($result === false) {
        $error = curl_error($ch);
        curl_close($ch);
        echo "خطا در اتصال به درگاه: " . $error;
    } else {
        curl_close($ch);
        if (!is_numeric($result)) {
            header('Location: https://panel.aqayepardakht.ir/startpay/' . $result);
        } else {
            echo "خطا: " . $result;
        }
    }

} else {
    header("location:home.php");
}











$data = [
    'pin' => 'Gateway Pin',
    'amount' => 20000,
    'callback' => 'https://mysite.com/verify.php',
    'card_number' => '1111222233334444',
    'mobile' => '09123456789',
    'email' => 'test@test.com',
    'invoice_id' => '123456',
    'description' => 'Description'
];

$data = json_encode($data);
$ch = curl_init('https://panel.aqayepardakht.ir/api/v2/create');
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
$result = json_decode($result);
if ($result->status == "success") {
    header('Location: https://panel.aqayepardakht.ir/startpay/' . $result->transid);
} else {
    echo "خطا";
}
?>