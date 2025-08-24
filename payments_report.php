<?php
include 'db.php';
include 'header.php';

$selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

// ✅ جلب إجمالي المدفوعات للشهر
$sql_total = "SELECT SUM(amount) as total FROM payments WHERE month = '$selected_month'";
$res_total = $conn->query($sql_total);
$total = ($res_total && $res_total->num_rows > 0) ? $res_total->fetch_assoc()['total'] : 0;

// ✅ جلب الطلاب اللي دفعوا
$sql_paid = "SELECT students.name, payments.amount 
             FROM payments 
             JOIN students ON students.id = payments.student_id 
             WHERE payments.month = '$selected_month'";
$res_paid = $conn->query($sql_paid);

// ✅ جلب الطلاب اللي ما دفعوش
$sql_unpaid = "SELECT name FROM students 
               WHERE id NOT IN (
                   SELECT student_id FROM payments WHERE month = '$selected_month'
               )";
$res_unpaid = $conn->query($sql_unpaid);
?>

<div class="container mt-4">
    <h2>📊 تقرير المدفوعات</h2>

    <form method="GET" class="mb-3">
        <label class="form-label">اختر الشهر</label>
        <input type="month" name="month" value="<?php echo $selected_month; ?>" class="form-control" onchange="this.form.submit()">
    </form>

    <div class="alert alert-info">
        💰 إجمالي المدفوعات في <strong><?php echo $selected_month; ?></strong> = 
        <strong><?php echo number_format($total, 2); ?> ج.م</strong>
    </div>

    <div class="row">
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
