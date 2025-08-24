<?php
include 'db.php';
include 'header.php';

// لو فيه عملية حذف
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM subjects WHERE id=$id";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>✅ تم حذف المادة بنجاح!</div>";
    } else {
        echo "<div class='alert alert-danger'>❌ خطأ: " . $conn->error . "</div>";
    }
}

// جلب المواد
$sql = "SELECT * FROM subjects";
$result = $conn->query($sql);
if (!$result) {
    die("❌ خطأ في الاستعلام: " . $conn->error);
}
?>

<h2 class="mb-4">📚 إدارة المواد الدراسية</h2>
<a href="add_subject.php" class="btn btn-primary mb-3">➕ إضافة مادة جديدة</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>اسم المادة</th>
            <th>الوصف</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['description']; ?></td>
                    <td>
                        <a href="edit_subject.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">✏️ تعديل</a>
                        <a href="manage_subjects.php?delete=<?= $row['id']; ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('هل أنت متأكد من الحذف؟');">🗑️ حذف</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">لا توجد مواد مسجلة</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
