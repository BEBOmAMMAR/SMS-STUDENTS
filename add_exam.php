<?php
include 'db.php';
include 'header.php';

// جلب المواد من قاعدة البيانات
$subjects = $conn->query("SELECT * FROM subjects");

// إضافة امتحان جديد
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = $_POST['subject_id'];
    $exam_date = $_POST['exam_date'];
    $total_marks = $_POST['total_marks'];

    $sql = "INSERT INTO exams (subject_id, exam_date, total_marks) 
            VALUES ('$subject_id', '$exam_date', '$total_marks')";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>تم إضافة الامتحان بنجاح ✅</div>";
    } else {
        echo "<div class='alert alert-danger'>خطأ: " . $conn->error . "</div>";
    }
}
?>

<div class="container mt-4">
    <h2>➕ إضافة امتحان جديد</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">المادة</label>
            <select name="subject_id" class="form-control" required>
                <option value="">اختر المادة</option>
                <?php while($row = $subjects->fetch_assoc()) { ?>
                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">تاريخ الامتحان</label>
            <input type="date" name="exam_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">الدرجة الكلية</label>
            <input type="number" name="total_marks" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">💾 حفظ</button>
        <a href="manage_exams.php" class="btn btn-secondary">رجوع</a>
    </form>
</div>

<?php include 'footer.php'; ?>
