<?php
include 'db.php';
include 'header.php';

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $parent_name = $_POST['parent_name'];
    $parent_phone = $_POST['parent_phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO students (name, age, phone, parent_name, parent_phone, address) 
            VALUES ('$name','$age','$phone','$parent_name','$parent_phone','$address')";
    if ($conn->query($sql) === TRUE) {
        echo "<div style='color:green;'>تم إضافة الطالب بنجاح ✅</div>";
    } else {
        echo "<div style='color:red;'>خطأ: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إضافة طالب</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

<h2 class="mb-3">➕ إضافة طالب جديد</h2>

<form method="post">
    <div class="mb-2">
        <label>اسم الطالب</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-2">
        <label>العمر</label>
        <input type="number" name="age" class="form-control">
    </div>
    <div class="mb-2">
        <label>هاتف الطالب</label>
        <input type="text" name="phone" class="form-control">
    </div>
    <div class="mb-2">
        <label>اسم ولي الأمر</label>
        <input type="text" name="parent_name" class="form-control">
    </div>
    <div class="mb-2">
        <label>هاتف ولي الأمر</label>
        <input type="text" name="parent_phone" class="form-control">
    </div>
    <div class="mb-2">
        <label>العنوان</label>
        <textarea name="address" class="form-control"></textarea>
    </div>
    <button type="submit" name="save" class="btn btn-success">حفظ</button>
    <a href="manage_students.php" class="btn btn-secondary">رجوع</a>
</form>

</body>
</html>
