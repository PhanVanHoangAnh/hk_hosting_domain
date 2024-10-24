<?php
namespace App\Http\Controllers\Abroad;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\Calendar;
use App\Models\LoTrinhHocThuatChienLuoc;
use App\Models\AbroadScore;

class LoTrinhChienLuocController extends Controller
{
    public function createLoTrinhHocThuatChienLuoc(Request $request)
    {
        LoTrinhHocThuatChienLuoc::createLoTrinhHocThuatChienLuoc($request);

        return response()->json([
            'message' => 'Kê khai lộ trình học thuật chiến lược thành công'
        ]);
    }
    public function showIeltsScore(Request $request){
        $abroadApplicationId = $request->abroadApplicationId;
        
        $ielts = AbroadScore::where('abroad_application_id', $abroadApplicationId)->whereNotNull('ielts_score')->get();
       
        return view('abroad/abroad_applications/applicationParts/strategic_learning_curriculum/showIeltsScore',[
            'abroadApplicationId'=>$abroadApplicationId,
            'ielts'=>$ielts
        ]);
    }
    public function createIeltsScore(Request $request){
        $abroadApplicationId = $request->abroadApplicationId;
        
        return view('abroad/abroad_applications/applicationParts/strategic_learning_curriculum/createIeltsScore',[
            'abroadApplicationId'=>$abroadApplicationId,
        ]);
    }
    public function doneCreateIeltsScore(Request $request){
      
        $abroadScore = new AbroadScore();
        $abroadScore->createScore($request);

        return response()->json([
            'message' => 'Thêm mới điểm thi Ielts thành công'
        ]);
    }

    public function editIeltsScore(Request $request){
        $id = $request->id;
        $ielts = AbroadScore::find($id);
        return view('abroad/abroad_applications/applicationParts/strategic_learning_curriculum/editIeltsScore',[
            'ielts'=>$ielts,
        ]);
    }


    public function doneEditIeltsScore(Request $request){
        $id = $request->id;
        $abroadScore =  AbroadScore::find($id);
        $abroadScore->updateScore($request);

        return response()->json([
            'message' => 'Cập nhật điểm thi Ielts thành công'
        ]);
    }
   

    public function showSatScore(Request $request){
        $abroadApplicationId = $request->abroadApplicationId;
        
        $sats = AbroadScore::where('abroad_application_id', $abroadApplicationId)->whereNotNull('sat_score')->get();
       
        return view('abroad/abroad_applications/applicationParts/strategic_learning_curriculum/showSatScore',[
            'abroadApplicationId'=>$abroadApplicationId,
            'sats'=>$sats
        ]);
    }
    public function createSatScore(Request $request){
        $abroadApplicationId = $request->abroadApplicationId;
        
        return view('abroad/abroad_applications/applicationParts/strategic_learning_curriculum/createSatScore',[
            'abroadApplicationId'=>$abroadApplicationId,
        ]);
    }
    public function doneCreateSatScore(Request $request){
      
        $abroadScore = new AbroadScore();
        $abroadScore->createScore($request);

        return response()->json([
            'message' => 'Thêm mới điểm thi Ielts thành công'
        ]);
    }

    public function editSatScore(Request $request){
        $id = $request->id;
        $sat = AbroadScore::find($id);
        return view('abroad/abroad_applications/applicationParts/strategic_learning_curriculum/editSatScore',[
            'sat'=>$sat,
        ]);
    }


    public function doneEditSatScore(Request $request){
        $id = $request->id;
        $abroadScore =  AbroadScore::find($id);
        $abroadScore->updateScore($request);

        return response()->json([
            'message' => 'Cập nhật điểm thi Sat thành công'
        ]);
    }
    
}
