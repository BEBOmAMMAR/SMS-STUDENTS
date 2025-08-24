<?php
include 'db.php';
include 'header.php';

// اختيار الامتحان
$exams = $conn->query("SELECT id, title FROM exams");

$exam_id = isset($_GET['exam_id']) ? intval($_GET['exam_id']) : 0;
$results = null;
$stats   = null;

if ($exam_id > 0) {
    // جلب النتائج مع أسماء الطلاب
    $sql = "SELECT students.name AS student_name, exam_results.score
            FROM exam_results
            LEFT JOIN students ON exam_results.student_id = students.id
            WHERE exam_results.exam_id = $exam_id";
    $results = $conn->query($sql);

    // إحصائيات
    $stats = $conn->query("SELECT 
                                AVG(score) AS avg_score, 
                                MAX(score) AS max_score, 
                                MIN(score) AS min_score
                           FROM exam_results 
                           WHERE exam_id = $exam_id")->fetch_assoc();
}
?>

<h2 class="mb-4">📊 تقرير نتائج الامتحانات</h2>

<form method="GET" class="mb-4">
    <label class="form-label">اختر الامتحان:</label>
    <select name="exam_id" class="form-control" onchange="this.form.submit()">
        <option value="">-- اختر --</option>
        <?php while ($exam = $exams->fetch_assoc()): ?>
            <option value="<?= $exam['id']; ?>" <?= ($exam['id'] == $exam_id) ? 'selected' : ''; ?>>
                <?= $exam['title']; ?>
            </option>
        <?php endwhile; ?>
    </select>
</form>

<?php if ($exam_id > 0): ?>
    <h4>📌 إحصائيات الامتحان</h4>
    <ul>
        <li>المتوسط: <?= number_format($stats['avg_score'], 2); ?></li>
        <li>أعلى درجة: <?= $stats['max_score']; ?></li>
        <li>أقل درجة: <?= $stats['min_score']; ?></li>
    </ul>

    <h4>📋 نتائج الطلاب</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>الطالب</th>
                <th>الدرجة</th>
                <th>الحالة</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($results && $results->num_rows > 0): ?>
                <?php while ($row = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['student_name']; ?></td>
                        <td><?= $row['score']; ?></td>
                        <td>
                            <?php if ($row['score'] >= 50): ?>
                                ✅ ناجح
                            <?php else: ?>
                                ❌ راسب
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">لا توجد نتائج</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include 'footer.php'; ?>
