
# Supplier Management System (API-Based)

## Task Description

This project demonstrates extending the Supplier Management System to use APIs for CRUD operations, along with unit test coverage for API public contracts.

1. **Create Web Service as API**  
   The `SupplierController` was rewritten to handle CRUD operations via API requests instead of form submissions. This enables direct interaction using HTTP requests such as `POST`, `GET`, `PUT`, and `DELETE`.

2. **Demonstrate 1 business entity creation, reading, editing, deleting, use 4 HTTP verbs (no persistence required)**  
   The Supplier entity is managed via APIs, utilizing HTTP methods (`POST` for creation, `GET` for reading, `PUT` for updating, and `DELETE` for deletion).

3. **Business entity should contain at least 4 editable properties**  
   The Supplier entity contains more than four editable properties, all validated properly as per the defined rules.

4. **Unit tests for all API public contracts (100% coverage)**  
   Unit tests are implemented in the file `tests/Feature/SupplierApiTest.php`. To run the tests, execute the following command:
   ```bash
   php artisan test
   ```  
   This ensures that the API contracts are fully tested and validated.
   ![Test results screenshot](https://img001.prntscr.com/file/img001/0QEDJS0FSmiSXigsod59VQ.jpeg)

## Laravel Installation Instructions

To set up and run this Laravel project, follow these steps:

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd <repository-folder>
   ```

2. **Install Dependencies**  
   Ensure Composer is installed, then run:
   ```bash
   composer install
   ```

3. **Set Up Environment**  
   Configure environment variables by copying the `.env.example` file to `.env` and adjusting settings such as database connection and application key.

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Run the Application**  
   Start the Laravel server:
   ```bash
   php artisan serve
   ```

6. **Access the Application**  
   Navigate to:
   ```
   http://127.0.0.1:8000
   ```

The application is now ready for API interaction and testing.
