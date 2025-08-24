<?php
include 'db.php';
include 'header.php';

// جلب بيانات المصروف الحالي
if (!isset($_GET['id'])) {
    die("<div class='alert alert-danger'>❌ لم يتم تحديد المصروف المطلوب</div>");
}
$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM expenses WHERE id=$id");
$expense = $result->fetch_assoc();

if (!$expense) {
    die("<div class='alert alert-danger'>🚫 المصروف غير موجود</div>");
}

// تحديث بيانات المصروف
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description  = $conn->real_escape_string($_POST['description']);
    $amount       = floatval($_POST['amount']);
    $expense_date = $_POST['expense_date'];

    $sql = "UPDATE expenses 
            SET description='$description', amount=$amount, expense_date='$expense_date' 
            WHERE id=$id";

    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>✅ تم تعديل المصروف بنجاح</div>";
        // تحديث البيانات المعروضة بعد التعديل
        $result = $conn->query("SELECT * FROM expenses WHERE id=$id");
        $expense = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>❌ خطأ: " . $conn->error . "</div>";
    }
}
?>

<h2 class="mb-4">✏️ تعديل مصروف</h2>

<form method="POST" class="mb-4">
    <div class="mb-3">
        <label class="form-label">الوصف</label>
        <input type="text" name="description" class="form-control" value="<?= $expense['description'] ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">المبلغ</label>
        <input type="number" step="0.01" name="amount" class="form-control" value="<?= $expense['amount'] ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">التاريخ</label>
        <input type="date" name="expense_date" class="form-control" value="<?= $expense['expense_date'] ?>" required>
    </div>
    <button type="submit" class="btn btn-success">💾 حفظ التعديلات</button>
    <a href="manage_expenses.php" class="btn btn-secondary">↩️ رجوع</a>
</form>

<?php include 'footer.php'; ?>
