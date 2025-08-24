<?php
include 'db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $conn->real_escape_string($_POST['description']);
    $amount      = floatval($_POST['amount']);
    $expense_date = $_POST['expense_date'];

    $sql = "INSERT INTO expenses (description, amount, expense_date) 
            VALUES ('$description', $amount, '$expense_date')";

    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>✅ تم إضافة المصروف بنجاح</div>";
    } else {
        echo "<div class='alert alert-danger'>❌ خطأ: " . $conn->error . "</div>";
    }
}
?>

<h2 class="mb-4">➕ إضافة مصروف جديد</h2>

<form method="POST" class="mb-4">
    <div class="mb-3">
        <label class="form-label">الوصف</label>
        <input type="text" name="description" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">المبلغ</label>
        <input type="number" step="0.01" name="amount" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">التاريخ</label>
        <input type="date" name="expense_date" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">💾 حفظ</button>
    <a href="manage_expenses.php" class="btn btn-secondary">↩️ رجوع</a>
</form>

<?php include 'footer.php'; ?>
