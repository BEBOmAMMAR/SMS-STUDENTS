<?php include 'db.php';
include 'header.php';

// حذف الطالب
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM students WHERE id=$id");
    header("Location: manage_students.php");
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة الطلاب</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

<h2 class="mb-3">📚 إدارة الطلاب</h2>

<a href="add_student.php" class="btn btn-primary mb-3">➕ إضافة طالب</a>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>الاسم</th>
            <th>العمر</th>
            <th>هاتف الطالب</th>
            <th>ولي الأمر</th>
            <th>هاتف ولي الأمر</th>
            <th>العنوان</th>
            <th>إجراءات</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $conn->query("SELECT * FROM students");
        while($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['name']; ?></td>
            <td><?= $row['age']; ?></td>
            <td><?= $row['phone']; ?></td>
            <td><?= $row['parent_name']; ?></td>
            <td><?= $row['parent_phone']; ?></td>
            <td><?= $row['address']; ?></td>
            <td>
                <a href="edit_student.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">✏ تعديل</a>
                <a href="manage_students.php?delete=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑 حذف</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
