<?php
include 'db.php';
include 'header.php';

// جلب المدفوعات مع اسم الطالب
$sql = "SELECT p.id, p.amount, p.payment_date, p.month, s.name AS student_name
        FROM payments p
        JOIN students s ON p.student_id = s.id
        ORDER BY p.payment_date DESC";

$result = $conn->query($sql);

if (!$result) {
    die("❌ خطأ في الاستعلام: " . $conn->error);
}
?>

<div class="container mt-4">
    <h2>💰 إدارة المدفوعات</h2>
    <a href="add_payment.php" class="btn btn-success mb-3">➕ إضافة دفع</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>اسم الطالب</th>
                <th>المبلغ</th>
                <th>الشهر</th>
                <th>تاريخ الدفع</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0) { ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                        <td><?php echo number_format($row['amount'], 2); ?> ج.م</td>
                        <td><?php echo htmlspecialchars($row['month']); ?></td>
                        <td><?php echo $row['payment_date']; ?></td>
                        <td>
                            <a href="edit_payment.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">✏️ تعديل</a>
                            <a href="delete_payment.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('هل أنت متأكد من الحذف؟');">🗑 حذف</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="5" class="text-center">⚠️ لا توجد مدفوعات مسجلة</td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
