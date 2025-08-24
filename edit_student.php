<?php include 'db.php'; ?>

<?php
// جلب بيانات الطالب حسب ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM students WHERE id=$id");
    $student = $result->fetch_assoc();
}

// تعديل بيانات الطالب
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $parent_name = $_POST['parent_name'];
    $parent_phone = $_POST['parent_phone'];
    $address = $_POST['address'];

    $sql = "UPDATE students SET 
            name='$name',
            age='$age',
            phone='$phone',
            parent_name='$parent_name',
            parent_phone='$parent_phone',
            address='$address'
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_students.php"); // بعد الحفظ نرجع لإدارة الطلاب
        exit();
    } else {
        echo "<div style='color:red;'>خطأ: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تعديل بيانات الطالب</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

<h2 class="mb-3">✏ تعديل بيانات الطالب</h2>

<form method="post">
    <div class="mb-2">
        <label>اسم الطالب</label>
        <input type="text" name="name" class="form-control" value="<?= $student['name']; ?>" required>
    </div>
    <div class="mb-2">
        <label>العمر</label>
        <input type="number" name="age" class="form-control" value="<?= $student['age']; ?>">
    </div>
    <div class="mb-2">
        <label>هاتف الطالب</label>
        <input type="text" name="phone" class="form-control" value="<?= $student['phone']; ?>">
    </div>
    <div class="mb-2">
        <label>اسم ولي الأمر</label>
        <input type="text" name="parent_name" class="form-control" value="<?= $student['parent_name']; ?>">
    </div>
    <div class="mb-2">
        <label>هاتف ولي الأمر</label>
        <input type="text" name="parent_phone" class="form-control" value="<?= $student['parent_phone']; ?>">
    </div>
    <div class="mb-2">
        <label>العنوان</label>
        <textarea name="address" class="form-control"><?= $student['address']; ?></textarea>
    </div>
    <button type="submit" name="update" class="btn btn-success">💾 حفظ التعديلات</button>
    <a href="manage_students.php" class="btn btn-secondary">رجوع</a>
</form>

</body>
</html>
