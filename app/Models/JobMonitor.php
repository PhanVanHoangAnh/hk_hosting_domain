<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobMonitor extends Model
{
    use HasFactory;

    public static function createNew($type, $jobId)
    {
        $jobMonitor = new self();
        $jobMonitor->type = $type;
        $jobMonitor->job_id = $jobId;

        $jobMonitor->save();

        return $jobMonitor;
    }

    public function getMetadata()
    {
        if (!$this->metadata) {
            return [];
        }

        return json_decode($this->metadata, true);
    }

    public function updateProgress($progressData)
    {
        $data = $this->getMetadata();

        $data['progress'] = $progressData;

        $this->updateMetadata($data);
    }

    public function updateMetadata($data)
    {
        $this->metadata = json_encode($data);
        $this->save();
    }
}
