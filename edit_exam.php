<?php
include 'db.php';
include 'header.php';

// التحقق من وجود ID
if (!isset($_GET['id'])) {
    die("<div class='alert alert-danger'>⚠️ لم يتم تحديد الامتحان</div>");
}
$id = $_GET['id'];

// جلب بيانات الامتحان
$exam = $conn->query("SELECT * FROM exams WHERE id=$id")->fetch_assoc();
if (!$exam) {
    die("<div class='alert alert-danger'>⚠️ الامتحان غير موجود</div>");
}

// جلب المواد
$subjects = $conn->query("SELECT * FROM subjects");

// تحديث بيانات الامتحان
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = $_POST['subject_id'];
    $exam_date = $_POST['exam_date'];
    $total_marks = $_POST['total_marks'];

    $sql = "UPDATE exams 
            SET subject_id='$subject_id', exam_date='$exam_date', total_marks='$total_marks'
            WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>✅ تم تعديل الامتحان بنجاح</div>";
        // إعادة تحميل البيانات بعد التعديل
        $exam = $conn->query("SELECT * FROM exams WHERE id=$id")->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>❌ خطأ: " . $conn->error . "</div>";
    }
}
?>

<div class="container mt-4">
    <h2>✏️ تعديل الامتحان</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">المادة</label>
            <select name="subject_id" class="form-control" required>
                <option value="">اختر المادة</option>
                <?php while($row = $subjects->fetch_assoc()) { ?>
                    <option value="<?= $row['id'] ?>" 
                        <?= ($row['id'] == $exam['subject_id']) ? 'selected' : '' ?>>
                        <?= $row['name'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">تاريخ الامتحان</label>
            <input type="date" name="exam_date" class="form-control" 
                   value="<?= $exam['exam_date'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">الدرجة الكلية</label>
            <input type="number" name="total_marks" class="form-control" 
                   value="<?= $exam['total_marks'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">💾 حفظ</button>
        <a href="manage_exams.php" class="btn btn-secondary">↩️ رجوع</a>
    </form>
</div>

<?php include 'footer.php'; ?>
