CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nationality ENUM('Thai', 'Foreign') NOT NULL,
    branch_id INT NOT NULL,
    action_type varchar(255) NOT NULL,
    emp_code VARCHAR(50) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    photo_path VARCHAR(255),
    work_permit_path VARCHAR(255),
    passport_path VARCHAR(255),
    receipt_path VARCHAR(255),
    wp_book_path VARCHAR(255),
    work_accept_path VARCHAR(255),
    notice_file_path55 VARCHAR(255),
    notice_file_path52 VARCHAR(255),
    pink_card_front_path VARCHAR(255),
    pink_card_back_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) 


CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    action_desc TEXT NOT NULL,
    done_by VARCHAR(100) NOT NULL,
    done_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(id)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- เพิ่มผู้ใช้เริ่มต้น
INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(2, 'admin', '$2y$10$s9DMj7z1pqwA2Tzfk9ILB.fOpCrULdAFLRqfo2CbWgIiOJCNRBhYC', 'admin', '2025-08-14 16:54:06'),
(3, 'user', '$2y$10$fxVx21vXmy2fWe35haGRe.wlQTHHOgSdw8EoH.JR6JAH/20PCCqMy', 'user', '2025-08-14 16:54:06');

CREATE TABLE branches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    branch_type ENUM('Suki','BBQ') NOT NULL  -- ตัวเลือกเฉพาะ 2 แบบ
    branch_order INT NOT NULL,  -- ลำดับที่คุณกำหนดเอง
    branch_name VARCHAR(255) NOT NULL UNIQUE,
    phonenumber VARCHAR(25) NOT NULL,
);