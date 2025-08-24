<?php
include 'db.php';
include 'header.php';

// التأكد من وصول ID
if (!isset($_GET['id'])) {
    die("<div class='alert alert-danger'>⚠️ لم يتم تحديد النتيجة</div>");
}
$id = $_GET['id'];

// جلب بيانات النتيجة
$result = $conn->query("SELECT * FROM exam_results WHERE id=$id")->fetch_assoc();
if (!$result) {
    die("<div class='alert alert-danger'>⚠️ النتيجة غير موجودة</div>");
}

// جلب الطلاب والامتحانات
$students = $conn->query("SELECT * FROM students");
$exams = $conn->query("SELECT exams.id, subjects.name AS subject_name, exams.exam_date 
                       FROM exams 
                       JOIN subjects ON exams.subject_id = subjects.id");

// تحديث البيانات
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $exam_id = $_POST['exam_id'];
    $marks = $_POST['marks'];

    $sql = "UPDATE exam_results 
            SET student_id='$student_id', exam_id='$exam_id', marks='$marks' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>✅ تم تعديل النتيجة بنجاح</div>";
        // إعادة تحميل البيانات بعد التعديل
        $result = $conn->query("SELECT * FROM exam_results WHERE id=$id")->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>❌ خطأ: " . $conn->error . "</div>";
    }
}
?>

<div class="container mt-4">
    <h2>✏️ تعديل النتيجة</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">الطالب</label>
            <select name="student_id" class="form-control" required>
                <option value="">اختر الطالب</option>
                <?php while($row = $students->fetch_assoc()) { ?>
                    <option value="<?= $row['id'] ?>" 
                        <?= ($row['id'] == $result['student_id']) ? 'selected' : '' ?>>
                        <?= $row['name'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">الامتحان</label>
            <select name="exam_id" class="form-control" required>
                <option value="">اختر الامتحان</option>
                <?php while($row = $exams->fetch_assoc()) { ?>
                    <option value="<?= $row['id'] ?>" 
                        <?= ($row['id'] == $result['exam_id']) ? 'selected' : '' ?>>
                        <?= $row['subject_name'] ?> - <?= $row['exam_date'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">الدرجة</label>
            <input type="number" name="marks" class="form-control" 
                   value="<?= $result['marks'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">💾 حفظ</button>
        <a href="manage_results.php" class="btn btn-secondary">↩️ رجوع</a>
    </form>
</div>

<?php include 'footer.php'; ?>
