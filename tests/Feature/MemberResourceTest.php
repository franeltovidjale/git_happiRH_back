<?php

use App\Http\Resources\MemberResource;
use App\Models\Member;

describe('MemberResource Tests', function () {
    it('transforms member data correctly', function () {
        $member = new Member();
        $member->id = 1;
        $member->user_id = 10;
        $member->type = 'employee';
        $member->status = 'active';
        $member->username = 'john_doe';
        $member->code = 'EMP001';
        $member->designation = 'Developer';
        $member->joining_date = '2023-01-15';

        $resource = new MemberResource($member);
        $data = $resource->toArray(request());

        expect($data)->toHaveKey('id');
        expect($data)->toHaveKey('user_id');
        expect($data)->toHaveKey('type');
        expect($data)->toHaveKey('status');
        expect($data)->toHaveKey('username');
        expect($data)->toHaveKey('code');
        expect($data)->toHaveKey('designation');
        expect($data)->toHaveKey('joining_date');

        expect($data['id'])->toBe(1);
        expect($data['user_id'])->toBe(10);
        expect($data['type'])->toBe('employee');
        expect($data['status'])->toBe('active');
        expect($data['username'])->toBe('john_doe');
        expect($data['code'])->toBe('EMP001');
        expect($data['designation'])->toBe('Developer');
    });

    it('includes user data when user relation is loaded', function () {
        $member = new Member();
        $member->id = 1;
        $member->user_id = 10;
        $member->type = 'employee';
        $member->status = 'active';
        $member->username = 'john_doe';
        $member->code = 'EMP001';
        $member->designation = 'Developer';

        // Mock user relation
        $member->setRelation('user', (object) [
            'id' => 10,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890'
        ]);

        $resource = new MemberResource($member);
        $data = $resource->toArray(request());

        expect($data)->toHaveKey('user');
        expect($data['user'])->toHaveKey('id');
        expect($data['user'])->toHaveKey('first_name');
        expect($data['user'])->toHaveKey('last_name');
        expect($data['user'])->toHaveKey('email');
        expect($data['user'])->toHaveKey('phone');

        expect($data['user']['id'])->toBe(10);
        expect($data['user']['first_name'])->toBe('John');
        expect($data['user']['last_name'])->toBe('Doe');
        expect($data['user']['email'])->toBe('john@example.com');
        expect($data['user']['phone'])->toBe('1234567890');
    });

    it('has correct resource structure', function () {
        $member = new Member();
        $member->id = 1;
        $member->user_id = 10;
        $member->type = 'employee';
        $member->status = 'active';
        $member->username = 'john_doe';
        $member->code = 'EMP001';
        $member->designation = 'Developer';

        $resource = new MemberResource($member);

        expect($resource)->toBeInstanceOf(\Illuminate\Http\Resources\Json\JsonResource::class);
        expect(method_exists($resource, 'toArray'))->toBeTrue();
    });
});
