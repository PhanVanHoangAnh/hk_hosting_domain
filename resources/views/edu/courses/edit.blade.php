@extends('layouts.main.app', [
    'menu' => 'edu',
])

@section('sidebar')
    @include('edu.modules.sidebar', [
        'menu' => 'courses',
        'sidebar' =>'addCourse',
    ])
@endsection

@section('content')
<div>
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7">
        <div class="page-title d-flex flex-column py-1">
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Chỉnh sửa thông tin lớp học</span>
            </h1>
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <li class="breadcrumb-item text-muted">
                    <a class="text-muted text-hover-primary">Trang chính</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Lớp học</li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-dark">Chỉnh sửa thông tin lớp học</li>
            </ul>
        </div>
    </div>

    <div class="card-header border-0" id="addCourseContainer">
        <form id="courseForm" action="{{ action([App\Http\Controllers\Edu\CourseController::class, 'update'], ['id' => $course->id]) }}" method="put">
            @csrf
            @include('edu.courses._form')
        </form>
    </div>
</div>


@endsection