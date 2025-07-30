# 🏢 WorkWave - Employee Management System

## 🎯 Description
WorkWave is a comprehensive PHP Laravel web application that serves as a complete employee record administration portal featuring:

- **Multi-Role Access Control**: Secure login system with Employee and Administrator roles
- **Department Hierarchy**: Unlimited-level tree structure for organizational management  
- **Employee Management**: Complete CRUD operations with advanced DataTables integration
- **Real-Time Communication**: Live chat system with message history and pagination
- **Performance Optimized**: Redis caching, server-side pagination, and AJAX-powered interactions
- **Security First**: Role-based access control (RBAC) and SQL injection prevention

## 🏗️ Architecture
The application follows MVC architecture pattern with Laravel framework:
workwave/
├── app/
│   ├── Controllers/
│   │   ├── AuthController/       # Authentication logic
│   │   ├── DepartmentController/ # Department CRUD operations
│   │   ├── EmployeeController/   # Employee management
│   │   └── ChatController/       # Real-time messaging
│   ├── Models/
│   │   ├── User.php             # User model (Employee/Admin)
│   │   ├── Department.php       # Department hierarchy model
│   │   └── Message.php          # Chat message model
│   └── Middleware/
│       └── RoleMiddleware.php   # Role-based access control
├── resources/
│   ├── views/
│   │   ├── auth/               # Login/logout pages
│   │   ├── admin/              # Administrator dashboard
│   │   ├── employee/           # Employee profile pages
│   │   └── chat/               # Real-time chat interface
│   └── assets/
│       ├── js/                 # jQuery, AJAX, DataTables
│       └── css/                # Bootstrap, custom styling
├── database/
│   ├── migrations/             # Database schema
│   └── seeders/                # Default data (admin user)
└── routes/
├── web.php                 # Web routes
└── api.php                 # API endpoints


### Key Components:
- **AuthController**: Handles login/logout and session management
- **DepartmentController**: Tree structure management with AJAX filtering
- **EmployeeController**: DataTables with server-side pagination and batch operations
- **ChatController**: WebSocket/AJAX-powered real-time messaging
- **Role Middleware**: Ensures proper access control

### Database Structure:
- Users table with role-based permissions
- Departments with parent-child relationships (unlimited levels)
- Messages table with pagination support
- Soft delete implementation for data integrity

## 🔌 API Endpoints

### Authentication:
| Method | Endpoint | Description |
|--------|----------|-------------|
| `POST` | `/login` | User authentication |
| `POST` | `/logout` | Session termination |
| `GET` | `/dashboard` | Role-based dashboard redirect |

### Department Management (Admin Only):
| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/api/departments` | Fetch department tree structure |
| `POST` | `/api/departments` | Create new department |
| `PUT` | `/api/departments/{id}` | Update department |
| `DELETE` | `/api/departments/{id}` | Delete department |
| `GET` | `/api/departments/{id}/employees` | Get employees by department (AJAX) |

### Employee Management (Admin Only):
| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/api/employees` | Server-side paginated employee list |
| `POST` | `/api/employees` | Create new employee |
| `PUT` | `/api/employees/{id}` | Update employee |
| `DELETE` | `/api/employees/{id}` | Delete employee |
| `POST` | `/api/employees/batch` | Batch operations (insert/update/delete) |

### Employee Profile:
| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/profile` | View employee profile |
| `PUT` | `/profile` | Update profile data |
| `POST` | `/profile/picture` | Upload profile picture |

### Real-Time Chat:
| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/api/chat/messages` | Fetch chat history (paginated) |
| `POST` | `/api/chat/send` | Send new message |
| `WebSocket` | `/chat` | Real-time message updates |

## 🛠️ Local Setup

### Prerequisites:
- PHP 8.0 or higher
- Composer
- MySQL/MariaDB
- XAMPP (recommended)
- Node.js (for asset compilation)

### Installation:

1. **Clone the repository:**
```bash
git clone <repository-url>
cd workwave
Install PHP dependencies:
bash
composer install
Environment setup:
bash
cp .env.example .env
php artisan key:generate
Database configuration: Edit .env file:
env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=workwave
DB_USERNAME=root
DB_PASSWORD=
Run migrations and seeders:
bash
php artisan migrate
php artisan db:seed
Install frontend dependencies:
bash
npm install
npm run dev
Start the development server:
bash
php artisan serve
Access the application: Navigate to http://localhost:8000
🔑 Default Login Credentials:
Role	Username	Password
Admin	admin	admin1234
Employee	nevin.guni	Welcome123
❓ FAQ
<details> <summary><strong>Q: How do I add new employee roles?</strong></summary> <br> A: Modify the `roles` table and update the Role middleware in `app/Middleware/RoleMiddleware.php`. Add corresponding permissions in the controllers. </details> <details> <summary><strong>Q: Can I extend the department hierarchy levels?</strong></summary> <br> A: Yes, the system supports unlimited hierarchy levels. The tree structure is handled recursively in the Department model. </details> <details> <summary><strong>Q: How do I customize the DataTables pagination?</strong></summary> <br> A: Edit the pagination settings in `resources/js/datatables-config.js`. You can modify records per page, sorting options, and filtering behavior. </details> <details> <summary><strong>Q: Is the chat system scalable for large teams?</strong></summary> <br> A: The current implementation uses AJAX polling. For better scalability, consider integrating Laravel WebSockets or Pusher for real-time communication. </details> <details> <summary><strong>Q: How do I backup employee data?</strong></summary> <br> A: Use Laravel's built-in database backup commands or MySQL dump. Ensure you include the `users`, `departments`, and `messages` tables. </details> <details> <summary><strong>Q: Can I integrate with Active Directory?</strong></summary> <br> A: Yes, you can extend the authentication system to work with LDAP/Active Directory by modifying the AuthController and adding appropriate packages. </details> <details> <summary><strong>Q: How do I enable Redis caching?</strong></summary> <br> A: Install Redis server, update `.env` with Redis configuration, and uncomment caching logic in the DepartmentController and EmployeeController. </details> <details> <summary><strong>Q: What's the recommended server setup for production?</strong></summary> <br> A: Use nginx/Apache with PHP-FPM, MySQL 8.0+, Redis for caching, and SSL certificates. Enable Laravel's built-in security features and rate limiting. </details> <details> <summary><strong>Q: How do I customize the UI theme?</strong></summary> <br> A: Modify the Bootstrap variables in `resources/scss/variables.scss` and compile with `npm run production`. Custom CSS can be added to `resources/css/custom.css`. </details> <details> <summary><strong>Q: Can I export employee reports?</strong></summary> <br> A: The system supports batch operations. You can extend the EmployeeController to add CSV/PDF export functionality using Laravel Excel or DomPDF packages. </details>
🚀 Features
✅ Secure Authentication - Role-based login system
✅ Department Management - Unlimited hierarchy tree structure
✅ Employee CRUD - Complete employee lifecycle management
✅ Real-time Chat - Live messaging with history
✅ Advanced DataTables - Server-side pagination and filtering
✅ Batch Operations - Bulk employee management
✅ Profile Management - Employee self-service portal
✅ Performance Optimized - Redis caching and AJAX
✅ Mobile Responsive - Bootstrap-powered responsive design
✅ Security First - RBAC and SQL injection prevention
📝 License
This project is licensed under the MIT License - see the LICENSE file for details.

Built with 💼 using Laravel, MySQL, Bootstrap, jQuery, and AJAX




