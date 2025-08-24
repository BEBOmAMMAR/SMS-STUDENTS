<?php
include 'db.php';
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $subject_speciality= $_POST['subject_speciality'];

    $sql = "INSERT INTO teachers (name, phone, email, subject_speciality, created_at) 
            VALUES ('$name', '$phone', '$email', '$subject_speciality', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>✅ تم إضافة المعلم بنجاح</div>";
    } else {
        echo "<div class='alert alert-danger'>❌ خطأ: " . $conn->error . "</div>";
    }
}
?>

<div class="container mt-4">
    <h2>➕ إضافة معلم جديد</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">اسم المعلم</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">رقم الهاتف</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">التخصص</label>
            <input type="text" name="subject_speciality" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">💾 حفظ</button>
        <a href="manage_teachers.php" class="btn btn-secondary">↩️ رجوع</a>
    </form>
</div>

<?php include 'footer.php'; ?>
