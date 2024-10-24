<?php

namespace App\Http\Controllers\Edu\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentSection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

class StudentSectionReportController extends Controller
{
    public function index()
    {
        return view('edu.reports.student_section_report.index');
    }
    public function list(Request $request)
    {
        $studentSections = StudentSection::byBranch(\App\Library\Branch::getCurrentBranch())->with('section');
       
        $updated_at_from = null;
        $updated_at_to = null;
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $studentSections = $studentSections->whereHas('section', function($query) use ($updated_at_from, $updated_at_to) {
                $query->whereBetween('study_date', [$updated_at_from, $updated_at_to]);
            });
        }

        $sortColumn = $request->sort_by ?? 'sections.study_date';
        $sortDirection = $request->sort_direction ?? 'asc';
        $studentSections = $studentSections->join('sections', 'student_section.section_id', '=', 'sections.id')
                         ->orderBy($sortColumn, $sortDirection)
                         ->select('student_section.*');
        // $studentSections = $studentSections->orderBy($sortColumn, $sortDirection);
        $studentSections = $studentSections->paginate($request->perpage ?? '20');

        return view('edu.reports.student_section_report.list',[
            'studentSections' => $studentSections,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
            'updated_at_from'=>$updated_at_from,
            'updated_at_to' => $updated_at_to,
        ]);
    }
    public function export(Request $request)
    {
        try {
            $studentSections = StudentSection::byBranch(\App\Library\Branch::getCurrentBranch())->with('section');

            if ($request->filled('updated_at_from') && $request->filled('updated_at_to')) {
                $updated_at_from = $request->input('updated_at_from');
                $updated_at_to = $request->input('updated_at_to');
                $studentSections = $studentSections->whereHas('section', function($query) use ($updated_at_from, $updated_at_to) {
                    $query->whereBetween('study_date', [$updated_at_from, $updated_at_to]);
                });
            }

            $sortColumn = $request->input('sort_by', 'sections.start_at');
            $sortDirection = $request->input('sort_direction', 'asc');
            $studentSections = $studentSections->join('sections', 'student_section.section_id', '=', 'sections.id')
                                ->orderBy($sortColumn, $sortDirection)
                                ->select('student_section.*');

            $studentSections = $studentSections->get();
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $headers = [
                'THỨ', 'NGÀY', 'MÃ LỚP CŨ', 'MÃ LỚP', 'PHÒNG HỌC', 'TRẠNG THÁI LỚP', 'LOẠI HÌNH', 'GIỜ HỌC', 'GIÁO VIÊN VN', 'SỐ GIỜ HỌC VỚI GVVN',
                'GVNN', 'SỐ GIỜ HỌC VỚ GVVN','GIA SƯ', 'SỐ GIỜ HỌC VỚI GIA SƯ', 'TRỢ GIẢNG', 'SỐ GIỜ HỌC VỚI TRỢ GIẢNG', 'MÃ HỌC VIÊN CŨ', 'MÃ HỌC VIÊN', 'TÊN HỌC VIÊN',
                'TÌNH TRẠNG', 'ĐỊA ĐIỂM', 'CHI NHÁNH', 'MÔN HỌC', 'TRÌNH ĐỘ', 'CHỦ NHIỆM', 'mhv + ten lop', 'HD+TEN', 'HỢP ĐỒNG', 'SALE'
            ];
            $column = 'A';

            foreach ($headers as $header) {
                $sheet->setCellValue($column . '1', $header);
                $sheet->getColumnDimension($column)->setAutoSize(true);
                $column++;
            }

            $row = 2;
            foreach ($studentSections as $studentSection) {
                $sheet->setCellValue('A' . $row, \Carbon\Carbon::parse($studentSection->section->study_date)->dayOfWeekIso + 1);
                $sheet->setCellValue('B' . $row, date('d/m/Y', strtotime($studentSection->section->study_date)));
                $sheet->setCellValue('C' . $row, $studentSection->section->course->import_id);
                $sheet->setCellValue('D' . $row, $studentSection->section->course->code);
                $sheet->setCellValue('E' . $row, $studentSection->section->course->class_room);
                $sheet->setCellValue('F' . $row, $studentSection->section->status === \App\Models\Section::STATUS_DESTROY ? 'Đã hủy' : $studentSection->section->checkStatusSectionCalendar()) ;
                $sheet->setCellValue('G' . $row, $studentSection->section->course->study_method);
                $sheet->setCellValue('H' . $row, date('H:i', strtotime($studentSection->section->start_at)) . ' - ' . date('H:i', strtotime($studentSection->section->end_at)));
                $sheet->setCellValue('I' . $row, isset($studentSection->section->vnTeacher) ? $studentSection->section->vnTeacher->name : '--');
                $sheet->setCellValue('J' . $row, $studentSection->section->calculateInMinutesVnTeacherInSection() != 0 ? number_format($studentSection->section->calculateInMinutesVnTeacherInSection() / 60, 2) : $studentSection->section->calculateInMinutesVnTeacherInSection());
                $sheet->setCellValue('K' . $row, isset($studentSection->section->foreignTeacher) ? $studentSection->section->foreignTeacher->name : '--');
                $sheet->setCellValue('L' . $row, $studentSection->section->calculateInMinutesForeignTeacherInSection() != 0 ? number_format($studentSection->section->calculateInMinutesForeignTeacherInSection() / 60, 2) : $studentSection->section->calculateInMinutesForeignTeacherInSection());
                $sheet->setCellValue('M' . $row, isset($studentSection->section->tutor) ? $studentSection->section->tutor->name : '--');
                $sheet->setCellValue('N' . $row, $studentSection->section->calculateInMinutesTutorInSection() != 0 ? number_format($studentSection->section->calculateInMinutesTutorInSection() / 60, 2) : $studentSection->section->calculateInMinutesTutorInSection());
                $sheet->setCellValue('O' . $row, isset($studentSection->assistant) ? $studentSection->assistant->name : '--');
                $sheet->setCellValue('P' . $row, $studentSection->section->calculateInMinutesAssistantInSection() != 0 ? number_format($studentSection->section->calculateInMinutesAssistantInSection() / 60, 2) : $studentSection->section->calculateInMinutesAssistantInSection());
                $sheet->setCellValue('Q' . $row, $studentSection->student->import_id);
                $sheet->setCellValue('R' . $row, $studentSection->student->code);
                $sheet->setCellValue('S' . $row, $studentSection->student->name);
                $sheet->setCellValue('T' . $row, trans('messages.student_section.' . $studentSection->status));
                $sheet->setCellValue('U' . $row, $studentSection->section->course->trainingLocation->name);
                $sheet->setCellValue('V' . $row, isset($studentSection->section->course->trainingLocation) ? trans('messages.training_locations.' . $studentSection->section->course->trainingLocation->branch) : '--');
                $sheet->setCellValue('W' . $row, $studentSection->section->course->subject->name);
                $sheet->setCellValue('X' . $row, $studentSection->section->course->level);
                $sheet->setCellValue('Y' . $row, $studentSection->section->course->teacher->name);
                $sheet->setCellValue('Z' . $row, $studentSection->student->code . ' ' . $studentSection->section->course->code);
                $sheet->setCellValue('AA' . $row, $studentSection->courseStudent->orderItems->order->code . ' ' . $studentSection->courseStudent->orderItems->order->contacts->name);
                $sheet->setCellValue('AB' . $row, $studentSection->courseStudent->orderItems->order->code);
                $sheet->setCellValue('AC' . $row,  isset($studentSection->courseStudent->orderItems->order->salesperson) ? $studentSection->courseStudent->orderItems->order->salesperson->name : '--'); 
                $row++;
            }
            

            $fileName = 'student_sections.xlsx';
            $tempFile = tempnam(sys_get_temp_dir(), $fileName);
            $writer = new Xlsx($spreadsheet);
            $writer->save($tempFile);
            
            return Response::download($tempFile, $fileName)->deleteFileAfterSend(true);
        }
        catch (\Exception $e) {
           
            return response()->json(['error' => 'failed: ' . $e->getMessage()], 500);
        }
    }
        
}
