# 🛒 E-COMMERCE PLATFORM

## 📋 PROJECT OVERVIEW

A comprehensive e-commerce web application developed for IS207.O13 course, featuring a complete online shopping system with user-friendly interface and powerful administration panel.

## 🏗️ TECHNOLOGY STACK

### **Backend**
- **Framework**: Laravel 10.x (PHP 8.1+)
- **Database**: MySQL 8.0
- **Authentication**: Laravel Sanctum

## ✨ KEY FEATURES

### **🛍️ Customer Portal**
- **Homepage**: Featured products and promotions display
- **Product Catalog**: Category and subcategory organization
- **Advanced Search & Filter**: Smart search with multiple criteria
- **Product Details**: 
  - Multiple product images
  - Detailed specifications (colors, sizes, pricing)
  - Customer reviews and ratings
- **Shopping Cart**: Product management and total calculation
- **Checkout Process**: 
  - Online payment integration
  - Shipping information management
  - Voucher/discount code application
- **User Account**:
  - Registration/login with email verification
  - Profile management
  - Order history tracking
  - Product review system

### **👨‍💼 Admin Panel**
- **Analytics Dashboard**: Revenue reports with visual charts
- **Product Management**:
  - Full CRUD operations for products
  - Image and category management
  - Color and size variant management
- **Order Management**:
  - Order status tracking
  - Payment processing
  - Invoice printing (react-to-print)
- **Customer Management**:
  - User account information
  - Purchase history
  - Role-based permissions (Customer/Staff/Admin)
- **Voucher Management**: Discount code creation and management
- **Statistical Reports**: Revenue charts and bestselling products

## 🗄️ DATABASE STRUCTURE

The system includes **20+ optimized database tables**:

**Core Tables:**
- `taikhoans`: User management with role-based access
- `sanphams`: Product information
- `phanloai_sanpham`: Product categories (2-level hierarchy)
- `donhangs`: Order management
- `chitiet_donhangs`: Order details

**Support Tables:**
- `hinhanhsanphams`: Product images
- `mausacs`, `sizes`: Product attributes
- `sanpham_mausac_sizes`: Product variants
- `chitiet_giohangs`: Shopping cart items
- `vouchers`: Discount codes
- `danhgia_sanphams`: Product reviews
- `thongtingiaohangs`: Shipping information

## 🔒 SECURITY & AUTHENTICATION

- **Laravel Sanctum**: API authentication with tokens
- **Email Verification**: Registration email confirmation
- **Password Recovery**: Email-based password reset
- **Role-based Access Control**: 3-tier permissions (Customer/Staff/Admin)
- **CSRF Protection**: Cross-site request forgery prevention
- **Data Validation**: Comprehensive input validation

## 📊 ADVANCED FEATURES

### **Analytics & Reporting**
- Dashboard with statistical charts (Chart.js, Recharts)
- Time-based revenue reports
- Bestselling product statistics
- Customer behavior analysis

### **E-commerce Functionality**
- **Multi-variant Products**: Products with multiple colors and sizes
- **Advanced Search**: Smart product search and filtering
- **Review System**: 5-star rating system with comments
- **Voucher System**: Flexible discount code management
- **Order Tracking**: Real-time order status updates

### **User Experience**
- **Pagination**: Efficient data pagination (react-paginate)
- **Persistent Shopping Cart**: Cart data preservation
- **Product Reviews**: Customer feedback system
- **Email Notifications**: Automated email system

## 🛠️ DEVELOPMENT FEATURES

- **Docker Environment**: Consistent development environment
- **Code Quality**: ESLint configuration and code formatting
- **API Documentation**: Well-organized RESTful API with 50+ endpoints
- **Database Seeding**: Sample data for testing
- **Error Handling**: Comprehensive error management

## 💡 PROJECT IMPACT

This project demonstrates the ability to develop a complete fullstack web application, from database design and backend API development to modern frontend implementation. The system is scalable and suitable for real-world commercial requirements.

---

**Technologies**: Laravel | React | MySQL | Docker | Nginx | Vercel

   
