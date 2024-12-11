<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class SupplierApiTest extends TestCase
{
    private array $supplierData = [
        'company_name' => 'Test Company',
        'company_code' => '123456789',
        'company_vat_number' => 'LT123456789',
        'company_address' => 'Test Street 1, Vilnius, Lithuania',
        'responsible_person' => 'John Doe',
        'contact_person' => 'Jane Doe',
        'contact_phone' => '+37060000001',
        'alternate_contact_phone' => '+37060000002',
        'email' => 'info@google.com',
        'alternate_email' => 'info@google.com',
        'billing_email' => 'info@google.com',
        'alternate_billing_email' => 'info@google.com',
        'certificate_code' => 'CERT123',
        'is_fsc' => true,
        'validation_date' => '2024-01-01 14:15:16',
        'expiry_date' => '2025-01-01 17:18:19',
        'comments' => 'Test comment',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        Session::start();
    }

    public function test_index(): void
    {
        $this->createSupplier();

        $response = $this->getJson('/api/suppliers');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'OK',
                'data' => [
                    'current_page' => 1,
                    'data' => [
                        $this->supplierData,
                    ],
                    'first_page_url' => 'http://127.0.0.1:8000/api/suppliers?page=1',
                    'from' => 1,
                    'last_page' => 1,
                    'last_page_url' => 'http://127.0.0.1:8000/api/suppliers?page=1',
                    'links' => [
                        [
                            'url' => null,
                            'label' => '&laquo; Previous',
                            'active' => false,
                        ],
                        [
                            'url' => 'http://127.0.0.1:8000/api/suppliers?page=1',
                            'label' => '1',
                            'active' => true,
                        ],
                        [
                            'url' => null,
                            'label' => 'Next &raquo;',
                            'active' => false,
                        ],
                    ],
                    'next_page_url' => null,
                    'path' => 'http://127.0.0.1:8000/api/suppliers',
                    'per_page' => 5,
                    'prev_page_url' => null,
                    'to' => 1,
                    'total' => 1,
                ],
            ]);
    }

    public function test_store(): void
    {
        $response = $this->postJson('/api/suppliers', $this->supplierData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'OK',
                'data' => $this->supplierData,
            ]);
    }

    public function test_show(): void
    {
        $supplierId = $this->createSupplier();

        $response = $this->getJson("/api/suppliers/$supplierId/show");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'OK',
                'data' => $this->supplierData,
            ]);
    }

    public function test_update(): void
    {
        $supplierId = $this->createSupplier();

        $updateData = [
            'company_name' => 'New Test Company',
            'company_code' => 'New 123456789',
            'company_vat_number' => 'New LT123456789',
            'company_address' => 'New Test Street 1, Vilnius, Lithuania',
            'responsible_person' => 'New John Doe',
            'contact_person' => 'New Jane Doe',
            'contact_phone' => 'New +37060000001',
            'alternate_contact_phone' => 'New +37060000002',
            'email' => 'New info@google.com',
            'alternate_email' => 'New info@google.com',
            'billing_email' => 'New info@google.com',
            'alternate_billing_email' => 'New info@google.com',
            'certificate_code' => 'New CERT123',
            'is_fsc' => false,
            'validation_date' => '2025-02-03 12:10:24',
            'expiry_date' => '2028-04-04 14:24:15',
            'comments' => 'New Test comment',
        ];

        $response = $this->putJson("/api/suppliers/$supplierId", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'OK',
                'data' => $updateData,
            ]);
    }

    public function test_destroy(): void
    {
        $supplierId = $this->createSupplier();

        $response = $this->deleteJson("/api/suppliers/$supplierId");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'OK',
                'data' => [],
            ]);
    }

    private function createSupplier(): int
    {
        $response = $this->postJson('/api/suppliers', $this->supplierData);

        return $response->json('data.id');
    }
}
