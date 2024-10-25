<?php

namespace App\Library;

use App\Models\Role;

class Module
{
    public const SALES = 'sales';
    public const MARKETING = 'marketing';
    public const EDU = 'edu';
    public const ABROAD = 'abroad';
    public const ACCOUNTING = 'accounting';
    public const EXTRACURRICULAR = 'extracurricular';
    public const STUDENT = 'student';
    public const TEACHER = 'teacher';
    public const TEACHING_ASSISTANT = 'teaching_assistant';
    public const SYSTEM = 'system';
    public const DIRECTOR = 'director';

    public static function getAll()
    {
        return [
            self::SALES,
            self::MARKETING,
            self::EDU,
            self::ABROAD,
            self::ACCOUNTING,
            self::EXTRACURRICULAR,
            self::STUDENT,
            self::TEACHER,
            self::TEACHING_ASSISTANT,
            self::DIRECTOR,
            self::SYSTEM,
        ];
    }

    public static function getModuleRoleData()
    {
        $data = [];

        foreach (self::getAll() as $module) {
            $data[] = [
                'name' => $module,
                'label' => trans('messages.module.' . $module),
                'roles' => Role::where('module', $module)->get()->map(function ($role) {
                    return [
                        'name' => $role->name,
                        'id' => $role->id,
                    ];
                })->toArray()
            ];
        }

        return $data;
    }
}