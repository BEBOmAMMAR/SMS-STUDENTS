<?php
include 'db.php';
include 'header.php';

// 🗑️ حذف نتيجة
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM exam_results WHERE id=$id");
    echo "<div class='alert alert-danger'>🗑 تم حذف النتيجة</div>";
}

// 📊 جلب النتائج مع الطلاب والامتحانات والمواد
$sql = "SELECT exam_results.id,
               students.name AS student_name,
               subjects.name AS subject_name,
               exams.exam_date,
               exams.total_marks,
               exam_results.marks
        FROM exam_results
        JOIN students ON exam_results.student_id = students.id
        JOIN exams ON exam_results.exam_id = exams.id
        JOIN subjects ON exams.subject_id = subjects.id
        ORDER BY exams.exam_date DESC";

$result = $conn->query($sql);
if (!$result) {
    die("❌ خطأ في الاستعلام: " . $conn->error);
}
?>

<div class="container mt-4">
    <h2>📊 إدارة نتائج الامتحانات</h2>
    <a href="add_result.php" class="btn btn-success mb-3">➕ إضافة نتيجة جديدة</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>الطالب</th>
                <th>المادة</th>
                <th>تاريخ الامتحان</th>
                <th>الدرجة</th>
                <th>من</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($result->num_rows > 0) { 
                $i = 1;
                while($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['student_name']) ?></td>
                        <td><?= htmlspecialchars($row['subject_name']) ?></td>
                        <td><?= htmlspecialchars($row['exam_date']) ?></td>
                        <td><?= htmlspecialchars($row['marks']) ?></td>
                        <td><?= htmlspecialchars($row['total_marks']) ?></td>
                        <td>
                            <a href="edit_result.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏️ تعديل</a>
                            <a href="manage_results.php?delete=<?= $row['id'] ?>" 
                               onclick="return confirm('هل أنت متأكد من الحذف؟')" 
                               class="btn btn-danger btn-sm">🗑 حذف</a>
                        </td>
                    </tr>
            <?php } 
            } else { ?>
                <tr>
                    <td colspan="7" class="text-center">⚠️ لا توجد نتائج مسجلة</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
