<?php

use App\Models\Enterprise;
use App\Models\Experience;
use App\Models\Member;
use App\Services\ExperienceService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->service = new ExperienceService;
});



describe('ExperienceService', function () {
    describe('create', function () {
        it('creates a new experience successfully', function () {
            // Create required parent records first
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
                'member_id' => $member->id,
                'job_title' => 'Software Developer',
                'sector' => 'Technology',
                'company_name' => 'Tech Corp',
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'responsibilities' => 'Develop web applications',
            ];

            $experience = $this->service->create($data, $enterprise);

            expect($experience)->toBeInstanceOf(Experience::class);
            expect($experience->member_id)->toBe($member->id);
            expect($experience->job_title)->toBe('Software Developer');
            expect($experience->sector)->toBe('Technology');
            expect($experience->company_name)->toBe('Tech Corp');
            expect($experience->start_date->format('Y-m-d'))->toBe('2023-01-01');
            expect($experience->end_date->format('Y-m-d'))->toBe('2023-12-31');
            expect($experience->responsibilities)->toBe('Develop web applications');
        });

        it('throws ModelNotFoundException when member does not exist', function () {
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

            $data = [
                'member_id' => 999,
                'job_title' => 'Software Developer',
                'sector' => 'Technology',
                'company_name' => 'Tech Corp',
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'responsibilities' => 'Develop web applications',
            ];

            expect(fn() => $this->service->create($data, $enterprise))
                ->toThrow(ModelNotFoundException::class);
        });
    });

    describe('update', function () {
        it('updates an experience successfully', function () {
            // Create required parent records
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

            $experience = Experience::create([
                'member_id' => $member->id,
                'job_title' => 'Old Job Title',
                'sector' => 'Old Sector',
                'company_name' => 'Old Company',
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'responsibilities' => 'Old responsibilities',
            ]);

            $data = [
                'job_title' => 'New Job Title',
                'sector' => 'New Sector',
                'company_name' => 'New Company',
                'start_date' => '2023-02-01',
                'end_date' => '2023-11-30',
                'responsibilities' => 'New responsibilities',
            ];

            $updatedExperience = $this->service->update($data, $experience->id, $enterprise);

            expect($updatedExperience->job_title)->toBe('New Job Title');
            expect($updatedExperience->sector)->toBe('New Sector');
            expect($updatedExperience->company_name)->toBe('New Company');
            expect($updatedExperience->start_date->format('Y-m-d'))->toBe('2023-02-01');
            expect($updatedExperience->end_date->format('Y-m-d'))->toBe('2023-11-30');
            expect($updatedExperience->responsibilities)->toBe('New responsibilities');
        });

        it('throws ModelNotFoundException when experience does not exist', function () {
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

            $data = [
                'job_title' => 'New Job Title',
            ];

            expect(fn() => $this->service->update($data, 999, $enterprise))
                ->toThrow(ModelNotFoundException::class);
        });
    });

    describe('delete', function () {
        it('deletes an experience successfully', function () {
            // Create required parent records
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

            $experience = Experience::create([
                'member_id' => $member->id,
                'job_title' => 'Test Job',
                'sector' => 'Test Sector',
                'company_name' => 'Test Company',
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'responsibilities' => 'Test responsibilities',
            ]);

            $result = $this->service->delete($experience->id, $enterprise);

            expect($result)->toBeTrue();
            expect(Experience::find($experience->id))->toBeNull();
        });
    });

    describe('findById', function () {
        it('finds an experience by id successfully', function () {
            // Create required parent records
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

            $experience = Experience::create([
                'member_id' => $member->id,
                'job_title' => 'Test Job',
                'sector' => 'Test Sector',
                'company_name' => 'Test Company',
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'responsibilities' => 'Test responsibilities',
            ]);

            $foundExperience = $this->service->findById($experience->id, $enterprise);

            expect($foundExperience->id)->toBe($experience->id);
            expect($foundExperience->member_id)->toBe($member->id);
        });
    });
});