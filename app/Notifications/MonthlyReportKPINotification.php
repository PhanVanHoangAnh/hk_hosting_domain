<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Library\Permission;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class MonthlyReportKPINotification extends Notification
{
    use Queueable;

    public $month;
    public $year;
    /**
     * Create a new notification instance.
     */
    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
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
    
            // Apply styles to the header 
            $sheet->getStyle('A1:D1')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            
            $users = User::withPermission(Permission::SALES_CUSTOMER)->get();
            // Add user data 
            foreach ($users as $index => $user) {
                $rowNumber = $index + 2; // Data starts 
                $sheet->setCellValue('A' . $rowNumber, $user->name);
                $sheet->setCellValue('B' . $rowNumber, $user->account->getKpiMonth());
                $sheet->getStyle('B' . $rowNumber)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                
                $sheet->setCellValue('C' . $rowNumber, $user->account->getRevenueForAccountInPreviousMonth());
                $sheet->getStyle('C' . $rowNumber)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);; 
                $sheet->setCellValue('D' . $rowNumber, $user->account->getPercentKpiRevenuePreviousMonth() . '%'); 
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
                    ->subject('ASMS - Thông báo báo cáo doanh thu tháng ' . $this->month . '/' . $this->year)
                    ->attachData($excelContent, 'monthly_report.xlsx', [
                        'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ])
                    ->view('emails.MonthlyReportKPI', [
                        'month' => $this->month,
                        'year' => $this->year, 
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
