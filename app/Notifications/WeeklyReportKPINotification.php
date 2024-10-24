<?php

namespace App\Notifications;

use App\Library\Permission;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class WeeklyReportKPINotification extends Notification
{
    use Queueable;
    public $startOfWeek;
    public $endOfWeek;
    /**
     * Create a new notification instance.
     */
    public function __construct($startOfWeek, $endOfWeek)
    {
        $this->startOfWeek = $startOfWeek;
        $this->endOfWeek = $endOfWeek;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        try {
            $spreadsheet = new Spreadsheet();
    
            $sheet = $spreadsheet->getActiveSheet();
    
            // Set the header 
            $sheet->setCellValue('A1', 'Tên');
            $sheet->setCellValue('B1', 'KPI');
            $sheet->setCellValue('C1', 'Doanh Thu');
            $sheet->setCellValue('D1', 'Tỉ Lệ');
    
            // Apply styles 
            $sheet->getStyle('A1:D1')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            
            $users = User::withPermission(Permission::SALES_CUSTOMER)->get();
            // Add user data 
            foreach ($users as $index => $user) {
                $rowNumber = $index + 2; 
                $sheet->setCellValue('A' . $rowNumber, $user->name);
                $sheet->setCellValue('B' . $rowNumber, $user->account->getKpiMonth());
                $sheet->getStyle('B' . $rowNumber)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                
                $sheet->setCellValue('C' . $rowNumber, $user->account->getRevenueForAccountByPreviousWeek());
                $sheet->getStyle('C' . $rowNumber)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);; 
                $sheet->setCellValue('D' . $rowNumber, $user->account->getPercentKpiRevenueInPreviousWeek() . '%'); 
            }
    
            foreach (range('A', 'D') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
    
            $fixedWidth = 20; 
            
            foreach (range('A', 'D') as $columnID) {
                $sheet->getColumnDimension($columnID)->setWidth($fixedWidth);
            }
    
            $writer = new Xlsx($spreadsheet);
            ob_start();
            $writer->save('php://output');
            $excelContent = ob_get_clean();
     
            return (new MailMessage) 
                    ->subject('ASMS - Thông báo báo cáo doanh thu từ ' . \Carbon\Carbon::parse($this->startOfWeek)->format('d/m/Y') . ' đến ' . \Carbon\Carbon::parse($this->endOfWeek)->format('d/m/Y'))
                    ->attachData($excelContent, 'weekly_report.xlsx', [
                        'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ])
                    ->view('emails.WeeklyReportKPI', [
                        'startOfWeek' => $this->startOfWeek,
                        'endOfWeek' => $this->endOfWeek, 
                    ]);
        } catch (\Exception $e) {
            Log::error('Email sending failed Error: ' . $e->getMessage()); 
            return new MailMessage();
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
