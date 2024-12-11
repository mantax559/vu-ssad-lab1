
# Supplier Management System

## Task Description

This project demonstrates a Supplier Management System built using the Laravel framework, adhering to the MVC architectural pattern. Below are the implemented features based on the provided requirements:

1. **Create MVC, MVU or MVVM architectural pattern driven web site**:  
   The project is built using Laravel, which natively supports the MVC architecture.

2. **Site should allow creating, editing, viewing and deleting of at least one entity that is the main focus of business aplication (no persistence required)**:  
   CRUD (Create, Read, Update, Delete) operations are implemented for managing supplier entities. The data is stored in the session for simplicity. For example, the `update` method in the `SupplierService` class updates a supplier as follows:

   ```php
   public function update(int $id, array $data): object
   {
       unset($data['action']);
       $suppliers = Session::get(self::SESSION_KEY, []);

       foreach ($suppliers as &$supplier) {
           if (cmprint($supplier['id'], $id)) {
               $supplier = array_merge($supplier, $data, ['updated_at' => now()->toDateTimeString()]);
               break;
           }
       }

       Session::put(self::SESSION_KEY, $suppliers);

       return (object) $supplier;
   }
   ```

3. **Implement validation for all editable properties in create and update scenarios**:  
   The project is focused on the Supplier model. It includes more than four editable properties, with validation rules defined in the `SupplierUpdateRequest` class. Below is the validation logic for various fields:

   ```php
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    use Mantax559\LaravelHelpers\Helpers\RedirectHelper;
    use Mantax559\LaravelHelpers\Helpers\ValidationHelper;
    
    class SupplierUpdateRequest extends FormRequest
    {
        public function rules(): array
        {
            return [
                'action' => ValidationHelper::getInArrayRules(values: [RedirectHelper::SaveAndStay, RedirectHelper::SaveAndClose]),
                'company_name' => ValidationHelper::getStringRules(),
                'company_code' => ValidationHelper::getStringRules(),
                'company_vat_number' => ValidationHelper::getStringRules(required: false),
                'company_address' => ValidationHelper::getStringRules(),
                'responsible_person' => ValidationHelper::getStringRules(),
                'contact_person' => ValidationHelper::getStringRules(),
                'contact_phone' => ValidationHelper::getStringRules(),
                'alternate_contact_phone' => ValidationHelper::getStringRules(required: false),
                'email' => ValidationHelper::getStringRules(),
                'alternate_email' => ValidationHelper::getStringRules(required: false),
                'billing_email' => ValidationHelper::getStringRules(),
                'alternate_billing_email' => ValidationHelper::getStringRules(required: false),
                'certificate_code' => ValidationHelper::getStringRules(),
                'is_fsc' => ValidationHelper::getBooleanRules(),
                'validation_date' => ValidationHelper::getDateRules(),
                'expiry_date' => ValidationHelper::getDateRules(),
                'comments' => ValidationHelper::getTextRules(required: false),
            ];
        }
    }
   ```

4. **Dependency Injection (DI) and Inversion of Control (IoC)**:  
   Interfaces are used to facilitate DI and IoC. The `SupplierServiceInterface`, its implementation (`SupplierService`), and the usage in the `SupplierController` demonstrate this. Below are the examples:

   - **SupplierServiceInterface**:

   ```php
    namespace App\Contracts;
    
    use Illuminate\Pagination\LengthAwarePaginator;
    
    interface SupplierServiceInterface
    {
        public function getAll(array $filter): LengthAwarePaginator;
    
        public function store(array $data): object;
    
        public function update(int $id, array $data): object;
    
        public function destroy(int $id): void;
    
        public function getById(int $id): object;
    }
   ```

   - **SupplierService Implementation**:

   ```php
    namespace App\Services;
    
    use App\Contracts\SupplierServiceInterface;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Support\Facades\Session;
    
    class SupplierService implements SupplierServiceInterface
    {
        public const SESSION_KEY = 'suppliers';
    
        public function getAll(array $filter): LengthAwarePaginator
        {
            $suppliers = Session::get(self::SESSION_KEY, []);
    
            if (isset($filter['search'])) {
                $suppliers = array_filter($suppliers, function ($supplier) use ($filter) {
                    foreach ([
                        'name', 'code', 'vat_code', 'address', 'responsible_person',
                        'contact_person', 'contact_phone', 'alternate_contact_phone',
                        'email', 'alternate_email', 'billing_email', 'alternate_billing_email',
                        'certificate_code', 'comments',
                    ] as $field) {
                        if (stripos($supplier[$field] ?? '', $filter['search']) !== false) {
                            return true;
                        }
                    }
    
                    return false;
                });
            }
    
            $suppliers = array_map(fn ($supplier) => (object) $supplier, $suppliers);
    
            $suppliers = collect($suppliers)->sortByDesc('id')->values();
    
            $perPage = 5;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $pagedData = $suppliers->slice(($currentPage - 1) * $perPage, $perPage)->all();
    
            return new LengthAwarePaginator($pagedData, $suppliers->count(), $perPage, $currentPage, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]);
        }
    
        public function store(array $data): object
        {
            unset($data['action']);
            $suppliers = Session::get(self::SESSION_KEY, []);
    
            $id = count($suppliers) > 0 ? max(array_column($suppliers, 'id')) + 1 : 1;
            $timestamp = now()->toDateTimeString();
    
            $data = array_merge($data, [
                'id' => $id,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
    
            $suppliers[] = $data;
            Session::put(self::SESSION_KEY, $suppliers);
    
            return (object) $data;
        }
    
        public function update(int $id, array $data): object
        {
            unset($data['action']);
            $suppliers = Session::get(self::SESSION_KEY, []);
    
            foreach ($suppliers as &$supplier) {
                if (cmprint($supplier['id'], $id)) {
                    $supplier = array_merge($supplier, $data, ['updated_at' => now()->toDateTimeString()]);
                    break;
                }
            }
    
            Session::put(self::SESSION_KEY, $suppliers);
    
            return (object) $supplier;
        }
    
        public function destroy(int $id): void
        {
            $suppliers = Session::get(self::SESSION_KEY, []);
            $suppliers = array_filter($suppliers, fn ($supplier) => ! cmprint($supplier['id'], $id));
            Session::put(self::SESSION_KEY, $suppliers);
        }
    
        public function getById(int $id): object
        {
            $suppliers = Session::get(SupplierService::SESSION_KEY, []);
    
            return (object) collect($suppliers)->firstWhere('id', $id);
        }
    }
   ```

   - **SupplierController**:

   ```php
    namespace App\Http\Controllers;
    
    use App\Contracts\SupplierServiceInterface;
    use App\Http\Requests\SupplierIndexRequest;
    use App\Http\Requests\SupplierStoreRequest;
    use App\Http\Requests\SupplierUpdateRequest;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\View\View;
    
    class SupplierController extends Controller
    {
        public function __construct(private readonly SupplierServiceInterface $supplierService) {}
    
        public function index(SupplierIndexRequest $request): View
        {
            $filter = $request->validated();
            $suppliers = $this->supplierService->getAll($filter);
    
            return view('suppliers.index', compact('filter', 'suppliers'));
        }
    
        public function create(): View
        {
            return view('suppliers.form');
        }
    
        public function store(SupplierStoreRequest $request): RedirectResponse
        {
            $this->supplierService->store($request->validated());
    
            return redirect()->route('suppliers.index')->with('success', __('Entry successfully saved!'));
        }
    
        public function show(int $id): View
        {
            $supplier = $this->supplierService->getById($id);
    
            return view('suppliers.show', compact('supplier'));
        }
    
        public function edit(int $id): View
        {
            $supplier = $this->supplierService->getById($id);
    
            return view('suppliers.form', compact('supplier'));
        }
    
        public function update(int $id, SupplierUpdateRequest $request): RedirectResponse
        {
            $this->supplierService->update($id, $request->validated());
    
            return redirect()->route('suppliers.index')->with('success', __('Entry successfully saved!'));
        }
    
        public function destroy(int $id): RedirectResponse
        {
            $this->supplierService->destroy($id);
    
            return back()->with('success', __('Entry successfully deleted!'));
        }
    }
   ```

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
