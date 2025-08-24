<?php include 'db.php'; ?>
<?php include 'header.php'; ?>

<?php
// عدد الطلاب
$students_count = $conn->query("SELECT COUNT(*) as c FROM students")->fetch_assoc()['c'];

// عدد المعلمين
$teachers_count = $conn->query("SELECT COUNT(*) as c FROM teachers")->fetch_assoc()['c'];

// عدد المواد
$subjects_count = $conn->query("SELECT COUNT(*) as c FROM subjects")->fetch_assoc()['c'];

// عدد الامتحانات
$exams_count = $conn->query("SELECT COUNT(*) as c FROM exams")->fetch_assoc()['c'];

// إجمالي المدفوعات
$total_payments = $conn->query("SELECT SUM(amount) as s FROM payments WHERE status='مدفوع'")
                        ->fetch_assoc()['s'] ?? 0;

// إجمالي المصروفات
$total_expenses = $conn->query("SELECT SUM(amount) as s FROM expenses")
                        ->fetch_assoc()['s'] ?? 0;
?>

<h2 class="mb-4">🏠 لوحة التحكم الرئيسية</h2>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                👨‍🎓 الطلاب
                <h3><?= $students_count; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                👨‍🏫 المعلمون
                <h3><?= $teachers_count; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                📚 المواد
                <h3><?= $subjects_count; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark shadow">
            <div class="card-body">
                📝 الامتحانات
                <h3><?= $exams_count; ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-3">
    <div class="col-md-6">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                💰 إجمالي المدفوعات
                <h3><?= $total_payments; ?> جنيه</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-danger text-white shadow">
            <div class="card-body">
                🧾 إجمالي المصروفات
                <h3><?= $total_expenses; ?> جنيه</h3>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
