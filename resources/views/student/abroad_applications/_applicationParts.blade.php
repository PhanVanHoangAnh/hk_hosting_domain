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
        <div class="progress" style="height: 20px;">
            <div class="progress-bar" role="progressbar" style="width: {{$abroadApplication->progress(4)}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$abroadApplication->progress(4)}}%</div>
        </div>
    </div>
   
</div>


<div class="card mb-10 collapse show" id="kt_toggle_block_4">
    <div class="card-body">

        {{-- 1. Lộ trình học thuật chiến lược --}}
        @include('student.abroad_applications.applicationParts._strategicLearningCurriculum')

        {{-- 2. Extracurricular plan --}}
        @include('student.abroad_applications.applicationParts.extracurricular_plan._extracurricularPlan')

        {{-- 3. Danh sách trường, yêu cầu tuyển sinh --}}
        @include('student.abroad_applications.applicationParts.applicationSchool._applicationSchool')

        {{-- 4. Kế hoạch ngoại khoá --}}
        @include('student.abroad_applications.applicationParts.extracurricularSchedule._extracurricularSchedule')

        {{-- 5. Chứng chỉ --}}
        @include('student.abroad_applications.applicationParts.certifications._certification')

        {{-- 6. Hoạt động ngoại khoá --}}
        @include('student.abroad_applications.applicationParts.extracurricularActivity._extracurricularActivity')

        {{-- 7. Recommendation letter --}}
        @include('student.abroad_applications.applicationParts.recommendation_letter._recommendationLetter')

        {{-- 8. Essay result --}}
        @include('student.abroad_applications.applicationParts.essay_result._essayResult')

        {{-- 9. Mạng xã hội --}}
        @include('student.abroad_applications.applicationParts._socialNetworks')

        {{-- 10. Hồ sơ tài chính --}}
        @include('student.abroad_applications.applicationParts._financialDocuments')

        {{-- 11. Student CV --}}
        @include('student.abroad_applications.applicationParts.student_cv._studentCV')

        {{-- 12. Apply CV --}}
        @include('student.abroad_applications.applicationParts.studyAbroadApplication._studyAbroadApplication')
        
        {{-- 13. Hồ sơ dự tuyển --}}
        @include('student.abroad_applications.applicationParts.hsdt._hsdt')
        
        {{-- 14. Hồ sơ hoàn chỉnh --}}
        @include('student.abroad_applications.applicationParts.completeFile._completeFile')

        {{-- 3. application fee --}}
        @include('student.abroad_applications.activities._applicationFee')

        {{-- 16. Bản scan thông tin cá nhân --}}
        @include('student.abroad_applications.applicationParts.scanOfInformation._scanOfInformation')

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
