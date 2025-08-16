<?php
require '../config.php';

// ฟังก์ชันอัปโหลดไฟล์ (บันทึกเฉพาะชื่อไฟล์ ไม่รวม path)
function uploadFile($fileKey, $fileNumber, $empId) {
    if (!empty($_FILES[$fileKey]['name'])) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $ext = pathinfo($_FILES[$fileKey]["name"], PATHINFO_EXTENSION);
        $filename = date("Ymd_His") . "-" . $empId . "-" . $fileNumber . "." . $ext;
        $targetFile = $targetDir . $filename;

        move_uploaded_file($_FILES[$fileKey]["tmp_name"], $targetFile);
        return $filename; // คืนค่าแค่ชื่อไฟล์
    }
    return null;
}

// รับ emp_code เป็น ID
$empId = $_POST['emp_code'];

// อัปโหลดไฟล์เดี่ยว ตามลำดับ 1-10
$photo_path           = uploadFile('photo_path', 1, $empId);
$work_permit_path     = uploadFile('work_permit_path', 2, $empId);
$passport_path        = uploadFile('passport_path', 3, $empId);
$receipt_path         = uploadFile('receipt_path', 4, $empId);
$wp_book_path         = uploadFile('wp_book_path', 5, $empId);
$work_accept_path     = uploadFile('work_accept_path', 6, $empId);
$notice_file_path55   = uploadFile('notice_file_path55', 7, $empId);
$notice_file_path52   = uploadFile('notice_file_path52', 8, $empId);
$pink_card_front_path = uploadFile('pink_card_front_path', 9, $empId);
$pink_card_back_path  = uploadFile('pink_card_back_path', 10, $empId);

$stmt = $conn->prepare("
    INSERT INTO employees (
        nationality,
        branch_id,
        action_type, 
        emp_code, 
        first_name, 
        last_name, 
        photo_path, 
        work_permit_path, 
        passport_path, 
        receipt_path, 
        wp_book_path, 
        work_accept_path, 
        notice_file_path55, 
        notice_file_path52, 
        pink_card_front_path, 
        pink_card_back_path
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssssssssssssssss",
    $_POST['nationality'],
    $_POST['branch_id'],
    $_POST['action_type'],
    $_POST['emp_code'],
    $_POST['first_name'],
    $_POST['last_name'],
    $photo_path,
    $work_permit_path,
    $passport_path,
    $receipt_path,
    $wp_book_path,
    $work_accept_path,
    $notice_file_path55,
    $notice_file_path52,
    $pink_card_front_path,
    $pink_card_back_path
);

if ($stmt->execute()) {
    if ($_POST['nationality'] == 'Thai') {
        $go = "form_thai.php?nationality=Thai";
    } else {
        $go = "form_foreign.php?nationality=Foreign";
    }
    echo "<script>alert('บันทึกข้อมูลสำเร็จ'); window.location='../$go';</script>";
} else {
    echo "Error: " . $stmt->error;
}
?>
