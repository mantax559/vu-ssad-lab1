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
5. 
   ![Test results screenshot](https://img001.prntscr.com/file/img001/0QEDJS0FSmiSXigsod59VQ.jpeg)

## Instructions to Run the Laravel Project

To set up and run this Laravel project, follow these steps:

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/mantax559/vu-ssad-lab1
   cd vu-ssad-lab1
   ```

2. **Install Dependencies**:
   Make sure you have Composer installed, then run:
   ```bash
   composer install
   ```

3. **Set Up Environment**:
   Copy the `.env.example` file to `.env` and configure the necessary environment variables (e.g., database connection, application key).

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Run the Application**:
   Start the Laravel development server using:
   ```bash
   php artisan serve
   ```

6. **Access the Application**:
   Open a browser and navigate to:
   ```
   http://127.0.0.1:8000
   ```

The application is now ready to use for managing suppliers.
