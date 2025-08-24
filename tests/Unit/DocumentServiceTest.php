<?php

use App\Models\Document;
use App\Models\Enterprise;
use App\Models\Member;
use App\Services\DocumentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Unit\TestDocumentable;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->service = new DocumentService;
    Storage::fake('local');
    Storage::fake('public');
});

describe('DocumentService', function () {
    describe('save', function () {
        it('saves a new document successfully without file', function () {
            $user = \App\Models\User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $sector = createUniqueSector();
            $country = createUniqueCountry();

            $enterprise = Enterprise::create([
                'ifu' => 'IFU12345678901234',
                'name' => 'Test Enterprise',
                'active' => true,
                'code' => 'TEST001',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address',
                'zip_code' => '12345',
                'email' => 'test@enterprise.com',
                'phone' => '1234567890',
                'website' => 'https://test.com',
                'country_code' => $country->code,
            ]);

            $location = \App\Models\Location::create([
                'enterprise_id' => $enterprise->id,
                'name' => 'Test Location',
                'address' => 'Test Address',
                'city' => 'Test City',
                'state' => 'Test State',
                'zip_code' => '12345',
                'country' => 'Test Country',
                'phone' => '1234567890',
                'email' => 'test@location.com',
                'active' => true,
            ]);

            $member = Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user->id,
                'location_id' => $location->id,
                'status_by' => $user->id,
                'type' => 'employee',
                'status' => 'active',
                'username' => 'testuser',
                'code' => 'MEM001',
                'birth_date' => '1990-01-01',
                'marital_status' => 'single',
                'nationality' => 'US',
                'role' => 'Developer',
                'joining_date' => '2023-01-01',
            ]);

            $data = [
                'key' => 'test-document',
                'name' => 'Test Document',
                'path' => 'path/to/document.pdf',
                'active' => true,
                'scope' => 'private',
            ];

            $document = $this->service->save($data, $member, $enterprise);

            expect($document)->toBeInstanceOf(Document::class);
            expect($document->key)->toBe('test-document');
            expect($document->name)->toBe('Test Document');
            expect($document->path)->toBe('/storage//path/to/document.pdf');
            expect($document->active)->toBe(true);
            expect($document->scope)->toBe('private');
            expect($document->documentable_id)->toBe($member->id);
            expect($document->documentable_type)->toBe(Member::class);
        });

        it('saves a new document with file upload', function () {
            $user = \App\Models\User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $sector = createUniqueSector();
            $country = createUniqueCountry();

            $enterprise = Enterprise::create([
                'ifu' => 'IFU12345678901234',
                'name' => 'Test Enterprise',
                'active' => true,
                'code' => 'TEST001',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address',
                'zip_code' => '12345',
                'email' => 'test@enterprise.com',
                'phone' => '1234567890',
                'website' => 'https://test.com',
                'country_code' => $country->code,
            ]);

            $location = \App\Models\Location::create([
                'enterprise_id' => $enterprise->id,
                'name' => 'Test Location',
                'address' => 'Test Address',
                'city' => 'Test City',
                'state' => 'Test State',
                'zip_code' => '12345',
                'country' => 'Test Country',
                'phone' => '1234567890',
                'email' => 'test@location.com',
                'active' => true,
            ]);

            $member = Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user->id,
                'location_id' => $location->id,
                'status_by' => $user->id,
                'type' => 'employee',
                'status' => 'active',
                'username' => 'testuser',
                'code' => 'MEM001',
                'birth_date' => '1990-01-01',
                'marital_status' => 'single',
                'nationality' => 'US',
                'role' => 'Developer',
                'joining_date' => '2023-01-01',
            ]);

            $file = UploadedFile::fake()->create('document.pdf', 100);

            $data = [
                'key' => 'test-document',
                'name' => 'Test Document',
                'scope' => 'public',
            ];

            $document = $this->service->save($data, $member, $enterprise, $file);

            expect($document)->toBeInstanceOf(Document::class);
            expect($document->key)->toBe('test-document');
            expect($document->name)->toBe('Test Document');
            expect($document->scope)->toBe('public');
            expect($document->path)->not->toBeNull();
            expect($document->path)->toContain('documents/' . $enterprise->id . '/Member/' . $member->id);
        });

        it('throws exception when documentable does not belong to enterprise', function () {
            $user = \App\Models\User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $sector = createUniqueSector();
            $country = createUniqueCountry();

            $enterprise1 = Enterprise::create([
                'ifu' => 'IFU12345678901234',
                'name' => 'Test Enterprise 1',
                'active' => true,
                'code' => 'TEST001',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address',
                'zip_code' => '12345',
                'email' => 'test@enterprise1.com',
                'phone' => '1234567890',
                'website' => 'https://test1.com',
                'country_code' => $country->code,
            ]);

            $enterprise2 = Enterprise::create([
                'ifu' => 'IFU98765432109876',
                'name' => 'Test Enterprise 2',
                'active' => true,
                'code' => 'TEST002',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address 2',
                'zip_code' => '54321',
                'email' => 'test@enterprise2.com',
                'phone' => '0987654321',
                'website' => 'https://test2.com',
                'country_code' => $country->code,
            ]);

            $location = \App\Models\Location::create([
                'enterprise_id' => $enterprise1->id,
                'name' => 'Test Location',
                'address' => 'Test Address',
                'city' => 'Test City',
                'state' => 'Test State',
                'zip_code' => '12345',
                'country' => 'Test Country',
                'phone' => '1234567890',
                'email' => 'test@location.com',
                'active' => true,
            ]);

            $member = Member::create([
                'enterprise_id' => $enterprise1->id,
                'user_id' => $user->id,
                'location_id' => $location->id,
                'status_by' => $user->id,
                'type' => 'employee',
                'status' => 'active',
                'username' => 'testuser',
                'code' => 'MEM001',
                'birth_date' => '1990-01-01',
                'marital_status' => 'single',
                'nationality' => 'US',
                'role' => 'Developer',
                'joining_date' => '2023-01-01',
            ]);

            $data = [
                'key' => 'test-document',
                'name' => 'Test Document',
            ];

            expect(fn() => $this->service->save($data, $member, $enterprise2))
                ->toThrow(ModelNotFoundException::class, 'Documentable not found in this enterprise.');
        });

        it('uses default values when not provided', function () {
            $user = \App\Models\User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $sector = createUniqueSector();
            $country = createUniqueCountry();

            $enterprise = Enterprise::create([
                'ifu' => 'IFU12345678901234',
                'name' => 'Test Enterprise',
                'active' => true,
                'code' => 'TEST001',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address',
                'zip_code' => '12345',
                'email' => 'test@enterprise.com',
                'phone' => '1234567890',
                'website' => 'https://test.com',
                'country_code' => $country->code,
            ]);

            $location = \App\Models\Location::create([
                'enterprise_id' => $enterprise->id,
                'name' => 'Test Location',
                'address' => 'Test Address',
                'city' => 'Test City',
                'state' => 'Test State',
                'zip_code' => '12345',
                'country' => 'Test Country',
                'phone' => '1234567890',
                'email' => 'test@location.com',
                'active' => true,
            ]);

            $member = Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user->id,
                'location_id' => $location->id,
                'status_by' => $user->id,
                'type' => 'employee',
                'status' => 'active',
                'username' => 'testuser',
                'code' => 'MEM001',
                'birth_date' => '1990-01-01',
                'marital_status' => 'single',
                'nationality' => 'US',
                'role' => 'Developer',
                'joining_date' => '2023-01-01',
            ]);

            $data = [
                'key' => 'test-document',
                'name' => 'Test Document',
            ];

            $document = $this->service->save($data, $member, $enterprise);

            expect($document->active)->toBe(true);
            expect($document->scope)->toBe('private');
        });
    });

    describe('update', function () {
        it('updates an existing document successfully', function () {
            $user = \App\Models\User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $sector = createUniqueSector();
            $country = createUniqueCountry();

            $enterprise = Enterprise::create([
                'ifu' => 'IFU12345678901234',
                'name' => 'Test Enterprise',
                'active' => true,
                'code' => 'TEST001',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address',
                'zip_code' => '12345',
                'email' => 'test@enterprise.com',
                'phone' => '1234567890',
                'website' => 'https://test.com',
                'country_code' => $country->code,
            ]);

            $location = \App\Models\Location::create([
                'enterprise_id' => $enterprise->id,
                'name' => 'Test Location',
                'address' => 'Test Address',
                'city' => 'Test City',
                'state' => 'Test State',
                'zip_code' => '12345',
                'country' => 'Test Country',
                'phone' => '1234567890',
                'email' => 'test@location.com',
                'active' => true,
            ]);

            $member = Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user->id,
                'location_id' => $location->id,
                'status_by' => $user->id,
                'type' => 'employee',
                'status' => 'active',
                'username' => 'testuser',
                'code' => 'MEM001',
                'birth_date' => '1990-01-01',
                'marital_status' => 'single',
                'nationality' => 'US',
                'role' => 'Developer',
                'joining_date' => '2023-01-01',
            ]);

            $document = Document::create([
                'documentable_id' => $member->id,
                'documentable_type' => Member::class,
                'key' => 'old-key',
                'name' => 'Old Name',
                'path' => 'old/path.pdf',
                'active' => true,
                'scope' => 'private',
            ]);

            $data = [
                'key' => 'new-key',
                'name' => 'New Name',
                'active' => false,
                'scope' => 'public',
            ];

            $updatedDocument = $this->service->update($data, $document->id, $enterprise);

            expect($updatedDocument->key)->toBe('new-key');
            expect($updatedDocument->name)->toBe('New Name');
            expect($updatedDocument->active)->toBe(false);
            expect($updatedDocument->scope)->toBe('public');
            expect($updatedDocument->path)->toBe('/storage//old/path.pdf');
        });

        it('updates document with new file upload', function () {
            $user = \App\Models\User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $sector = createUniqueSector();
            $country = createUniqueCountry();

            $enterprise = Enterprise::create([
                'ifu' => 'IFU12345678901234',
                'name' => 'Test Enterprise',
                'active' => true,
                'code' => 'TEST001',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address',
                'zip_code' => '12345',
                'email' => 'test@enterprise.com',
                'phone' => '1234567890',
                'website' => 'https://test.com',
                'country_code' => $country->code,
            ]);

            $location = \App\Models\Location::create([
                'enterprise_id' => $enterprise->id,
                'name' => 'Test Location',
                'address' => 'Test Address',
                'city' => 'Test City',
                'state' => 'Test State',
                'zip_code' => '12345',
                'country' => 'Test Country',
                'phone' => '1234567890',
                'email' => 'test@location.com',
                'active' => true,
            ]);

            $member = Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user->id,
                'location_id' => $location->id,
                'status_by' => $user->id,
                'type' => 'employee',
                'status' => 'active',
                'username' => 'testuser',
                'code' => 'MEM001',
                'birth_date' => '1990-01-01',
                'marital_status' => 'single',
                'nationality' => 'US',
                'role' => 'Developer',
                'joining_date' => '2023-01-01',
            ]);

            $document = Document::create([
                'documentable_id' => $member->id,
                'documentable_type' => Member::class,
                'key' => 'test-key',
                'name' => 'Test Document',
                'path' => 'old/path.pdf',
                'active' => true,
                'scope' => 'private',
            ]);

            $file = UploadedFile::fake()->create('new-document.pdf', 100);

            $data = [
                'name' => 'Updated Document',
            ];

            $updatedDocument = $this->service->update($data, $document->id, $enterprise, $file);

            expect($updatedDocument->name)->toBe('Updated Document');
            expect($updatedDocument->path)->not->toBe('/storage//old/path.pdf');
            expect($updatedDocument->path)->toContain('documents/' . $enterprise->id . '/Member/' . $member->id);
        });

        it('throws exception when document does not belong to enterprise', function () {
            $user = \App\Models\User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $sector = createUniqueSector();
            $country = createUniqueCountry();

            $enterprise1 = Enterprise::create([
                'ifu' => 'IFU12345678901234',
                'name' => 'Test Enterprise 1',
                'active' => true,
                'code' => 'TEST001',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address',
                'zip_code' => '12345',
                'email' => 'test@enterprise1.com',
                'phone' => '1234567890',
                'website' => 'https://test1.com',
                'country_code' => $country->code,
            ]);

            $enterprise2 = Enterprise::create([
                'ifu' => 'IFU98765432109876',
                'name' => 'Test Enterprise 2',
                'active' => true,
                'code' => 'TEST002',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address 2',
                'zip_code' => '54321',
                'email' => 'test@enterprise2.com',
                'phone' => '0987654321',
                'website' => 'https://test2.com',
                'country_code' => $country->code,
            ]);

            $location = \App\Models\Location::create([
                'enterprise_id' => $enterprise1->id,
                'name' => 'Test Location',
                'address' => 'Test Address',
                'city' => 'Test City',
                'state' => 'Test State',
                'zip_code' => '12345',
                'country' => 'Test Country',
                'phone' => '1234567890',
                'email' => 'test@location.com',
                'active' => true,
            ]);

            $member = Member::create([
                'enterprise_id' => $enterprise1->id,
                'user_id' => $user->id,
                'location_id' => $location->id,
                'status_by' => $user->id,
                'type' => 'employee',
                'status' => 'active',
                'username' => 'testuser',
                'code' => 'MEM001',
                'birth_date' => '1990-01-01',
                'marital_status' => 'single',
                'nationality' => 'US',
                'role' => 'Developer',
                'joining_date' => '2023-01-01',
            ]);

            $document = Document::create([
                'documentable_id' => $member->id,
                'documentable_type' => Member::class,
                'key' => 'test-key',
                'name' => 'Test Document',
                'path' => 'path.pdf',
                'active' => true,
                'scope' => 'private',
            ]);

            $data = [
                'name' => 'Updated Document',
            ];

            expect(fn() => $this->service->update($data, $document->id, $enterprise2))
                ->toThrow(ModelNotFoundException::class, 'Document not found in this enterprise.');
        });
    });

    describe('delete', function () {
        it('deletes a document successfully', function () {
            $user = \App\Models\User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $sector = createUniqueSector();
            $country = createUniqueCountry();

            $enterprise = Enterprise::create([
                'ifu' => 'IFU12345678901234',
                'name' => 'Test Enterprise',
                'active' => true,
                'code' => 'TEST001',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address',
                'zip_code' => '12345',
                'email' => 'test@enterprise.com',
                'phone' => '1234567890',
                'website' => 'https://test.com',
                'country_code' => $country->code,
            ]);

            $location = \App\Models\Location::create([
                'enterprise_id' => $enterprise->id,
                'name' => 'Test Location',
                'address' => 'Test Address',
                'city' => 'Test City',
                'state' => 'Test State',
                'zip_code' => '12345',
                'country' => 'Test Country',
                'phone' => '1234567890',
                'email' => 'test@location.com',
                'active' => true,
            ]);

            $member = Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user->id,
                'location_id' => $location->id,
                'status_by' => $user->id,
                'type' => 'employee',
                'status' => 'active',
                'username' => 'testuser',
                'code' => 'MEM001',
                'birth_date' => '1990-01-01',
                'marital_status' => 'single',
                'nationality' => 'US',
                'role' => 'Developer',
                'joining_date' => '2023-01-01',
            ]);

            $document = Document::create([
                'documentable_id' => $member->id,
                'documentable_type' => Member::class,
                'key' => 'test-key',
                'name' => 'Test Document',
                'path' => 'path.pdf',
                'active' => true,
                'scope' => 'private',
            ]);

            $result = $this->service->delete($document->id, $enterprise);

            expect($result)->toBe(true);
            expect(Document::find($document->id))->toBeNull();
        });

        it('throws exception when document does not belong to enterprise', function () {
            $user = \App\Models\User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $sector = createUniqueSector();
            $country = createUniqueCountry();

            $enterprise1 = Enterprise::create([
                'ifu' => 'IFU12345678901234',
                'name' => 'Test Enterprise 1',
                'active' => true,
                'code' => 'TEST001',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address',
                'zip_code' => '12345',
                'email' => 'test@enterprise1.com',
                'phone' => '1234567890',
                'website' => 'https://test1.com',
                'country_code' => $country->code,
            ]);

            $enterprise2 = Enterprise::create([
                'ifu' => 'IFU98765432109876',
                'name' => 'Test Enterprise 2',
                'active' => true,
                'code' => 'TEST002',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address 2',
                'zip_code' => '54321',
                'email' => 'test@enterprise2.com',
                'phone' => '0987654321',
                'website' => 'https://test2.com',
                'country_code' => $country->code,
            ]);

            $location = \App\Models\Location::create([
                'enterprise_id' => $enterprise1->id,
                'name' => 'Test Location',
                'address' => 'Test Address',
                'city' => 'Test City',
                'state' => 'Test State',
                'zip_code' => '12345',
                'country' => 'Test Country',
                'phone' => '1234567890',
                'email' => 'test@location.com',
                'active' => true,
            ]);

            $member = Member::create([
                'enterprise_id' => $enterprise1->id,
                'user_id' => $user->id,
                'location_id' => $location->id,
                'status_by' => $user->id,
                'type' => 'employee',
                'status' => 'active',
                'username' => 'testuser',
                'code' => 'MEM001',
                'birth_date' => '1990-01-01',
                'marital_status' => 'single',
                'nationality' => 'US',
                'role' => 'Developer',
                'joining_date' => '2023-01-01',
            ]);

            $document = Document::create([
                'documentable_id' => $member->id,
                'documentable_type' => Member::class,
                'key' => 'test-key',
                'name' => 'Test Document',
                'path' => 'path.pdf',
                'active' => true,
                'scope' => 'private',
            ]);

            expect(fn() => $this->service->delete($document->id, $enterprise2))
                ->toThrow(ModelNotFoundException::class, 'Document not found in this enterprise.');
        });
    });

    describe('getDocumentsForEnterprise', function () {
        it('returns paginated documents for enterprise', function () {
            $user = \App\Models\User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $sector = createUniqueSector();
            $country = createUniqueCountry();

            $enterprise = Enterprise::create([
                'ifu' => 'IFU12345678901234',
                'name' => 'Test Enterprise',
                'active' => true,
                'code' => 'TEST001',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address',
                'zip_code' => '12345',
                'email' => 'test@enterprise.com',
                'phone' => '1234567890',
                'website' => 'https://test.com',
                'country_code' => $country->code,
            ]);

            $location = \App\Models\Location::create([
                'enterprise_id' => $enterprise->id,
                'name' => 'Test Location',
                'address' => 'Test Address',
                'city' => 'Test City',
                'state' => 'Test State',
                'zip_code' => '12345',
                'country' => 'Test Country',
                'phone' => '1234567890',
                'email' => 'test@location.com',
                'active' => true,
            ]);

            $member = Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user->id,
                'location_id' => $location->id,
                'status_by' => $user->id,
                'type' => 'employee',
                'status' => 'active',
                'username' => 'testuser',
                'code' => 'MEM001',
                'birth_date' => '1990-01-01',
                'marital_status' => 'single',
                'nationality' => 'US',
                'role' => 'Developer',
                'joining_date' => '2023-01-01',
            ]);

            Document::create([
                'documentable_id' => $member->id,
                'documentable_type' => Member::class,
                'key' => 'document-1',
                'name' => 'Document 1',
                'path' => '/path1.pdf',
                'active' => true,
                'scope' => 'private',
                'created_at' => now()->subMinute(),
            ]);

            Document::create([
                'documentable_id' => $member->id,
                'documentable_type' => Member::class,
                'key' => 'document-2',
                'name' => 'Document 2',
                'path' => '/path2.pdf',
                'active' => true,
                'scope' => 'public',
                'created_at' => now(),
            ]);

            $result = $this->service->getDocumentsForEnterprise($enterprise);

            expect($result)->toHaveCount(2);
            expect($result->first()->name)->toBe('Document 2'); // Most recent first
            expect($result->last()->name)->toBe('Document 1'); // Oldest last
        });

        it('filters documents by search term', function () {
            $user = \App\Models\User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $sector = createUniqueSector();
            $country = createUniqueCountry();

            $enterprise = Enterprise::create([
                'ifu' => 'IFU12345678901234',
                'name' => 'Test Enterprise',
                'active' => true,
                'code' => 'TEST001',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address',
                'zip_code' => '12345',
                'email' => 'test@enterprise.com',
                'phone' => '1234567890',
                'website' => 'https://test.com',
                'country_code' => $country->code,
            ]);

            $location = \App\Models\Location::create([
                'enterprise_id' => $enterprise->id,
                'name' => 'Test Location',
                'address' => 'Test Address',
                'city' => 'Test City',
                'state' => 'Test State',
                'zip_code' => '12345',
                'country' => 'Test Country',
                'phone' => '1234567890',
                'email' => 'test@location.com',
                'active' => true,
            ]);

            $member = Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user->id,
                'location_id' => $location->id,
                'status_by' => $user->id,
                'type' => 'employee',
                'status' => 'active',
                'username' => 'testuser',
                'code' => 'MEM001',
                'birth_date' => '1990-01-01',
                'marital_status' => 'single',
                'nationality' => 'US',
                'role' => 'Developer',
                'joining_date' => '2023-01-01',
            ]);

            Document::create([
                'documentable_id' => $member->id,
                'documentable_type' => Member::class,
                'key' => 'contract',
                'name' => 'Employment Contract',
                'path' => '/contract.pdf',
                'active' => true,
                'scope' => 'private',
            ]);

            Document::create([
                'documentable_id' => $member->id,
                'documentable_type' => Member::class,
                'key' => 'invoice',
                'name' => 'Invoice Document',
                'path' => '/invoice.pdf',
                'active' => true,
                'scope' => 'public',
            ]);

            $result = $this->service->getDocumentsForEnterprise($enterprise, ['search' => 'contract']);

            expect($result)->toHaveCount(1);
            expect($result->first()->name)->toBe('Employment Contract');
        });

        it('filters documents by member_id', function () {
            $user = \App\Models\User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $sector = createUniqueSector();
            $country = createUniqueCountry();

            $enterprise = Enterprise::create([
                'ifu' => 'IFU12345678901234',
                'name' => 'Test Enterprise',
                'active' => true,
                'code' => 'TEST001',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address',
                'zip_code' => '12345',
                'email' => 'test@enterprise.com',
                'phone' => '1234567890',
                'website' => 'https://test.com',
                'country_code' => $country->code,
            ]);

            $location = \App\Models\Location::create([
                'enterprise_id' => $enterprise->id,
                'name' => 'Test Location',
                'address' => 'Test Address',
                'city' => 'Test City',
                'state' => 'Test State',
                'zip_code' => '12345',
                'country' => 'Test Country',
                'phone' => '1234567890',
                'email' => 'test@location.com',
                'active' => true,
            ]);

            $user1 = \App\Models\User::create([
                'name' => 'Test User 1',
                'email' => 'test1@example.com',
                'password' => bcrypt('password'),
            ]);

            $user2 = \App\Models\User::create([
                'name' => 'Test User 2',
                'email' => 'test2@example.com',
                'password' => bcrypt('password'),
            ]);

            $member1 = Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user1->id,
                'location_id' => $location->id,
                'status_by' => $user->id,
                'type' => 'employee',
                'status' => 'active',
                'username' => 'testuser1',
                'code' => 'MEM001',
                'birth_date' => '1990-01-01',
                'marital_status' => 'single',
                'nationality' => 'US',
                'role' => 'Developer',
                'joining_date' => '2023-01-01',
            ]);

            $member2 = Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user2->id,
                'location_id' => $location->id,
                'status_by' => $user->id,
                'type' => 'employee',
                'status' => 'active',
                'username' => 'testuser2',
                'code' => 'MEM002',
                'birth_date' => '1990-01-01',
                'marital_status' => 'single',
                'nationality' => 'US',
                'role' => 'Developer',
                'joining_date' => '2023-01-01',
            ]);

            Document::create([
                'documentable_id' => $member1->id,
                'documentable_type' => Member::class,
                'key' => 'document-1',
                'name' => 'Document 1',
                'path' => '/path1.pdf',
                'active' => true,
                'scope' => 'private',
            ]);

            Document::create([
                'documentable_id' => $member2->id,
                'documentable_type' => Member::class,
                'key' => 'document-2',
                'name' => 'Document 2',
                'path' => '/path2.pdf',
                'active' => true,
                'scope' => 'public',
            ]);

            $result = $this->service->getDocumentsForEnterprise($enterprise, ['member_id' => $member1->id]);

            expect($result)->toHaveCount(1);
            expect($result->first()->name)->toBe('Document 1');
        });

        it('uses custom per_page parameter', function () {
            $user = \App\Models\User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $sector = createUniqueSector();
            $country = createUniqueCountry();

            $enterprise = Enterprise::create([
                'ifu' => 'IFU12345678901234',
                'name' => 'Test Enterprise',
                'active' => true,
                'code' => 'TEST001',
                'owner_id' => $user->id,
                'sector_id' => $sector->id,
                'status' => 'active',
                'status_by' => $user->id,
                'address' => 'Test Address',
                'zip_code' => '12345',
                'email' => 'test@enterprise.com',
                'phone' => '1234567890',
                'website' => 'https://test.com',
                'country_code' => $country->code,
            ]);

            $location = \App\Models\Location::create([
                'enterprise_id' => $enterprise->id,
                'name' => 'Test Location',
                'address' => 'Test Address',
                'city' => 'Test City',
                'state' => 'Test State',
                'zip_code' => '12345',
                'country' => 'Test Country',
                'phone' => '1234567890',
                'email' => 'test@location.com',
                'active' => true,
            ]);

            $member = Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user->id,
                'location_id' => $location->id,
                'status_by' => $user->id,
                'type' => 'employee',
                'status' => 'active',
                'username' => 'testuser',
                'code' => 'MEM001',
                'birth_date' => '1990-01-01',
                'marital_status' => 'single',
                'nationality' => 'US',
                'role' => 'Developer',
                'joining_date' => '2023-01-01',
            ]);

            Document::create([
                'documentable_id' => $member->id,
                'documentable_type' => Member::class,
                'key' => 'document-1',
                'name' => 'Document 1',
                'path' => '/path1.pdf',
                'active' => true,
                'scope' => 'private',
            ]);

            Document::create([
                'documentable_id' => $member->id,
                'documentable_type' => Member::class,
                'key' => 'document-2',
                'name' => 'Document 2',
                'path' => '/path2.pdf',
                'active' => true,
                'scope' => 'public',
            ]);

            $result = $this->service->getDocumentsForEnterprise($enterprise, ['per_page' => 1]);

            expect($result->perPage())->toBe(1);
            expect($result->count())->toBe(1);
        });
    });
});
