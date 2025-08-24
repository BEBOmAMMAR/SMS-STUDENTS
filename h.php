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
$sql_payments = "SELECT SUM(amount) as total 
                 FROM payments 
                 WHERE DATE_FORMAT(payment_date, '%Y-%m') = '$selected_month'";
$total_payments = $conn->query($sql_payments)->fetch_assoc()['total'] ?? 0;

// المصروفات للشهر
$sql_expenses = "SELECT SUM(amount) as total 
                 FROM expenses 
                 WHERE DATE_FORMAT(expense_date, '%Y-%m') = '$selected_month'";
$total_expenses = $conn->query($sql_expenses)->fetch_assoc()['total'] ?? 0;

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
            <div class="card-body">
                👨‍🎓 الطلاب: <h4><?= $students ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                👨‍🏫 المعلمون: <h4><?= $teachers ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                💰 المدفوعات: <h4><?= number_format($total_payments, 2) ?> ج.م</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                💸 المصروفات: <h4><?= number_format($total_expenses, 2) ?> ج.م</h4>
            </div>
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
<div class="row">
    <div class="col-md-6">
        <canvas id="pieChart"></canvas>
    </div>
    <div class="col-md-6">
        <canvas id="barChart"></canvas>
    </div>
</div>

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

<?php include 'footer.php'; ?>
