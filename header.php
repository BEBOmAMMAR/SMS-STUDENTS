<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم - إدارة الدروس الخصوصية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            direction: rtl;
            text-align: right;
        }
        .sidebar {
            height: 100vh;
            background: #343a40;
            color: #fff;
            padding: 1rem;
        }
        .sidebar a {
            display: block;
            color: #fff;
            margin: 0.5rem 0;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #495057;
            border-radius: 5px;
            padding-right: 10px;
        }
        .content {
            padding: 2rem;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-2 sidebar">
            <h4 class="mb-4"><i class="fa-solid fa-school"></i> لوحة التحكم</h4>
            <a href="p.php"><i class="fa fa-user-graduate"></i> الرئيسية</a>

            <a href="manage_students.php"><i class="fa fa-user-graduate"></i> الطلاب</a>
            <a href="manage_teachers.php"><i class="fa fa-chalkboard-teacher"></i> المعلمون</a>
            <a href="manage_subjects.php"><i class="fa fa-book"></i> المواد</a>
            <a href="manage_exams.php"><i class="fa fa-file-alt"></i> الامتحانات</a>
            <a href="manage_results.php"><i class="fa fa-check"></i> النتائج</a>
            <a href="manage_payments.php"><i class="fa fa-money-bill-wave"></i> المدفوعات</a>
            <a href="payments_report.php"><i class="fa fa-chart-bar"></i> تقارير المدفوعات</a>
            <a href="manage_expenses.php"><i class="fa fa-receipt"></i> المصروفات</a>
            <a href="finance_report.php"><i class="fa fa-receipt"></i> تقرير الماليه </a>

        </div>
        <!-- Main content -->
        <div class="col-10 content">
