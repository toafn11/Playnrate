<?php
// Nhúng file kết nối database
require_once 'db-connect.php';

// 1. Tên đăng nhập và mật khẩu bạn muốn tạo
$username = 'admin';
$raw_password = '@dmin';

// 2. Mã hóa mật khẩu chuẩn bảo mật PHP
$hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

// 3. Viết lệnh SQL chèn vào DB (Thiết lập role là 'admin')
$sql = "INSERT INTO users (username, password, role) 
        VALUES ('$username', '$hashed_password', 'admin')";

// 4. Thực thi và báo kết quả
if ($conn->query($sql) === TRUE) {
    echo "<h2>Tạo tài khoản Admin thành công!</h2>";
    echo "<p>Username: <b>$username</b></p>";
    echo "<p>Password: <b>$raw_password</b></p>";
    echo "<p><i>(Mật khẩu đã được mã hóa an toàn trong Database)</i></p>";
} else {
    // Nếu bị lỗi (ví dụ như trùng tên username đã có)
    echo "Lỗi: " . $conn->error;
}
