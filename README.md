# Supplier Management System (Database Integration)

## Task Description

This project extends the Supplier Management System to include a database layer, using MySQL as the database and implementing the Repository Pattern for data management.

1. **Implement DB layer by using ORM or plain SQL with Repository pattern**  
   The database layer is implemented using Laravel Eloquent. All CRUD operations for the Supplier entity are managed through a repository class. Below is an example of how the logic was rewritten to interact with the MySQL database:

   ```php
    namespace App\Services;
    
    use App\Contracts\SupplierServiceInterface;
    use App\Models\Supplier;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Mantax559\LaravelHelpers\Helpers\SessionHelper;
    
    class SupplierService implements SupplierServiceInterface
    {
        public function getAll(array $filter): LengthAwarePaginator
        {
            session()->put(SessionHelper::getUrlKey(Supplier::class), request()->fullUrl());
    
            return Supplier::query()
                ->when(isset($filter['search']), fn ($q) => $q->whereLike([
                    'name',
                    'code',
                    'vat_code',
                    'address',
                    'responsible_person',
                    'contact_person',
                    'contact_phone',
                    'alternate_contact_phone',
                    'email',
                    'alternate_email',
                    'billing_email',
                    'alternate_billing_email',
                    'certificate_code',
                    'comments',
                ], $filter['search']))
                ->orderByDesc('id')
                ->paginate(setting('paginate'))
                ->onEachSide(setting('on_each_side'));
        }
    
        public function store(array $data): Supplier
        {
            unset($data['action']);
    
            return Supplier::create($data);
        }
    
        public function update(Supplier $supplier, array $data): Supplier
        {
            unset($data['action']);
    
            $supplier->update($data);
    
            return $supplier;
        }
    
        public function destroy(Supplier $supplier): void
        {
            $supplier->delete();
        }
    
        public function getById(int $id): Supplier
        {
            return Supplier::query()->findOrFail($id);
        }
    }
   ```

2. **Demonstrate 1 business entity creation, reading, editing, deleting**  
   CRUD operations for the Supplier entity are demonstrated through the API endpoints. These endpoints utilize the repository layer to perform database operations.

3. **Business entity should contain at least 4 editable properties**  
   The Supplier entity includes several editable properties, such as `company_name`, `company_code`, `email`, and `contact_person`, among others.

4. **Integrate 1.A, 1.B and 1.C alltogether (website uses API to manipulate data, where API uses DB layer to manipulate data in database)**  
   The website integrates all components, using the following flow:  
   - The website frontend sends requests to the API.  
   - The API interacts with the database through the repository layer, leveraging Laravel's Eloquent ORM to manipulate data in MySQL.  
   - Changes made in the database are reflected on the website frontend.

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
