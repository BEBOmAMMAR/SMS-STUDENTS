<?php
include 'db.php';
include 'header.php';

// حذف مصروف
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($conn->query("DELETE FROM expenses WHERE id=$id")) {
        echo "<div class='alert alert-success'>✅ تم حذف المصروف بنجاح</div>";
    } else {
        echo "<div class='alert alert-danger'>❌ خطأ: " . $conn->error . "</div>";
    }
}

// جلب المصاريف
$sql = "SELECT * FROM expenses ORDER BY expense_date DESC";
$result = $conn->query($sql);
?>

<h2 class="mb-4">📋 إدارة المصروفات</h2>
<a href="add_expense.php" class="btn btn-primary mb-3">➕ إضافة مصروف</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>الوصف</th>
            <th>المبلغ</th>
            <th>التاريخ</th>
            <th>الخيارات</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['description']; ?></td>
                    <td><?= $row['amount']; ?></td>
                    <td><?= $row['expense_date']; ?></td>
                    <td>
                        <a href="edit_expense.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">✏️ تعديل</a>
                        <a href="manage_expenses.php?delete=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑 حذف</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4" class="text-center">🚫 لا توجد مصروفات مسجلة</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
