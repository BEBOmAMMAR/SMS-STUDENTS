<?php
include 'db.php';
include 'header.php';

// لو فيه عملية حذف
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM teachers WHERE id=$id";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>✅ تم حذف المعلم بنجاح!</div>";
    } else {
        echo "<div class='alert alert-danger'>❌ خطأ: " . $conn->error . "</div>";
    }
}

// جلب قائمة المعلمين
$sql = "SELECT * FROM teachers";
$result = $conn->query($sql);
if (!$result) {
    die("❌ خطأ في الاستعلام: " . $conn->error);
}
?>

<h2 class="mb-4">👨‍🏫 إدارة المعلمين</h2>
<a href="add_teacher.php" class="btn btn-primary mb-3">➕ إضافة معلم جديد</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>الاسم</th>
             <th>الهاتف</th>
            <th>البريد الإلكتروني</th>
            <th>المادة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['phone']; ?></td>

                    <td><?= $row['email']; ?></td>
                
                    <td><?= $row['subject_speciality']; ?></td>
                    <td>
                        <a href="edit_teacher.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">✏️ تعديل</a>
                        <a href="manage_teachers.php?delete=<?= $row['id']; ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('هل أنت متأكد من الحذف؟');">🗑️ حذف</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">لا يوجد معلمين مسجلين</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
