<?php

namespace Database\Seeders;

use App\Models\PaymentRecord;
use App\Models\PaymentAccount;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        PaymentRecord::query()->delete();
        $paymentMethods = [
            PaymentRecord::METHOD_CASH,
            PaymentRecord::METHOD_BANK_TRANSFER,
            PaymentRecord::METHOD_POS,
        ];
        $paymentTypes = [
            PaymentRecord::TYPE_RECEIVED,
        ];

        $contacts = Contact::all();

        foreach ($contacts as $contact) {
            if ($contact->orders->isNotEmpty()) {
                for ($i = 1; $i <= 2; $i++) {
                    $approvedOrders = $contact->orders->where('status', Order::STATUS_APPROVED);

                    if ($approvedOrders->count() > 0) {
                        $order = $approvedOrders->first();

                        PaymentRecord::create([
                            'contact_id' => $contact->id,
                            'order_id' => $order->id,
                            'account_id' => Account::inRandomOrder()->first()->id,
                            'payment_account_id' => PaymentAccount::inRandomOrder()->first()->id,
                            'payment_date' => fake()->dateTimeBetween('2024-01-01', '2024-03-01'),
                            'amount' => round(fake()->numberBetween(100000, $order->getTotal()), -3),
                            'method' => $paymentMethods[array_rand($paymentMethods)],
                            'description' => fake()->sentence,
                            'status' => PaymentRecord::STATUS_PAID,
                            'type' => $paymentTypes[array_rand($paymentTypes)],
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Get a unique payment account for the given contact.
     */
}
