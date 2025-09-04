<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Member;
use App\Models\Plan;
use App\Models\Membership;
use App\Models\Invoice;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $owner = User::create([
            'name' => 'Owner',
            'email' => 'owner@example.com',
            'role' => 'owner',
            'password' => Hash::make('password'),
        ]);

        $staff = User::create([
            'name' => 'Staff Member',
            'email' => 'staff@example.com',
            'role' => 'staff',
            'password' => Hash::make('password'),
        ]);

        // Members
        $member1 = Member::create([
            'name' => 'Ahmed Ali',
            'email' => 'ahmed@example.com',
            'phone_number' => '01012345678',
            'gender' => 'male',
            'address' => 'Cairo, Egypt',
            'date_of_birth' => '1995-06-15',
            'status' => 'allowed'
        ]);

        $member2 = Member::create([
            'name' => 'Sara Mohamed',
            'email' => 'sara@example.com',
            'phone_number' => '01087654321',
            'gender' => 'female',
            'address' => 'Alexandria, Egypt',
            'date_of_birth' => '1998-02-20',
            'status' => 'allowed'
        ]);

        // Plans
        $plan1 = Plan::create([
            'name' => 'Monthly Open',
            'type' => 'open',
            'duration' => 30,
            'price' => 500.00
        ]);

        $plan2 = Plan::create([
            'name' => '10 Sessions',
            'type' => 'sessions',
            'sessions' => 10,
            'price' => 300.00
        ]);

        // Memberships
        $membership1 = Membership::create([
            'member_id' => $member1->id,
            'plan_id' => $plan1->id,
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(25),
            'remaining_sessions' => null,
            'status' => 'active'
        ]);

        $membership2 = Membership::create([
            'member_id' => $member2->id,
            'plan_id' => $plan2->id,
            'start_date' => now(),
            'end_date' => now()->addDays(60),
            'remaining_sessions' => 10,
            'status' => 'active'
        ]);

        // Invoices
        $invoice1 = Invoice::create([
            'number' => 'INV-1001',
            'total_amount' => 500.00,
            'status' => 'paid',
            'membership_id' => $membership1->id
        ]);

        $invoice2 = Invoice::create([
            'number' => 'INV-1002',
            'total_amount' => 300.00,
            'status' => 'unpaid',
            'membership_id' => $membership2->id
        ]);

        // Payments
        Payment::create([
            'invoice_id' => $invoice1->id,
            'amount' => 500.00,
            'method' => 'cash',
            'payment_date' => now()
        ]);
    }
}
