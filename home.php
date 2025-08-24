<?php
include 'db.php';
include 'header.php';

// إجمالي الطلاب
$students = $conn->query("SELECT COUNT(*) as total FROM students")->fetch_assoc()['total'];

// إجمالي المعلمين
$teachers = $conn->query("SELECT COUNT(*) as total FROM teachers")->fetch_assoc()['total'];

// إجمالي المدفوعات (كلها)
$total_payments = $conn->query("SELECT SUM(amount) as total FROM payments")->fetch_assoc()['total'] ?? 0;

// إجمالي المصروفات (كلها)
$total_expenses = $conn->query("SELECT SUM(amount) as total FROM expenses")->fetch_assoc()['total'] ?? 0;

// الصافي
$net = $total_payments - $total_expenses;
?>

<h2 class="mb-4">📊 لوحة التحكم الرئيسية</h2>

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
                💸 المصروفات: <h
