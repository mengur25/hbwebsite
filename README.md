# hbwebsite

## Giới thiệu dự án

Dự án "Website Booking Hotel" là đồ án cuối kỳ môn Lập trình Web và Ứng dụng tại Trường Đại học Tôn Đức Thắng, Khoa Công nghệ Thông tin.  
Website được xây dựng nhằm đáp ứng nhu cầu đặt phòng khách sạn trực tuyến, giúp người dùng dễ dàng tìm kiếm, đặt phòng và thanh toán, đồng thời hỗ trợ quản lý khách sạn hiệu quả hơn.  

- **Giảng viên hướng dẫn**: ThS. Đoàn Xuân Thanh  
- **Sinh viên thực hiện**:  
  - Dương Ngọc Khôi Nguyên  
  - Bùi Thị Thanh Ngân  
- **Thời gian hoàn thành**: Ngày 20 tháng 5 năm 2025  
- **Địa điểm**: Thành phố Hồ Chí Minh, Trường Đại học Tôn Đức Thắng  

## Mục tiêu dự án

Cung cấp một nền tảng trực tuyến để người dùng tìm kiếm, kiểm tra tình trạng phòng, đặt phòng, thanh toán và quản lý hồ sơ cá nhân.  
Hỗ trợ quản lý khách sạn với các chức năng như quản lý phòng, đặt phòng, đánh giá, và cài đặt website.  
Tích hợp các công nghệ hiện đại để đảm bảo giao diện thân thiện, an toàn thông tin và hiệu suất ổn định.  

## Công nghệ sử dụng

Dự án sử dụng các công nghệ và thư viện sau:  

### Frontend:
- HTML5: Cấu trúc giao diện website.  
- CSS3: Thiết kế và tạo kiểu cho giao diện.  
- JavaScript: Xử lý tương tác động trên website.  
- Bootstrap 5: Hỗ trợ thiết kế giao diện responsive.  
- CKEditor 5: Dùng cho phần chỉnh sửa nội dung của admin.  

### Backend:
- PHP: Xử lý logic phía server.  
- MySQL: Quản lý cơ sở dữ liệu.  

### Tích hợp thanh toán:
- VNPay (hỗ trợ thanh toán qua QR, thẻ nội địa, thẻ quốc tế).  

### Công cụ thiết kế hệ thống:
- UML (Use Case, Sequence Diagram, ERD): Phân tích và thiết kế hệ thống.  
- Web Server & Web API: Kết nối và xử lý dữ liệu.  

## Cấu trúc dự án

Website được chia thành hai phần chính:  

### Phía Admin:
- Quản lý đặt phòng (gán số phòng, hoàn tiền, lịch sử đặt phòng).  
- Quản lý người dùng, phòng, tiện nghi, đánh giá và cài đặt website.  
- Giao diện dashboard, quản lý hình ảnh, và hỗ trợ đóng website.  

### Phía Người dùng:
- Trang chủ: Hiển thị thông tin phòng, tiện nghi, đánh giá và liên hệ.  
- Trang tất cả phòng: Lọc và tìm kiếm phòng theo tiêu chí.  
- Trang chi tiết phòng, đặt phòng, thanh toán (tích hợp VNPay).  
- Quản lý hồ sơ cá nhân và phòng đã đặt.  

## Các chức năng chính

- **Người dùng**: Tìm kiếm phòng, đặt phòng, thanh toán trực tuyến, quản lý hồ sơ, đánh giá và phản hồi.  
- **Admin**: Quản lý phòng, đặt phòng, người dùng, đánh giá, tiện nghi, và cài đặt website.  

## Phân công công việc

| STT | Họ và Tên               | Công việc phụ trách                              | Tỷ lệ đóng góp |
|-----|-------------------------|--------------------------------------------------|----------------|
| 1   | Dương Ngọc Khôi Nguyên  | Phát triển website (frontend, backend, CSDL)     | 50%            |
| 2   | Bùi Thị Thanh Ngân      | Viết báo cáo, phân tích hệ thống, kiểm thử       | 50%            |

## Kết quả đạt được

Hoàn thiện website với đầy đủ chức năng cho cả người dùng và admin.  
Ứng dụng kiến thức lập trình web vào thực tế, rèn luyện kỹ năng thực hành.  
Đảm bảo giao diện thân thiện, hiệu suất ổn định và an toàn thông tin.  

## Hạn chế

Kiến thức và kinh nghiệm còn hạn chế, có thể tồn tại một số thiếu sót.  
Chưa tối ưu hóa hoàn toàn một số chức năng.  

## Hướng phát triển tương lai

Mở rộng phương thức thanh toán và tích hợp thêm các cổng thanh toán khác.  
Cải thiện hiệu suất và tối ưu hóa giao diện trên các thiết bị di động.  
Thêm các tính năng như gợi ý phòng thông minh, thông báo qua email/SMS.  

## Hướng dẫn cài đặt và sử dụng

### Yêu cầu môi trường:
- Web Server (Apache/Nginx).  
- PHP (phiên bản 7.x trở lên).  
- MySQL (phiên bản 5.7 trở lên).  

### Cài đặt:
- Clone hoặc tải mã nguồn về máy.  
- Cấu hình cơ sở dữ liệu MySQL và import schema từ file `database.sql`.  
- Cập nhật thông tin kết nối CSDL trong file cấu hình (`config.php`).  
- Đặt thư mục dự án vào thư mục web server (ví dụ: `htdocs` nếu dùng XAMPP).  
