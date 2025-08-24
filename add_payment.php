<?php
include 'db.php';
include 'header.php';

// جلب قائمة الطلاب لعرضهم في الـ select
$students = $conn->query("SELECT id, name FROM students ORDER BY name ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $amount = $_POST['amount'];
    $month = $_POST['month'];

    $sql = "INSERT INTO payments (student_id, amount, month, payment_date)
            VALUES ('$student_id', '$amount', '$month', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>✅ تم تسجيل الدفع بنجاح</div>";
    } else {
        echo "<div class='alert alert-danger'>❌ خطأ: " . $conn->error . "</div>";
    }
}
?>

<div class="container mt-4">
    <h2>➕ إضافة دفع جديد</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">الطالب</label>
            <select name="student_id" class="form-control" required>
                <option value="">-- اختر الطالب --</option>
                <?php while ($row = $students->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo htmlspecialchars($row['name']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">المبلغ (ج.م)</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">الشهر</label>
            <input type="month" name="month" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">💾 حفظ</button>
        <a href="manage_payments.php" class="btn btn-secondary">↩️ رجوع</a>
    </form>
</div>

<?php include 'footer.php'; ?>
