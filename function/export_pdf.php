<?php
require('fpdf/fpdf.php');
require('../config.php');

if (!isset($_POST['id'])) {
    die("ไม่พบ ID");
}

$id = intval($_POST['id']);

$id = intval($_POST['id']);

// ดึงข้อมูลพนักงาน
$sql = "SELECT e.*, b.*
        FROM employees e
        LEFT JOIN branches b ON e.branch_id = b.id
        WHERE e.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // ✅ ใช้ $id ที่รับมาจริงๆ
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();



class PDF extends FPDF {
    function Header() {
        // ✅ แสดงเฉพาะหน้าแรก
        if ($this->PageNo() == 1) {
            if (file_exists("../assets/img/miracleplanet-transparent-black.png")) {
                $this->Image("../assets/img/miracleplanet-transparent-black.png", 95, 10, 20);
                $this->Ln(25);
            } else {
                $this->Ln(20);
            }
        } else {
            $this->Ln(10); // หน้าอื่นเว้นระยะนิดหน่อย
        }
    }
}


$pdf = new PDF();
$pdf->AddPage();
$pdf->AddFont('THSarabunNew','','THSarabunNew.php');
$pdf->SetFont('THSarabunNew','',18);

// หัวเรื่อง
$pdf->Cell(0,10,iconv('UTF-8','cp874','ข้อมูลพนักงาน ('.$row['nationality'].')'),0,1,'C');
$pdf->Ln(5);

// ✅ ข้อมูลพื้นฐาน (จัดตรงกลาง)
$pdf->SetFont('THSarabunNew','',16);
$pdf->Cell(0,10,iconv('UTF-8','cp874','ประเภทการทำรายการ : '.$row['action_type']),0,1,'C');
$pdf->Cell(0,10,iconv('UTF-8','cp874',$row['branch_type']." สาขาที่ ". $row['branch_order'] ." ".$row['branch_name'].' | รหัสพนักงาน : '.$row['emp_code']),0,1,'C');
$pdf->Cell(0,10,iconv('UTF-8','cp874','ชื่อ-นามสกุล : '.$row['first_name']." ".$row['last_name']),0,1,'C');


function addImagePage($pdf, $title, $filePath) {
    if (file_exists($filePath)) {
        $pdf->AddPage();
        $pdf->SetFont('THSarabunNew','',18);
        $pdf->Cell(0,10,iconv('UTF-8','cp874',$title),0,1,'C');
        $pdf->Ln(5);

        // 🔹 กำหนดกรอบปลอดภัย (Safe Zone)
        $leftMargin   = 10;  // ซ้าย
        $rightMargin  = 10;  // ขวา
        $topMargin    = 35;  // เว้นหัวข้อ
        $bottomMargin = 15;  // ล่าง

        $maxWidth  = 210 - ($leftMargin + $rightMargin);  // ความกว้าง A4 = 210mm
        $maxHeight = 297 - ($topMargin + $bottomMargin); // ความสูง A4 = 297mm

        // ขนาดจริงของรูป
        list($width, $height) = getimagesize($filePath);

        // คำนวณอัตราส่วน (resize แบบคงสัดส่วน)
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth  = $width * $ratio;
        $newHeight = $height * $ratio;

        // จัดกึ่งกลางในกรอบ
        $x = (210 - $newWidth) / 2;
        $y = ($topMargin + (297 - $topMargin - $bottomMargin - $newHeight) / 2);

        // วางรูป
        $pdf->Image($filePath, $x, $y, $newWidth, $newHeight);
    }
}

function addImageInline($pdf, $title, $filePath) {
    if (file_exists($filePath)) {
        $pdf->Ln(5); // เว้นระยะจากเนื้อหาก่อนหน้า
        $pdf->SetFont('THSarabunNew','',16);
        $pdf->Cell(0,10,iconv('UTF-8','cp874',$title),0,1,'C');
        $pdf->Ln(3);

        // 🔹 กำหนดขนาดสูงสุดของรูป (ไม่บังคับเว้นหน้าใหม่)
        $maxWidth  = 150; // กว้างสุด (A4 = 210 - margin ซ้าย/ขวา)
        $maxHeight = 150; // สูงสุด (เลือกได้ตามต้องการ)

        // ขนาดจริงของรูป
        list($width, $height) = getimagesize($filePath);

        // คำนวณอัตราส่วน
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth  = $width * $ratio;
        $newHeight = $height * $ratio;

        // X ตรงกลาง
        $x = (210 - $newWidth) / 2;
        $y = $pdf->GetY(); // ตำแหน่ง Y ปัจจุบัน

        // แสดงรูป
        $pdf->Image($filePath, $x, $y, $newWidth, $newHeight);
        $pdf->Ln($newHeight + 5); // เว้นหลังรูป
    }
}


// ✅ เรียกฟังก์ชันทีละไฟล์
if (!empty($row['photo_path'])) {
    addImageInline($pdf, 'รูปถ่าย', "../uploads/".$row['photo_path']);
}
if (!empty($row['work_permit_path'])) {
    addImagePage($pdf, 'ใบอนุญาตทำงาน', "../uploads/".$row['work_permit_path']);
}
if (!empty($row['passport_path'])) {
    addImagePage($pdf, 'หน้าพาสปอร์ต', "../uploads/".$row['passport_path']);
}
if (!empty($row['receipt_path'])) {
    addImagePage($pdf, 'ใบอนุญาตทำงาน', "../uploads/".$row['receipt_path']);
}
if (!empty($row['wp_book_path'])) {
    addImagePage($pdf, 'ใบอนุญาตทำงาน', "../uploads/".$row['wp_book_path']);
}
if (!empty($row['work_accept_path'])) {
    addImagePage($pdf, 'ใบอนุญาตทำงาน', "../uploads/".$row['work_accept_path']);
}
if (!empty($row['notice_file_path55'])) {
    addImagePage($pdf, 'ใบอนุญาตทำงาน', "../uploads/".$row['notice_file_path55']);
}
if (!empty($row['notice_file_path52'])) {
    addImagePage($pdf, 'ใบอนุญาตทำงาน', "../uploads/".$row['notice_file_path52']);
}
if (!empty($row['pink_card_front_path'])) {
    addImagePage($pdf, 'ใบอนุญาตทำงาน', "../uploads/".$row['pink_card_front_path']);
}
if (!empty($row['pink_card_back_path'])) {
    addImagePage($pdf, 'ใบอนุญาตทำงาน', "../uploads/".$row['pink_card_back_path']);
}

$pdf->Output('I', 'employee_'.$row['id'].'.pdf');
?>
