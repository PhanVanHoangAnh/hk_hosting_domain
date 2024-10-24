<div class="row mb-4">
    @include('generals.subjects.subject_select_package.types', [
        'selectedLevel' => isset($selectedLevel) ? $selectedLevel : null,
    ])
</div>