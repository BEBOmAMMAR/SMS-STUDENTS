<?php
include 'db.php';
include 'header.php';

// ✅ تأكد إن فيه ID جاي من الرابط
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<div class='alert alert-danger'>❌ لم يتم تحديد الدفع المطلوب تعديله</div>");
}

$payment_id = intval($_GET['id']);

// ✅ جلب بيانات الدفع
$sql = "SELECT * FROM payments WHERE id = $payment_id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("<div class='alert alert-danger'>❌ الدفع غير موجود</div>");
}

$payment = $result->fetch_assoc();

// ✅ جلب الطلاب لعرضهم في القائمة
$students = $conn->query("SELECT id, name FROM students ORDER BY name ASC");

// ✅ تحديث البيانات عند الحفظ
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $amount = $_POST['amount'];
    $month = $_POST['month'];

    $update_sql = "UPDATE payments 
                   SET student_id='$student_id', amount='$amount', month='$month' 
                   WHERE id=$payment_id";

    if ($conn->query($update_sql) === TRUE) {
        echo "<div class='alert alert-success'>✅ تم تعديل الدفع بنجاح</div>";
        // إعادة تحميل البيانات بعد التعديل
        $payment = ['student_id' => $student_id, 'amount' => $amount, 'month' => $month];
    } else {
        echo "<div class='alert alert-danger'>❌ خطأ: " . $conn->error . "</div>";
    }
}
?>

<div class="container mt-4">
    <h2>✏️ تعديل دفع</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">الطالب</label>
            <select name="student_id" class="form-control" required>
                <?php while ($row = $students->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>" 
                        <?php if ($row['id'] == $payment['student_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($row['name']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">المبلغ (ج.م)</label>
            <input type="number" step="0.01" name="amount" class="form-control" 
                   value="<?php echo $payment['amount']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">الشهر</label>
            <input type="month" name="month" class="form-control" 
                   value="<?php echo $payment['month']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">💾 تحديث</button>
        <a href="manage_payments.php" class="btn btn-secondary">↩️ رجوع</a>
    </form>
</div>

<?php include 'footer.php'; ?>
