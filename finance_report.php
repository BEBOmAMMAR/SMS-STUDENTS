<?php
include 'db.php';
include 'header.php';

$selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

// ✅ إجمالي المدفوعات
$sql_total = "SELECT SUM(amount) as total FROM payments WHERE month = '$selected_month'";
$res_total = $conn->query($sql_total);
$total_payments = ($res_total && $res_total->num_rows > 0) ? $res_total->fetch_assoc()['total'] : 0;

// ✅ إجمالي المصروفات
$sql_expenses = "SELECT SUM(amount) as total FROM expenses WHERE DATE_FORMAT(date, '%Y-%m') = '$selected_month'";
$res_expenses = $conn->query($sql_expenses);
$total_expenses = ($res_expenses && $res_expenses->num_rows > 0) ? $res_expenses->fetch_assoc()['total'] : 0;

// ✅ صافي الربح / الخسارة
$net = $total_payments - $total_expenses;

// ✅ الطلاب اللي دفعوا
$sql_paid = "SELECT students.name, payments.amount 
             FROM payments 
             JOIN students ON students.id = payments.student_id 
             WHERE payments.month = '$selected_month'";
$res_paid = $conn->query($sql_paid);

// ✅ الطلاب اللي ما دفعوش
$sql_unpaid = "SELECT name FROM students 
               WHERE id NOT IN (
                   SELECT student_id FROM payments WHERE month = '$selected_month'
               )";
$res_unpaid = $conn->query($sql_unpaid);
?>

<div class="container mt-4">
    <h2>📊 التقرير المالي الشهري</h2>

    <form method="GET" class="mb-3">
        <label class="form-label">اختر الشهر</label>
        <input type="month" name="month" value="<?php echo $selected_month; ?>" class="form-control" onchange="this.form.submit()">
    </form>

    <div class="row mb-3">
        <div class="col-md-4">
            <div class="alert alert-success">
                💰 إجمالي المدفوعات: <strong><?php echo number_format($total_payments, 2); ?> ج.م</strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-danger">
                💸 إجمالي المصروفات: <strong><?php echo number_format($total_expenses, 2); ?> ج.م</strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-<?php echo ($net >= 0) ? 'success' : 'danger'; ?>">
                ⚖️ صافي النتيجة: <strong><?php echo number_format($net, 2); ?> ج.م</strong>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- الطلاب اللي دفعوا -->
        <div class="col-md-6">
            <h4>✅ الطلاب اللي دفعوا</h4>
            <table class="table table-bordered">
                <tr>
                    <th>الاسم</th>
                    <th>المبلغ</th>
                </tr>
                <?php if ($res_paid && $res_paid->num_rows > 0) {
                    while ($row = $res_paid->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo number_format($row['amount'], 2); ?> ج.م</td>
                        </tr>
                <?php } } else { ?>
                    <tr><td colspan="2">🚫 لا يوجد مدفوعات</td></tr>
                <?php } ?>
            </table>
        </div>

        <!-- الطلاب اللي ما دفعوش -->
        <div class="col-md-6">
            <h4>❌ الطلاب اللي ما دفعوش</h4>
            <table class="table table-bordered">
                <tr>
                    <th>الاسم</th>
                </tr>
                <?php if ($res_unpaid && $res_unpaid->num_rows > 0) {
                    while ($row = $res_unpaid->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                        </tr>
                <?php } } else { ?>
                    <tr><td>🎉 الكل دفع</td></tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
