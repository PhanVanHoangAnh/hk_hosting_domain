<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function getSubjectsByType(Request $request)
    {
        $subjects = Subject::getSubjectsByType($request->type);

        return response()->view('generals.subjects.subjectOptionsByType', [
            'subjects' => $subjects,
            'selectedId' => isset($request->selectedId) ? $request->selectedId : null
        ]);
    }

    public function getLevelsBySubject(Request $request)
    {
        $levels = Subject::getLevelsBySubjectName(Subject::find($request->subjectId)->name);

        return response()->view('generals.subjects.levelOptionBySubject', [
            'levels' => $levels,
            'levelSelected' => isset($request->levelSelected) ? $request->levelSelected : null
        ]);
    }

    public function getTypeBoxByLevel(Request $request)
    {
        $types = Subject::getTypesByLevel($request->level);

        return response()->view('generals.subjects.type_box_by_level', [
            'types' => $types,
            'parentId' => $request->parentId,
            'selectedType' => isset($request->selectedType) && $request->selectedType ? $request->selectedType : null,
            'selectedSubjectId' => isset($request->selectedSubjectId) && $request->selectedSubjectId ? $request->selectedSubjectId : null,
            'typeError' => isset($request->typeError) ? $request->typeError : null,
            'subjectError' => isset($request->subjectError) ? $request->subjectError : null,
        ]);
    }

    public function getSubjectBoxByType(Request $request)
    {
        $subjects = Subject::getSubjectsByType($request->type);

        return response()->view('generals.subjects.subject_box_by_type', [
            'subjects' => $subjects,
            'parentId' => $request->parentId,
            'selectedSubjectId' => isset($request->selectedSubjectId) && $request->selectedSubjectId ? $request->selectedSubjectId : null,
            'subjectError' => isset($request->subjectError) ? $request->subjectError : null,
        ]);
    }

    public function getSubjectsFormByType(Request $request)
    {
        $subjects = Subject::getSubjectsByType($request->type);

        return response()->view('generals.subjects.subject_select_package.subjects', [
            'subjects' => $subjects,
            'parentId' => $request->parentId,
            'selectedSubjectId' => isset($request->selectedSubjectId) && $request->selectedSubjectId ? $request->selectedSubjectId : null,
            'selectedLevel' => isset($request->selectedLevel) && $request->selectedLevel ? $request->selectedLevel : null,
            'subjectError' => isset($request->subjectError) ? $request->subjectError : null,
        ]);
    }

    public function getLevelsFormBySubject(Request $request)
    {
        $levels = Subject::getLevelsBySubjectName(Subject::find($request->subject_id)->name);

        return response()->view('generals.subjects.subject_select_package.levels', [
            'levels' => $levels,
            'parentId' => $request->parentId,
            'selectedLevel' => isset($request->selectedLevel) && $request->selectedLevel ? $request->selectedLevel : null,
            'levelError' => isset($request->levelError) ? $request->levelError : null,
        ]);
    }
}
