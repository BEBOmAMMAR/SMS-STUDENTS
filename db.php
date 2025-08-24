<?php
$host = "localhost";
$user = "root";   // اسم المستخدم للـ MySQL
$pass = "";       // كلمة المرور (خليها فاضية لو XAMPP)
$dbname = "sms";  // اسم قاعدة البيانات

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");
?>
