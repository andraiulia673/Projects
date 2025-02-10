# Modeling Event Management Platform  

## Overview  
This web-based platform, developed using PHP, MySQL, HTML, CSS, and JavaScript, efficiently manages a modeling agency’s events and participant data. It provides authentication, structured event tracking, model participation management, and advanced data filtering through SQL queries.  

## Key Features  
- **User Authentication & Management**: Secure login, registration, and role-based access for event managers.  
- **Event & Model Management**: CRUD operations for models, designers, collections, and scheduled events.  
- **Dynamic Data Queries**: Advanced SQL queries for tracking model participation, event scheduling, and compatibility checks.  
- **Filtering & Search System**: Allows filtering based on model status, event location, and dress code compliance.  
- **Automated Event Timelines**: Generates event schedules and model walk orders dynamically.  

## Technology Stack  
- **Backend**: PHP, MySQL  
- **Frontend**: HTML, CSS, JavaScript  
- **Database Management**: Structured relational tables with optimized queries  
- **Security**: Data validation and access control for event managers  

## System Structure  

### **Database Design**  
The system is built with structured tables to ensure relational integrity, including:  
- `DressCode`: Defines event dress codes.  
- `Manager_evenimente`: Stores event managers' login credentials.  
- `Designer`: Maintains designer details and collections.  
- `Model`: Stores models' personal and professional data.  
- `Colectie_haine`: Tracks clothing collections linked to designers.  
- `Eveniment`: Manages event details, locations, and schedules.  
- `Eveniment_Model`: Tracks model participation in events.  
- `Model_Colectie_haine`: Associates models with clothing collections.  

### **Event & Model Queries**  
The system provides advanced SQL-based features such as:  
- **Model Ranking**: Identifies top models based on event participation.  
- **Collection Compatibility Check**: Ensures dress codes align with event requirements.  
- **Event Timeline Generation**: Organizes models' appearance order dynamically.  
- **Location-Based Search**: Finds events within specified locations.  

## User Interface Functionalities  
- **Login & Registration**: Secure authentication for event managers.  
- **Event Management Dashboard**: Enables adding, editing, and tracking events.  
- **Model Management**: Assigns models to events and collections dynamically.  
- **Database Search & Filtering**: Refines results based on model status, dress codes, and event locations.  

## Testing & Validation  
- Verification of user authentication and database registration.  
- CRUD operations testing for event, model, and designer data.  
- Validation of SQL queries for filtering and search efficiency.  
- Responsive UI compatibility across multiple devices.  

## Future Enhancements  
- Implementing role-based access control for different user types.  
- Enhancing reporting features with data analytics.  
- Integrating API-based event notifications and scheduling.  

## License  
This project is developed for business use and can be expanded with additional security and automation features.  
