<?php include 'db.php'; ?>

<?php
// جلب بيانات المادة
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM subjects WHERE id=$id");
    $subject = $result->fetch_assoc();
}

// تحديث بيانات المادة
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];

    $sql = "UPDATE subjects SET 
                name='$name', 
                description='$desc' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_subjects.php"); // رجوع بعد الحفظ
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
    <title>تعديل مادة دراسية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

<h2 class="mb-3">✏ تعديل مادة دراسية</h2>

<form method="post">
    <div class="mb-2">
        <label>اسم المادة</label>
        <input type="text" name="name" class="form-control" value="<?= $subject['name']; ?>" required>
    </div>
    <div class="mb-2">
        <label>وصف المادة</label>
        <textarea name="description" class="form-control"><?= $subject['description']; ?></textarea>
    </div>
    <button type="submit" name="update" class="btn btn-success">💾 حفظ التعديلات</button>
    <a href="manage_subjects.php" class="btn btn-secondary">رجوع</a>
</form>

</body>
</html>
