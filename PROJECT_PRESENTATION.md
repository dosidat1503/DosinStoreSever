# 🛒 HỆ THỐNG THƯƠNG MẠI ĐIỆN TỬ (E-COMMERCE PLATFORM)

## 📋 TỔNG QUAN DỰ ÁN

Đây là một hệ thống thương mại điện tử toàn diện được phát triển cho môn học **IS207.O13**, bao gồm đầy đủ các tính năng của một trang web bán hàng online hiện đại với giao diện người dùng thân thiện và hệ thống quản trị mạnh mẽ.

## 🏗️ KIẾN TRÚC CÔNG NGHỆ

### **Backend**
- **Framework**: Laravel 10.x (PHP 8.1+)
- **Database**: MySQL 8.0
- **Authentication**: Laravel Sanctum
- **Testing**: PHPUnit

### **Frontend**
- **Framework**: React 18.2.0
- **UI Libraries**: 
  - Material-UI (@mui/material)
  - Bootstrap 5.3.2
  - FontAwesome Icons
- **Charts**: Chart.js, Recharts
- **Routing**: React Router DOM 6.x

### **DevOps & Deployment**
- **Containerization**: Docker & Docker Compose
- **Web Server**: Nginx
- **Cloud Deployment**: Vercel
- **Development Tools**: Vite, ESLint

## ✨ TÍNH NĂNG CHÍNH

### **🛍️ Phía Khách Hàng (Customer Portal)**
- **Trang chủ**: Hiển thị sản phẩm nổi bật, khuyến mãi
- **Danh mục sản phẩm**: Phân loại theo category và subcategory
- **Tìm kiếm & Lọc**: Tìm kiếm thông minh với nhiều tiêu chí
- **Chi tiết sản phẩm**: 
  - Hình ảnh đa dạng
  - Thông tin chi tiết (màu sắc, size, giá)
  - Đánh giá & nhận xét của khách hàng
- **Giỏ hàng**: Quản lý sản phẩm, tính toán tổng tiền
- **Thanh toán**: 
  - Thanh toán online
  - Quản lý thông tin giao hàng
  - Áp dụng voucher giảm giá
- **Tài khoản cá nhân**:
  - Đăng ký/đăng nhập với xác thực email
  - Quản lý thông tin cá nhân
  - Lịch sử đơn hàng
  - Đánh giá sản phẩm đã mua

### **👨‍💼 Phía Quản Trị (Admin Panel)**
- **Dashboard thống kê**: Báo cáo doanh thu, biểu đồ trực quan
- **Quản lý sản phẩm**:
  - CRUD operations cho sản phẩm
  - Quản lý hình ảnh, danh mục
  - Quản lý màu sắc và kích thước
- **Quản lý đơn hàng**:
  - Theo dõi trạng thái đơn hàng
  - Xử lý thanh toán
  - In hóa đơn (react-to-print)
- **Quản lý khách hàng**:
  - Thông tin tài khoản
  - Lịch sử mua hàng
  - Phân quyền (Customer/Staff/Admin)
- **Quản lý voucher**: Tạo và quản lý mã giảm giá
- **Báo cáo thống kê**: Biểu đồ doanh thu, sản phẩm bán chạy

## 🗄️ CẤU TRÚC DATABASE

Hệ thống bao gồm **20+ bảng dữ liệu** được thiết kế tối ưu:

**Core Tables:**
- `taikhoans`: Quản lý người dùng với phân quyền
- `sanphams`: Thông tin sản phẩm
- `phanloai_sanpham`: Danh mục sản phẩm (2 cấp)
- `donhangs`: Đơn hàng
- `chitiet_donhangs`: Chi tiết đơn hàng

**Support Tables:**
- `hinhanhsanphams`: Hình ảnh sản phẩm
- `mausacs`, `sizes`: Thuộc tính sản phẩm
- `sanpham_mausac_sizes`: Biến thể sản phẩm
- `chitiet_giohangs`: Giỏ hàng
- `vouchers`: Mã giảm giá
- `danhgia_sanphams`: Đánh giá sản phẩm
- `thongtingiaohangs`: Thông tin giao hàng

## 🔒 BẢO MẬT & AUTHENTICATION

- **Laravel Sanctum**: API authentication với token
- **Email Verification**: Xác thực email khi đăng ký
- **Password Recovery**: Khôi phục mật khẩu qua email
- **Role-based Access Control**: Phân quyền 3 cấp (Customer/Staff/Admin)
- **CSRF Protection**: Bảo vệ khỏi CSRF attacks
- **Data Validation**: Validation dữ liệu toàn diện

## 📱 RESPONSIVE DESIGN

- **Mobile-First Approach**: Tối ưu cho thiết bị di động
- **Bootstrap Grid System**: Layout responsive
- **Modern UI/UX**: Giao diện hiện đại, thân thiện người dùng
- **Loading States**: Trải nghiệm người dùng mượt mà

## 🚀 PERFORMANCE & OPTIMIZATION

- **Database Optimization**: Indexes, relationships được tối ưu
- **API Efficiency**: RESTful API design
- **Code Splitting**: React lazy loading
- **Image Optimization**: Quản lý hình ảnh hiệu quả
- **Caching Strategy**: Laravel caching mechanisms

## 📊 TÍNH NĂNG NỔI BẬT

### **Analytics & Reporting**
- Dashboard với biểu đồ thống kê (Chart.js, Recharts)
- Báo cáo doanh thu theo thời gian
- Thống kê sản phẩm bán chạy
- Phân tích hành vi khách hàng

### **E-commerce Features**
- **Multi-variant Products**: Sản phẩm với nhiều màu sắc, kích thước
- **Advanced Search**: Tìm kiếm và lọc sản phẩm thông minh
- **Review System**: Hệ thống đánh giá 5 sao với comment
- **Voucher System**: Mã giảm giá linh hoạt
- **Order Tracking**: Theo dõi trạng thái đơn hàng real-time

### **User Experience**
- **Pagination**: Phân trang hiệu quả (react-paginate)
- **Shopping Cart**: Giỏ hàng persistent
- **Wishlist**: Danh sách yêu thích
- **Product Comparison**: So sánh sản phẩm
- **Quick View**: Xem nhanh sản phẩm

## 🛠️ DEVELOPMENT FEATURES

- **Docker Environment**: Development environment nhất quán
- **Code Quality**: ESLint, code formatting
- **API Documentation**: RESTful API với route organization
- **Database Seeding**: Sample data cho testing
- **Error Handling**: Comprehensive error management

## 📈 THÀNH TỰU KỸ THUẬT

1. **Fullstack Development**: Thành thạo cả Frontend (React) và Backend (Laravel)
2. **Database Design**: Thiết kế cơ sở dữ liệu phức tạp với 20+ bảng
3. **API Development**: RESTful API với 50+ endpoints
4. **Modern Frontend**: React với hooks, context, modern UI libraries
5. **DevOps Skills**: Docker, deployment automation
6. **Security Implementation**: Authentication, authorization, data protection

## 🔗 LIÊN KẾT DỰ ÁN

- **Repository**: [GitHub Link]
- **Live Demo**: [Demo URL nếu có]
- **Technical Documentation**: [API Documentation]

## 💡 KẾT LUẬN

Dự án này thể hiện khả năng phát triển ứng dụng web fullstack hoàn chỉnh, từ thiết kế database, xây dựng API backend đến phát triển giao diện frontend hiện đại. Hệ thống có thể scale và phù hợp với yêu cầu thương mại thực tế.

---

**Công nghệ sử dụng**: Laravel | React | MySQL | Docker | Nginx | Vercel
**Thời gian phát triển**: [Thời gian thực hiện dự án]
**Nhóm phát triển**: [Số thành viên team]