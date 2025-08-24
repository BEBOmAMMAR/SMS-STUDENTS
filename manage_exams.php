<?php
include 'db.php';
include 'header.php';

// حذف امتحان
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM exams WHERE id=$id");
    echo "<div class='alert alert-danger'>تم حذف الامتحان</div>";
}

// جلب الامتحانات مع المواد
$sql = "SELECT exams.id, exams.exam_date, exams.total_marks, 
               subjects.name AS subject_name
        FROM exams
        JOIN subjects ON exams.subject_id = subjects.id
        ORDER BY exams.exam_date DESC";

$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h2>📘 إدارة الامتحانات</h2>
    <a href="add_exam.php" class="btn btn-success mb-3">➕ إضافة امتحان جديد</a>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>المادة</th>
                <th>تاريخ الامتحان</th>
                <th>الدرجة الكلية</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0) { 
                $i=1;
                while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $row['subject_name'] ?></td>
                    <td><?= $row['exam_date'] ?></td>
                    <td><?= $row['total_marks'] ?></td>
                    <td>
                        <a href="edit_exam.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏️ تعديل</a>
                        <a href="manage_exams.php?delete=<?= $row['id'] ?>" 
                           onclick="return confirm('هل أنت متأكد من الحذف؟')" 
                           class="btn btn-danger btn-sm">🗑 حذف</a>
                    </td>
                </tr>
            <?php } } else { ?>
                <tr>
                    <td colspan="5">⚠️ لا توجد امتحانات مسجلة</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
