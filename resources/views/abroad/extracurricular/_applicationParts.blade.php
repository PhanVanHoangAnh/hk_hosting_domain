
<div class="row">
    <div class="col-8">
        <div class="d-flex align-items-center mb-7">
            <h2 class="mb-0 me-3">4. Thành phần hồ sơ</h2>
            <a class="d-flex flex-center rotate-n180 ms-3" data-bs-toggle="collapse" class="rotate collapsible collapsed mb-2"
                href="#kt_toggle_block_4" id="show">
                <i class="ki-duotone ki-down fs-3"></i>
            </a>
        </div>
    </div>
    <div class="col-4" >
        {{-- <div class="progress" style="height: 50%;">
            <div class="progress-bar" role="progressbar" style="width: {{$abroadApplication->progress(4)}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$abroadApplication->progress(4)}}%</div>
        </div> --}}
    </div>
</div>



<div class="card mb-10 collapse show" id="kt_toggle_block_4">
    <div class="card-body">

        {{-- /Users/nguyendangphong/asms/resources/views/abroad/extracurricular/extracurricular_plan/_extracurricularPlan.blade.php --}}
        {{-- 1. Lộ trình học thuật chiến lược --}}
        @include('abroad.extracurricular.strategic_learning_curriculum._strategicLearningCurriculum')
        {{-- 2. Extracurricular plan --}}
        @include('abroad.extracurricular.extracurricular_plan._extracurricularPlan')
        {{-- @include('abroad.abroad_applications.applicationParts.extracurricular_plan._extracurricularPlan') --}}


         {{-- 3. Danh sách trường, yêu cầu tuyển sinh --}}
         @include('abroad.extracurricular.applicationSchool._applicationSchool')

        {{-- 4. Kế hoạch ngoại khoá --}}
        {{-- @include('abroad.extracurricular.extracurricularSchedule._extracurricularSchedule') --}}
        @include('abroad.extracurricular.extracurricularSchedule._extracurricularSchedule')

        {{-- 5. Chứng chỉ --}}
        {{-- @include('abroad.extracurricular.certifications._certification') --}}
        @include('abroad.extracurricular.certifications._certification')


        {{-- 6. Hoạt động ngoại khoá --}}
        {{-- @include('abroad.extracurricular.extracurricularActivity._extracurricularActivity') --}}
        @include('abroad.extracurricular.extracurricularActivity._extracurricularActivity')

        

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggleBlock = document.getElementById('kt_toggle_block_1');
        var marginBottomElement = document.querySelector('.mb-10');

        toggleBlock.addEventListener('shown.bs.collapse', () => marginBottomElement.classList.add('d-none'));
        toggleBlock.addEventListener('hidden.bs.collapse', () => marginBottomElement.classList.remove(
            'd-none'));
    });
</script>
