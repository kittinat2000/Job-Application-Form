<?php
require "../config.php";

$id = intval($_GET['id']);

// ดึงข้อมูลพนักงานเก่า
$stmt = $conn->prepare("SELECT * FROM employees WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$emp = $result->fetch_assoc();

if (!$emp) {
    echo "ไม่พบข้อมูล";
    exit;
}
// ฟังก์ชันอัปโหลดไฟล์ (เก็บชื่อไฟล์เท่านั้น ไม่รวม path)
function uploadFile($fileKey, $oldFile, $empId, $fileNumber) {
    if (!empty($_FILES[$fileKey]['name'])) {
        $dir = "../uploads/";
        if (!is_dir($dir)) mkdir($dir, 0777, true);
        $ext = pathinfo($_FILES[$fileKey]["name"], PATHINFO_EXTENSION);
        $filename = date("Ymd_His") . "-" . $empId . "-" . $fileNumber . "." . $ext;
        move_uploaded_file($_FILES[$fileKey]["tmp_name"], $dir . $filename);
        return $filename;
    }
    return $oldFile; // ถ้าไม่อัปโหลดใหม่ ใช้ไฟล์เดิม
}

// รับ emp_code เป็น ID
$empId = $emp['emp_code'];

$photo_path           = uploadFile('photo_path', $emp['photo_path'], $empId, 1);
$work_permit_path     = uploadFile('work_permit_path', $emp['work_permit_path'], $empId, 2);
$passport_path        = uploadFile('passport_path', $emp['passport_path'], $empId, 3);
$receipt_path         = uploadFile('receipt_path', $emp['receipt_path'], $empId, 4);
$wp_book_path         = uploadFile('wp_book_path', $emp['wp_book_path'], $empId, 5);
$work_accept_path     = uploadFile('work_accept_path', $emp['work_accept_path'], $empId, 6);
$notice_file_path55   = uploadFile('notice_file_path55', $emp['notice_file_path55'], $empId, 7);
$notice_file_path52   = uploadFile('notice_file_path52', $emp['notice_file_path52'], $empId, 8);
$pink_card_front_path = uploadFile('pink_card_front_path', $emp['pink_card_front_path'], $empId, 9);
$pink_card_back_path  = uploadFile('pink_card_back_path', $emp['pink_card_back_path'], $empId, 10);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("
        UPDATE employees SET 
        branch_id=?, 
        action_type=?, 
        emp_code=?, 
        first_name=?, 
        last_name=?, 
        photo_path=?, 
        work_permit_path=?, 
        passport_path=?, 
        receipt_path=?, 
        wp_book_path=?, 
        work_accept_path=?, 
        notice_file_path55=?, 
        notice_file_path52=?, 
        pink_card_front_path=?, 
        pink_card_back_path=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "sssssssssssssssi",
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
        $pink_card_back_path,
        $id
    );

    if ($stmt->execute()) {
        header("Location: ../dashboard.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
