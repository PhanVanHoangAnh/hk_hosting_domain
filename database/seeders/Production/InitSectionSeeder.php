<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Account;
use App\Models\AccountGroup;
use App\Models\Contact;
use App\Models\Section;
use App\Models\Role;
use App\Models\ExcelData;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\ContactRequest;
use App\Models\CourseStudent;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\StudentSection;
use App\Models\Teacher;

class InitSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // AccountGroup::query()->delete();

        $excelFile = new ExcelData();
        $sectionData = $excelFile->getDataFromSheet(ExcelData::STAFF_SHEET_SECTION, 3);
        $this->getCourseStudent($sectionData);
        // $this->getSection($sectionData);
        // $this->getStudentSection($sectionData);
       

        
    }

    public function getStudentSection($sectionData){
        $uniqueStudentSectionData = [];
        foreach ($sectionData as $data) {
            [$import_id,$order_item_import_id, $course_id, $contact_import_id, $contact_name, $study_date, $trang_thai, $start_at, $end_at, $vn_teacher_name, $foreign_teacher_name, $tutor_name, $assistant_name, $status] = $data;
        

            // Tạo khóa duy nhất dựa trên id, course_id, và contact_id

            // $key = $id . '-' . $course_id . '-' . $contact_id;
            $key = $import_id . '-' . $contact_import_id;
            // Kiểm tra xem dòng dữ liệu đã tồn tại trong mảng kết hợp chưa

            if (!isset($uniqueStudentSectionData[$key])&& $key != '-') {
                $section = Section::where('import_id',$import_id)->first();
                if(!is_null($section)){
                    $order = Order::where('import_id',$order_item_import_id)->first();
                    if(!is_null($order)){
                        $studentSection = StudentSection::where('student_id',$order->student->id)->where('section_id',$section->id)->first();
                        if(!is_null($studentSection)){
                            echo("  \033[31mERROR\033[0m  : Đã tồn tại StudentSection: import_id" . $import_id . "\n");
                        }else{
                            $contact = Contact::where('import_id',$contact_import_id )->first();
                            if (is_null($contact) || is_null($contact_import_id)){
                                echo("  \033[31mERROR\033[0m  : Không tồn tại contact: contact_id" . $contact_import_id . "\n");
                                // return ;
                            }else{
                                // echo("\n". $order_item_import_id . "\n");
                                $section  = Section::where('import_id',$import_id )->first();
                            
                                if (is_null($section) || is_null($import_id)){
                                    echo("  \033[31mERROR\033[0m  : Không tồn tại Section:  = " . $import_id . "\n");
                                    // return ;
                                }else{
                                    
                                
                                    $contact_id = $contact->id;
                                    $section_id = $section->id;
                                    $uniqueStudentSectionData[$key] = [
                                        'section_id' => $section_id,
                                        'student_id' => $contact_id,
                                    
                                    ];
                                }
                                
                            }
                        }
                    }
                }
                
            }
        }
        
        foreach ($uniqueStudentSectionData as $data) {
            $this->addStudentSection($data);
        }
    }

    public function addStudentSection($data)
    {
        $studentSection = new StudentSection();
        $studentSection->importFromExcelSeeder($data);
    }

    public function getCourseStudent($sectionData)
    {
       $courseStudentData = [];
       
        foreach ($sectionData as $data) {
            [$id,$order_item_import_id, $course_import_id, $contact_import_id, $contact_name, $study_date, $trang_thai, $start_at, $end_at, $vn_teacher_name, $foreign_teacher_name, $tutor_name, $assistant_name, $status] = $data;
       
            // Tạo khóa duy nhất dựa trên id, course_id, và contact_id
           
            // $key = $id . '-' . $course_id . '-' . $contact_id;
            $key = $course_import_id . '-' . $contact_import_id ;

            
                // Kiểm tra xem dòng dữ liệu đã tồn tại trong mảng kết hợp chưa
                if (!array_key_exists($key, $courseStudentData) && $key != '-') {
                   
                    $courseStudent = CourseStudent::where('import_id',$id)->first();
                   
                    if(!is_null($courseStudent) && !is_null($id)) {
                        echo("  \033[31mERROR\033[0m  : Đã tồn tại CourseStudent: import_id" . $id . "\n");
                        
                    }else{
                        $course = Course::where('import_id',$course_import_id )->first();
                        if(is_null($course)){
                         
                            echo("  \033[31mERROR\033[0m  : Không tồn tại lớp học tại id: " . $course_import_id . "\n");
                            // return ;
                        }else{
                     
                            
                            $contact = Contact::where('import_id',$contact_import_id )->first();
                            if (!$contact){
                                echo("  \033[31mERROR\033[0m  : Không tồn tại contact: contact_id" . $contact_import_id . "\n");
                                // return ;
                            }else{
                                // echo("\n". $order_item_import_id . "\n");
                                $orderItem  = OrderItem::where('import_id',$order_item_import_id )->first();
                            
                                if (!$orderItem){
                                    echo("  \033[31mERROR\033[0m  : Không tồn tại OrderItem: orderItem_id = " . $order_item_import_id . "\n");
                                    // return ;
                                }else{
                                    $course_id = $course->id;
                                    $contact_id = $contact->id;
                                    $order_item_id = $orderItem->id;
                                    $courseStudentData[$key] = [
                                        'course_id' => $course_id,
                                        'contact_id' => $contact_id,
                                        'order_item_id' =>$order_item_id,
                                    ];
                                }
                            }
                        }
                    } 
                }
        }
        
        foreach ($courseStudentData as $data) {
            $this->addCourseStudent($data);
        }
    }

    public function addCourseStudent($data)
    {
        $courseStudent = new CourseStudent();
      
        $courseStudent->importFromExcelSeeder($data);
    }

    public function addSection($data)
    {
        $section = Section::newDefault();
        $section->importFromExcelSeeder($data);
    }

    public function getSection($sectionData){
        $uniqueData = [];

        foreach ($sectionData as $data) {
            [$id,$order_item_import_id, $course_import_id, $contact_import_id, $contact_name, $study_date, $trang_thai, $start_at, $end_at, $vn_teacher_name, $foreign_teacher_name, $tutor_name, $assistant_name, $status] = $data;
                // Nếu chưa tồn tại, thêm dòng dữ liệu vào mảng kết hợp
                if (!is_null($start_at) && is_numeric($start_at)) {
                    $unixStartAt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($start_at);
                    $formattedStartAT = date('H:i:s', $unixStartAt);
                } else {
                    $formattedStartAT = null;
                }
        
                if (!is_null($end_at) && is_numeric($end_at)) {
                    $unixEndAt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($end_at);
                    $formattedEndAT = date('H:i:s', $unixEndAt);
                } else {
                    $formattedEndAT = null;
                }
        
                if (!is_null($study_date) && is_numeric($study_date)) {
                    $unixTimestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($study_date);
                    $formattedStudyDate = date('Y-m-d', $unixTimestamp);
                } else {
                    $formattedStudyDate = null;
                }
                // Tạo khóa duy nhất dựa trên id, course_id, và contact_id
                // $key = $id . '-' . $course_id . '-' . $contact_id;
                $key = $id . '-' . $course_import_id ;
                // Khởi tạo các biến
                $vn_teacher_from = null;
                $vn_teacher_to = null;
                $foreign_teacher_from = null;
                $foreign_teacher_to = null;
                $tutor_from = null;
                $tutor_to = null;
                $assistant_from = null;
                $assistant_to = null;
                $vn_teacher_id = null;
                $foreign_teacher_id =null;
                $tutor_id =null;
                $assistant_id =null;
                
                // Kiểm tra xem vn_teacher_id có khác null không
                if (!is_null($vn_teacher_name)) {
                    // Nếu có, gán giá trị cho vn_teacher_from và vn_teacher_to
                    $vn_teacher =  Teacher::where('name', $vn_teacher_name)->first();
                    if($vn_teacher){
                        $vn_teacher_id =Teacher::where('name', $vn_teacher_name)->first()->id;
                    }else{
                        echo("  \033[31mERROR\033[0m  : Không tồn tại tutor" . $vn_teacher_name . "\n");
                    }
                    $vn_teacher_from = $formattedStartAT;
                    $vn_teacher_to = $formattedEndAT;
                }

                // Kiểm tra xem foreign_teacher_id có khác null không
                if (!is_null($foreign_teacher_name)) {
                    // Nếu có, gán giá trị cho foreign_teacher_from và foreign_teacher_to
                    $foreign_teacher =  Teacher::where('name', $foreign_teacher_name)->first();
                    if($foreign_teacher){
                        $foreign_teacher_id =Teacher::where('name', $foreign_teacher_name)->first()->id;
                    }else{
                        echo("  \033[31mERROR\033[0m  : Không tồn tại foreign_teacher" . $foreign_teacher . "\n");
                    }
                    $foreign_teacher_from = $formattedStartAT;
                    $foreign_teacher_to = $formattedEndAT;
                }

                // Kiểm tra xem tutor_teacher_id có khác null không
                if (!is_null($tutor_name)) {
                    // Nếu có, gán giá trị cho tutor_from và tutor_to
                    $tutor =  Teacher::where('name', $tutor_name)->first();
                    if($tutor){
                        $tutor_id =Teacher::where('name', $tutor_name)->first()->id;
                    }else{
                        echo("  \033[31mERROR\033[0m  : Không tồn tại tutor" . $tutor_name . "\n");
                    }
                  
                    $tutor_from = $formattedStartAT;
                    $tutor_to = $formattedEndAT;
                }

                // Kiểm tra xem assistant_teacher_id có khác null không
                if (!is_null($assistant_name)) {
                    // Nếu có, gán giá trị cho assistant_from và assistant_to
                    $assistant =  Teacher::where('name', $assistant_name)->first();
                    if($assistant){
                        $assistant_id =Teacher::where('name', $assistant_name)->first()->id;
                    }else{
                        echo("  \033[31mERROR\033[0m  : Không tồn tại assistant" . $assistant_name . "\n");
                    }
                    $assistant_from = $formattedStartAT;
                    $assistant_to = $formattedEndAT;
                }

                // Kiểm tra xem dòng dữ liệu đã tồn tại trong mảng kết hợp chưa
                if (!isset($uniqueData[$key])&& $key != '-') {
                    $section = Section::where('import_id',$id)->first();
                    if(!is_null($section) && !is_null($id)){
                        echo("  \033[31mERROR\033[0m  : Đã tồn tại Section tại id: " . $id . "\n");
                    }else{
                        $course = Course::where('import_id',$course_import_id )->first();
                        if(is_null($course_import_id) || is_null($course)){
                            echo("  \033[31mERROR\033[0m  : Không tồn tại lớp học tại id: " . $id . "\n");
                        }else {
                            $course_id = $course->id;
                            $uniqueData[$key] = [
                                'course_id' => $course_id,
                                'contact_name' => $contact_name,
                                'study_date' => $formattedStudyDate,
                                'trang_thai' => $trang_thai,
                                'start_at' => $formattedStartAT,
                                'end_at' => $formattedEndAT,
                                'vn_teacher_id' => $vn_teacher_id,
                                'foreign_teacher_id' => $foreign_teacher_id,
                                'tutor_id' => $tutor_id,
                                'assistant_id' => $assistant_id,
                                'status' => $status,
                                'vn_teacher_from' => $vn_teacher_from ?? null,
                                'vn_teacher_to' => $vn_teacher_to ?? null, 
                                'foreign_teacher_from' => $foreign_teacher_from ?? null,
                                'foreign_teacher_to' => $foreign_teacher_to ?? null, 
                                'tutor_from' => $tutor_from ?? null,
                                'tutor_to' => $tutor_to ?? null, 
                                'assistant_from' => $assistant_from ?? null,
                                'assistant_to' => $assistant_to ?? null, 
                                'import_id' => $id?? null,
                            ];
                        }
                    }
                }else if(isset($uniqueData[$key])&& $key != '-'){
                    // Nếu đã tồn tại, cập nhật các giá trị của dòng dữ liệu hiện tại
                    $uniqueData[$key]['vn_teacher_id'] = $vn_teacher_id ?? $uniqueData[$key]['vn_teacher_id']; 
                    $uniqueData[$key]['foreign_teacher_id'] = $foreign_teacher_id ?? $uniqueData[$key]['foreign_teacher_id'];      
                    $uniqueData[$key]['assistant_id'] = $assistant_id ?? $uniqueData[$key]['assistant_id']; 
                    $uniqueData[$key]['tutor_id'] = $tutor_id ?? $uniqueData[$key]['tutor_id']; 
                    $uniqueData[$key]['vn_teacher_from'] = $vn_teacher_from ?? $uniqueData[$key]['vn_teacher_from']; 
                    $uniqueData[$key]['vn_teacher_to'] = $vn_teacher_to ?? $uniqueData[$key]['vn_teacher_to'];      
                    $uniqueData[$key]['foreign_teacher_from'] = $foreign_teacher_from ?? $uniqueData[$key]['foreign_teacher_from']; 
                    $uniqueData[$key]['foreign_teacher_to'] = $foreign_teacher_to ?? $uniqueData[$key]['foreign_teacher_to'];   
                    $uniqueData[$key]['tutor_from'] = $tutor_from ?? $uniqueData[$key]['tutor_from']; 
                    $uniqueData[$key]['tutor_to'] = $tutor_to ?? $uniqueData[$key]['tutor_to'];   
                    $uniqueData[$key]['assistant_from'] = $assistant_from ?? $uniqueData[$key]['assistant_from']; 
                    $uniqueData[$key]['assistant_to'] = $assistant_to ?? $uniqueData[$key]['assistant_to'];   

                    foreach ($uniqueData[$key] as $field => $value) {
                        $uniqueData[$key]['end_at'] = $formattedEndAT;
                        // Chỉ cập nhật các giá trị không phải là null
                        if (is_null($value)) {
                            $uniqueData[$key][$field] = $value;
                        }
                    }
                }
        }
    
        foreach ($uniqueData as $data) {
            $this->addSection($data);
        }
    }
}
