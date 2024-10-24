
<div class="row">
    <div class="col-8">
        <h2>5. Các hoạt động tích chọn (check list) hoặc mang tính chất thống kê</h2>
    </div>
    <div class="col-4" >
        <div class="progress" style="height: 20px;">
            <div class="progress-bar" role="progressbar" style="width: {{$abroadApplication->progress(5)}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$abroadApplication->progress(5)}}%</div>
        </div>
    </div>
   
</div>

<div class="card mb-10">
    <div class="card-body">


        {{-- 1. Honor thesis --}}
        @include('sales.customers.abroad_applications.activities._honorThesis')

        {{-- 2. Sửa luận --}}
        @include('sales.customers.abroad_applications.activities._editThesis')

        {{-- 15. Kết quả dự tuyển --}}
        @include('sales.customers.abroad_applications.applicationParts.admissionLetter._admissionLetter')

        {{-- 4. Submit application --}}
        {{-- @include('sales.customers.abroad_applications.activities._applicationSubmission') --}}

        {{-- 5. Sửa luận --}}
        @include('sales.customers.abroad_applications.activities._interviewPractice')

        {{-- 6. Shool Selected Result --}}
        @include('sales.customers.abroad_applications.activities._applicationAdmittedSchool')



    </div>
</div>


<div class="row">
    <div class="col-8">
        <h2>6. Hỗ trợ trước nhập học (Hệ thống gửi email tự động cho phụ huynh trước thời điểm xuất hành 48 giờ)</h2>
    </div>
    <div class="col-4" >
        <div class="progress" style="height: 20px;">
            <div class="progress-bar" role="progressbar" style="width: {{$abroadApplication->progress(6)}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$abroadApplication->progress(6)}}%</div>
        </div>
    </div>
   
</div>

<div class="card mb-10">
    <div class="card-body">
        {{-- 1. Deposit tution fee --}}
        @include('sales.customers.abroad_applications.activities.deposit_tuition_fee._depositTuitionFee')

        {{-- 2. Deposit for school --}}
        @include('sales.customers.abroad_applications.activities._depositForSchool')

        {{-- 3. Visa cho học sinh --}}
        @include('sales.customers.abroad_applications.activities.studentVisa._studentVisa')
        {{-- 4. Cultural orientation --}}
        @include('sales.customers.abroad_applications.activities._culturalOrientations')

        {{-- 5. Support activities --}}
        @include('sales.customers.abroad_applications.activities._supportActivities')

        {{-- 6. Thời điểm học sinh lên đường --}}
        @include('sales.customers.abroad_applications.activities._flyingStudent')

        {{-- 7. Complete application --}}
        @include('sales.customers.abroad_applications.activities._completeApplication')

    </div>
</div>
