<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NoteLog;
use App\Models\Account;

class NoteLogSeeder extends Seeder
{
    public function run(): void
    {
        NoteLog::query()->delete();
        $contacts = Contact::inRandomOrder()->get();
        $content = config('contentNoteLog');
        foreach ($contacts as $contact) {
            for ($i = 1; $i <= 3; $i++) {
                NoteLog::create([
                    'content' => fake()->randomElement($content),
                    'contact_id' => $contact->id,
                    'account_id' => Account::inRandomOrder()->first()->id,
                    'status' => NoteLog::STATUS_ACTIVE,
                ]);
            }   
        }
    }
}