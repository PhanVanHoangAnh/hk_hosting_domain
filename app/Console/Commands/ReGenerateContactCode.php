<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReGenerateContactCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:re-generate-contact-code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // \App\Models\Contact::where('code', 'HS240610000')->update(['code' => null,]);
        // $contacts = \App\Models\Contact::whereNull('code')
        //     ->where('created_at', '<', \Carbon\Carbon::parse('2024-06-01'))
        //     ->get();

        // foreach ($contacts as $contact) {
        //     $contact->generateCode();
        //     echo "{$contact->code} - {$contact->name} - {$contact->phone} \n";
        // }

        // \App\Models\Contact::where('code', 'HS240610000')->update(['code' => null,]);
        // foreach(\App\Models\Contact::where('code', 'LIKE', 'HS2406%')->get() as $contact) {
        //     if($contact->created_at < \Carbon\Carbon::parse('2024-06-01')) {
        //         echo $contact->created_at->format('Y-m') . "\n";
        //     }
        // }

        // $contacts = \App\Models\Contact::all();

        // foreach($contacts as $contact) {
        //     $currentYear = $contact->created_at->format('Y'); // Lấy 2 chữ số cuối của năm
        //     $currentMonth = $contact->created_at->format('m'); // Lấy 2 chữ số của tháng

        //     if ($contact->code) {

        //     } else {
        //         $maxCode = self::where('code_year', $currentYear)
        //             ->where('code_month', $currentMonth)
        //             ->max('code_number');

        //         $codeNumber = $maxCode ? ($maxCode + 1) : 1;

        //         $contact->code_year = $currentYear;
        //         $contact->code_month = $currentMonth;
        //         $contact->code_number = $codeNumber;

        //         $contact->save();
        //     }
                
        // }


        // fix current code
        $contacts = \App\Models\Contact::whereNotNull('code')
            ->whereNull('code_number')->get();

        foreach($contacts as $contact) {
            $codeYear = (int) "20" . substr($contact->code, 2, 2);
            $codeMonth = (int) substr($contact->code, 4, 2);
            $codeNumber = (int) substr($contact->code, 6, 4);

            $contact->code_year = $codeYear;
            $contact->code_month = $codeMonth;
            $contact->code_number = $codeNumber;
            
            $contact->save();

            echo "{$contact->code} - " . ($contact->code == $contact->getCode()) . "\n";
        }

        // generate code
        \App\Models\Contact::whereNull('created_at')->update(['created_at' => \Carbon\Carbon::parse('2024-04-01')]);
        $contacts = \App\Models\Contact::whereNull('code')
            ->orderBy('created_at', 'asc')
            // ->where('created_at', '>=', \Carbon\Carbon::parse('2024-06-01'))
            ->get();
            
        foreach($contacts as $contact) {
            $contact->generateCode();
        }
    }
}
