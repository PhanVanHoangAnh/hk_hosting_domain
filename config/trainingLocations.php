<?php
use App\Models\TrainingLocation;

// Branchs
$haNoiBranch = \App\Library\Branch::BRANCH_HN;
$hoChiMinhBranch = \App\Library\Branch::BRANCH_SG;

// Status
$activeStatus = TrainingLocation::STATUS_ACTIVE;

return [
    [
        'branch' => $haNoiBranch,
        'name' => "Trung Tâm",
        'address' => 'Số 9 Vũ Phạm Hàm',
        'status' => $activeStatus
    ],
    [
        'branch' => $haNoiBranch,
        'name' => "FPT Hòa lạc",
        'address' => '',
        'status' => $activeStatus
    ],
    [
        'branch' => $haNoiBranch,
        'name' => "FPT Bắc Ninh",
        'address' => '',
        'status' => $activeStatus
    ],
    [
        'branch' => $haNoiBranch,
        'name' => "FPT Hải Phòng",
        'address' => '',
        'status' => $activeStatus
    ],
    [
        'branch' => $hoChiMinhBranch,
        'name' => "Trung Tâm",
        'address' => '',
        'status' => $activeStatus
    ],
];