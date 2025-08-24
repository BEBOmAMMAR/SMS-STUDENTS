<?php
include 'db.php';
include 'header.php';

// جلب الطلاب
$students = $conn->query("SELECT * FROM students");

// جلب الامتحانات مع المواد
$exams = $conn->query("SELECT exams.id, subjects.name AS subject_name, exams.exam_date, exams.total_marks
                       FROM exams
                       JOIN subjects ON exams.subject_id = subjects.id");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $exam_id = $_POST['exam_id'];
    $marks = $_POST['marks'];

    $sql = "INSERT INTO exam_results (student_id, exam_id, marks) 
            VALUES ('$student_id', '$exam_id', '$marks')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>✅ تم إضافة النتيجة بنجاح</div>";
    } else {
        echo "<div class='alert alert-danger'>❌ خطأ: " . $conn->error . "</div>";
    }
}
?>

<div class="container mt-4">
    <h2>➕ إضافة نتيجة جديدة</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">الطالب</label>
            <select name="student_id" class="form-control" required>
                <option value="">اختر الطالب</option>
                <?php while($row = $students->fetch_assoc()) { ?>
                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">الامتحان</label>
            <select name="exam_id" class="form-control" required>
                <option value="">اختر الامتحان</option>
                <?php while($row = $exams->fetch_assoc()) { ?>
                    <option value="<?= $row['id'] ?>">
                        <?= $row['subject_name'] ?> - <?= $row['exam_date'] ?> (من <?= $row['total_marks'] ?>)
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">الدرجة</label>
            <input type="number" name="marks" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">💾 حفظ</button>
        <a href="manage_results.php" class="btn btn-secondary">↩️ رجوع</a>
    </form>
</div>

<?php include 'footer.php'; ?>
