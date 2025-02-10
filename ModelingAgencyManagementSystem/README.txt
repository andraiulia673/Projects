# Modeling Agency Management System  

## Overview  
This web application, developed using Java and various supporting technologies, is designed to manage modeling agency data efficiently. It provides authentication, user management, and complete CRUD operations for registered models. Additionally, it includes enhanced data validation, session management, and file handling functionalities.  

## Key Features  
- **User Authentication & Management**: Secure login, registration, session management, and logout.  
- **Model Data Management**: CRUD operations (Create, Read, Update, Delete) for models and their information.  
- **File Handling**: Upload, download, and delete PDF files (CVs) for each registered model.  
- **Data Validation**: Unique email and password constraints, along with input format validation.  
- **Status Filtering**: View models based on availability (active/inactive filtering).  

## Technology Stack  
- **Backend**: Java, Spring Boot  
- **Frontend**: HTML, CSS, JavaScript  
- **Database**: MySQL  
- **Security**: Validation constraints for authentication credentials  

## System Structure  

### **Controllers**  
Manages HTTP requests and application logic.  
- `AuthController`: Handles user authentication, registration, and session management.  
- `FotomodeleController`: Implements CRUD operations for models, including file handling.  
- `HomeController`: Defines homepage functionalities.  
- `StartController`: Manages the initial login route, adaptable for future modifications.  

### **Models**  
Defines database entities and Data Transfer Objects (DTOs).  
- `Fotomodel`: Maps the `fotomodele` table, handling attributes such as name, email, age, height, status, and CV path.  
- `Manager`: Represents the `manager` table, storing user authentication data.  

### **Repositories**  
Manages database operations.  
- `FotomodelRepository` & `ManagerRepository`: Perform queries based on email, password, and status filters.  

### **Services**  
Implements business logic.  
- `AuthService`: Handles authentication and access control.  
- `FileService`: Manages CV upload, download, and deletion.  

### **Templates**  
Contains structured HTML templates for frontend components.  

## User Interface Functionalities  
- **Login & Registration**: Input fields for email and password with validation checks.  
- **Model Management**: Add, edit, or remove registered models.  
- **File Uploading**: Attach and manage model CVs in PDF format.  
- **Status Filtering**: Filter models based on availability.  

## Testing & Validation  
- Authentication tests with valid and invalid credentials.  
- Database integrity checks for CRUD operations.  
- File path validation and proper file organization.  
- Responsive design compatibility across multiple devices.  

## Future Enhancements  
- Implementing advanced security measures for authentication.  
- Expanding filtering options for better data retrieval.  
- Enhancing UI/UX for a more intuitive experience.  
- Introducing user role differentiation for access control.  

## License  
This project is developed for internal use and may be extended with additional security features.  

