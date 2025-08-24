<?php
include 'db.php';
include 'header.php';

// جلب قائمة المعلمين من قاعدة البيانات
$teachers = $conn->query("SELECT id, name FROM teachers");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $teacher_id = $_POST['teacher_id'];

    $sql = "INSERT INTO subjects (name, description, teacher_id) 
            VALUES ('$name', '$description', '$teacher_id')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>✅ تم إضافة المادة بنجاح</div>";
    } else {
        echo "<div class='alert alert-danger'>❌ خطأ: " . $conn->error . "</div>";
    }
}
?>

<div class="container mt-4">
    <h2>➕ إضافة مادة جديدة</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">اسم المادة</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">الوصف</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">المعلم المسؤول</label>
            <select name="teacher_id" class="form-control" required>
                <option value="">-- اختر المعلم --</option>
                <?php while($row = $teachers->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo $row['name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">💾 حفظ</button>
        <a href="manage_subjects.php" class="btn btn-secondary">↩️ رجوع</a>
    </form>
</div>

<?php include 'footer.php'; ?>
