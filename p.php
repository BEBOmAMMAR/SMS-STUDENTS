<?php
include 'db.php';
include 'header.php';

// الشهر المختار (افتراضي = الشهر الحالي)
$selected_month = $_GET['month'] ?? date('Y-m');

// إجمالي الطلاب
$students = $conn->query("SELECT COUNT(*) as total FROM students")->fetch_assoc()['total'];

// إجمالي المعلمين
$teachers = $conn->query("SELECT COUNT(*) as total FROM teachers")->fetch_assoc()['total'];

// المدفوعات للشهر
$sql_payments = "SELECT p.id, s.name as student_name, p.amount, p.payment_date
                 FROM payments p
                 JOIN students s ON p.student_id = s.id
                 WHERE DATE_FORMAT(p.payment_date, '%Y-%m') = '$selected_month'";
$payments_result = $conn->query($sql_payments);

$total_payments = 0;
if ($payments_result) {
    foreach ($payments_result as $row) {
        $total_payments += $row['amount'];
    }
}

// المصروفات للشهر
$sql_expenses = "SELECT id, description, amount, expense_date 
                 FROM expenses 
                 WHERE DATE_FORMAT(expense_date, '%Y-%m') = '$selected_month'";
$expenses_result = $conn->query($sql_expenses);

$total_expenses = 0;
if ($expenses_result) {
    foreach ($expenses_result as $row) {
        $total_expenses += $row['amount'];
    }
}

// الصافي
$net = $total_payments - $total_expenses;
?>

<h2 class="mb-4">📊 لوحة التحكم الرئيسية</h2>

<!-- فورم اختيار الشهر -->
<form method="GET" class="mb-4">
    <label>اختر الشهر:</label>
    <input type="month" name="month" value="<?= $selected_month ?>" class="form-control d-inline-block w-auto">
    <button type="submit" class="btn btn-primary">عرض</button>
</form>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">👨‍🎓 الطلاب: <h4><?= $students ?></h4></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-secondary text-white">
            <div class="card-body">👨‍🏫 المعلمون: <h4><?= $teachers ?></h4></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">💰 المدفوعات: <h4><?= number_format($total_payments, 2) ?> ج.م</h4></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">💸 المصروفات: <h4><?= number_format($total_expenses, 2) ?> ج.م</h4></div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card <?= $net >= 0 ? 'bg-info' : 'bg-warning' ?> text-white">
            <div class="card-body">
                ⚖️ صافي الربح/الخسارة: <h4><?= number_format($net, 2) ?> ج.م</h4>
            </div>
        </div>
    </div>
</div>

<!-- الرسوم البيانية -->
<div class="row mb-5">
    <div class="col-md-6">
        <canvas id="pieChart"></canvas>
    </div>
    <div class="col-md-6">
        <canvas id="barChart"></canvas>
    </div>
</div>

<!-- جدول المدفوعات -->
<h4>💰 تفاصيل المدفوعات</h4>
<table class="table table-bordered">
    <thead class="table-success">
        <tr>
            <th>الطالب</th>
            <th>المبلغ</th>
            <th>تاريخ الدفع</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($payments_result && $payments_result->num_rows > 0): ?>
            <?php foreach ($payments_result as $row): ?>
                <tr>
                    <td><?= $row['student_name'] ?></td>
                    <td><?= number_format($row['amount'], 2) ?> ج.م</td>
                    <td><?= $row['payment_date'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">لا يوجد مدفوعات لهذا الشهر</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- جدول المصروفات -->
<h4>💸 تفاصيل المصروفات</h4>
<table class="table table-bordered">
    <thead class="table-danger">
        <tr>
            <th>الوصف</th>
            <th>المبلغ</th>
            <th>تاريخ الصرف</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($expenses_result && $expenses_result->num_rows > 0): ?>
            <?php foreach ($expenses_result as $row): ?>
                <tr>
                    <td><?= $row['description'] ?></td>
                    <td><?= number_format($row['amount'], 2) ?> ج.م</td>
                    <td><?= $row['expense_date'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">لا يوجد مصروفات لهذا الشهر</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const totalPayments = <?= $total_payments ?>;
const totalExpenses = <?= $total_expenses ?>;
const net = <?= $net ?>;

// Pie Chart
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: ['💰 مدفوعات', '💸 مصروفات'],
        datasets: [{
            data: [totalPayments, totalExpenses],
            backgroundColor: ['#28a745', '#dc3545']
        }]
    },
    options: { responsive: true }
});

// Bar Chart
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: ['مدفوعات', 'مصروفات', 'الصافي'],
        datasets: [{
            label: 'جنيه مصري',
            data: [totalPayments, totalExpenses, net],
            backgroundColor: ['#28a745', '#dc3545', '#17a2b8']
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});
</script>

<?php include 'footer.php'; ?><!-- جدول الطلاب اللي ما دفعوش -->
<h4>🚫 الطلاب الذين لم يدفعوا</h4>
<table class="table table-bordered">
    <thead class="table-warning">
        <tr>
            <th>اسم الطالب</th>
            <th>الموبايل</th>
            <th>واتساب</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // نجيب كل الطلاب
        $all_students = $conn->query("SELECT id, name, phone FROM students");

        // الطلاب اللي دفعوا في الشهر
        $paid_students = [];
        $payments_result = $conn->query($sql_payments); // نعيد التنفيذ لأنه استُهلك فوق
        if ($payments_result && $payments_result->num_rows > 0) {
            foreach ($payments_result as $row) {
                $paid_students[] = $row['id']; // ID الطالب
            }
        }

        if ($all_students && $all_students->num_rows > 0) {
            $found = false;
            foreach ($all_students as $stu) {
                if (!in_array($stu['id'], $paid_students)) {
                    $found = true;
                    $phone = preg_replace('/[^0-9]/', '', $stu['phone']); // تنظيف الرقم
                    echo "<tr>
                            <td>{$stu['name']}</td>
                            <td>{$stu['phone']}</td>
                            <td>
                                <a class='btn btn-success btn-sm' target='_blank'
                                   href='https://wa.me/2{$phone}?text=مرحبًا%20{$stu['name']}،%20برجاء%20تسديد%20المصروفات%20الخاصة%20بالشهر%20{$selected_month}'>
                                   واتساب
                                </a>
                            </td>
                          </tr>";
                }
            }
            if (!$found) {
                echo "<tr><td colspan='3'>✅ كل الطلاب دفعوا هذا الشهر</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3'>لا يوجد طلاب مسجلين</td></tr>";
        }
        ?>
    </tbody>
</table>
