# 🚗 Online Vehicle Rental Platform

A modern vehicle rental platform designed to make browsing, booking, and managing vehicle rentals simple and efficient for users.

---

## 📑 Table of Contents
- **Key Features**
  - For Customers
  - For Administrators
- **Technologies Used**
- **Technical Features**
- **Getting Started**
  - Installation
  - Usage
- **Diagrams**
  - UML Use Case Diagram
  - Class Diagram

---

## 🚀 Key Features

### For Customers
- Secure authentication for platform access
- Browse vehicles by category
- Detailed vehicle information (model, price, availability)
- Booking system with date and location selection
- Advanced vehicle search
- Dynamic filtering without page reload
- Review and rating system
- Paginated vehicle listings
  - Standard version: PHP pagination
  - Advanced version: DataTable integration
- Personal review management (edit/delete with Soft Delete)

### For Administrators
- Bulk insertion of vehicles and categories
- Comprehensive admin dashboard with statistics
- Full management of:
  - Reservations
  - Vehicles
  - Reviews
  - Categories

---

## 🛠 Technologies Used
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL

---

## 🧑‍💻 Technical Features
- SQL View "ListeVehicules" for optimized vehicle display
- Stored Procedure "AjouterReservation" for reservation management

---

## 🚦 Getting Started

### Installation
1. Clone the repository:  
   ```bash
   git clone https://github.com/bourraOmar/driveblog.git
   ```
2. Navigate to the project directory:  
   ```bash
   cd driveblog
   ```
3. Install dependencies:  
   ```bash
   composer install
   ```
4. Set up the database:
   - Create a new MySQL database.
   - Import the provided SQL file:  
     ```bash
     mysql -u username -p database_name < database.sql
     ```

### Usage
1. Start the development server:  
   ```bash
   php -S localhost:8000
   ```
2. Open your browser and navigate to:  
   ```
   http://localhost:8000
   ```

---

## 📊 Diagrams
- **UML Use Case Diagram**  
  ![UML Use Case Diagram](https://lucid.app/lucidchart/04718ec9-5f96-4924-99dd-696bd4709b77/edit?viewport_loc=-2016%2C-422%2C5120%2C2416%2C0_0&invitationId=inv_37671a45-1218-4a1f-8ac2-564429b8b7f2)
  
- **Class Diagram**  
  ![Class Diagram](https://lucid.app/lucidchart/29960632-e59a-4a9c-94ea-12314694f68c/edit?invitationId=inv_acda743b-1c36-4567-a075-94e772308284)

---

Enjoy exploring and using the platform! 🚀
