<?php
include 'db.php';
include 'header.php';

// جلب بيانات المعلم المطلوب تعديله
if (!isset($_GET['id'])) {
    die("<div class='alert alert-danger'>❌ معرّف المعلم غير موجود!</div>");
}
$id = intval($_GET['id']);
$sql = "SELECT * FROM teachers WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("<div class='alert alert-danger'>❌ المعلم غير موجود!</div>");
}
$teacher = $result->fetch_assoc();

// تحديث بيانات المعلم
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = $conn->real_escape_string($_POST['name']);
    $email   = $conn->real_escape_string($_POST['email']);
    $phone   = $conn->real_escape_string($_POST['phone']);
    $subject = $conn->real_escape_string($_POST['subject']);

    $update = "UPDATE teachers 
               SET name='$name', email='$email', phone='$phone', subject='$subject' 
               WHERE id=$id";

    if ($conn->query($update)) {
        echo "<div class='alert alert-success'>✅ تم تعديل بيانات المعلم بنجاح!</div>";
        // تحديث البيانات للعرض بعد الحفظ
        $teacher = ['name'=>$name, 'email'=>$email, 'phone'=>$phone, 'subject'=>$subject];
    } else {
        echo "<div class='alert alert-danger'>❌ خطأ: " . $conn->error . "</div>";
    }
}
?>

<h2 class="mb-4">✏️ تعديل بيانات المعلم</h2>

<form method="POST" class="card p-4 shadow">
    <div class="mb-3">
        <label class="form-label">اسم المعلم</label>
        <input type="text" name="name" value="<?= $teacher['name']; ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">البريد الإلكتروني</label>
        <input type="email" name="email" value="<?= $teacher['email']; ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">رقم الهاتف</label>
        <input type="text" name="phone" value="<?= $teacher['phone']; ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">المادة</label>
        <input type="text" name="subject" value="<?= $teacher['subject']; ?>" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">💾 حفظ التغييرات</button>
    <a href="manage_teachers.php" class="btn btn-secondary">رجوع</a>
</form>

<?php include 'footer.php'; ?>
