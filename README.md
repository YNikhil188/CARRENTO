# CarRento - Car Rental Management System

A comprehensive web-based car rental management system built with PHP, MySQL, HTML, CSS, and JavaScript.

## 🚗 Project Overview

CarRento is a full-featured car rental platform that allows users to browse, book, and manage car rentals online. The system includes user authentication, booking management, payment processing, and administrative features.

## ✨ Features

### For Users
- **User Registration & Authentication** - Sign up, login, and profile management
- **Car Browsing** - View available cars by category (Sedan, SUV, Off-Road)
- **Advanced Booking System** - Select dates, calculate pricing, and confirm bookings
- **Booking Management** - View and manage personal bookings
- **Feedback System** - Rate and review rental experiences
- **Payment Integration** - Secure payment processing
- **Blog System** - Read car-related articles and news

### For Administrators
- **Car Management** - Add, edit, and delete vehicles from the fleet
- **Booking Management** - View and manage all customer bookings
- **User Management** - Manage customer accounts and profiles
- **Employee Management** - Manage staff accounts and roles
- **Payment Management** - Track and manage payments
- **Query Management** - Handle customer inquiries and support
- **Feedback Management** - View and respond to customer feedback

### For Employees
- **Employee Dashboard** - Access to relevant booking and customer information
- **Profile Management** - Update employee profiles and information
- **Chat System** - Communication between users, employees, and admins

## 🛠️ Technology Stack

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP 8.x
- **Database:** MySQL (MariaDB)
- **Server:** Apache (XAMPP)
- **Additional:** Font Awesome icons, Google Fonts

## 📋 Prerequisites

- XAMPP Server (Apache + MySQL + PHP)
- Web browser (Chrome, Firefox, Safari, etc.)
- Text editor or IDE (VS Code, Sublime Text, etc.)

## 🚀 Installation & Setup

1. **Clone or Download the Project**
   ```bash
   git clone https://github.com/your-username/carrento.git
   # OR download and extract the ZIP file
   ```

2. **Move to XAMPP Directory**
   ```
   Copy the CARRENTO folder to: C:\xampp\htdocs\CARRENTO
   ```

3. **Start XAMPP Services**
   - Start Apache server
   - Start MySQL server

4. **Database Setup**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `carrento`
   - Import the `carrento.sql` file from the project root

5. **Configure Database Connection**
   - Open `config.php`
   - Update database credentials if necessary:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "carrento";
     ```

6. **Access the Application**
   - Open browser and navigate to: `http://localhost/CARRENTO`

## 📁 Project Structure

```
CARRENTO/
├── img/                    # Image assets
├── uploads/               # User uploaded files (licenses, etc.)
├── video/                 # Video assets for background
├── python/                # Python integration files
├── sql or db/             # Database related files
├── index.php              # Homepage
├── config.php             # Database configuration
├── carrento.sql           # Database schema and sample data
├── login.html             # User login page
├── signup.html            # User registration page
├── cars.php               # Car listing page
├── booking.php            # Car booking page
├── mybookings.php         # User bookings page
├── dashboard.html         # Admin dashboard
├── managecars.php         # Admin car management
├── managebookings.php     # Admin booking management
├── manageusers.php        # Admin user management
├── feedback.php           # Feedback system
├── contact.php            # Contact page
├── blog.html              # Blog page
└── aboutus.html           # About us page
```

## 🗃️ Database Schema

### Main Tables
- **users** - User accounts (customers, employees, admins)
- **cars** - Vehicle information and specifications
- **bookings** - Rental bookings and reservations
- **feedback** - Customer reviews and ratings

## 👥 User Roles

1. **Customer (usertype: 2)** - Regular users who rent cars
2. **Admin (usertype: 1)** - Full system access and management
3. **Employee** - Limited access for customer service

## 🔐 Default Login Credentials

### Admin Account
- **Email:** admin@gmail.com
- **Password:** 1234

### Sample User Account
- **Email:** nikhil@gmail.com
- **Password:** 1234

## 🎨 Key Features in Detail

### Responsive Design
- Mobile-friendly interface
- Hamburger menu for small screens
- Optimized for various screen sizes

### Video Backgrounds
- Dynamic video backgrounds for enhanced user experience
- Auto-playing promotional videos

### Interactive Elements
- Hover effects and animations
- Tooltip navigation
- Smooth transitions

### Security Features
- Session management
- Password protection
- Secure file uploads

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📞 Contact Information

- **Email:** yalakanikhil30@gmail.com
- **Phone:** 305-890-2051
- **Address:** 7620 NW 25th St Unit 2, Miami, FL 33122

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 🐛 Known Issues & Troubleshooting

### Common Issues:
1. **Database Connection Error**
   - Ensure MySQL service is running
   - Verify database credentials in `config.php`

2. **Image/Video Not Loading**
   - Check file permissions
   - Ensure files exist in respective directories

3. **Session Issues**
   - Clear browser cache and cookies
   - Restart Apache server

## 🔄 Future Enhancements

- [ ] Mobile app integration
- [ ] Advanced search filters
- [ ] GPS tracking for rentals
- [ ] Multi-language support
- [ ] Enhanced payment gateway integration
- [ ] Email notification system
- [ ] Advanced reporting dashboard

## 📱 Screenshots

Visit the application at `http://localhost/CARRENTO` to explore all features!

---

**Note:** This is a educational/demonstration project. For production use, implement additional security measures, input validation, and error handling.