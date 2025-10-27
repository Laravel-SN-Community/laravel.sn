<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Enums\ProjectStatus;
use App\Filament\Resources\Projects\ProjectResource;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Auto-set approved_at when status changes to Approved
        if ($data['status'] === ProjectStatus::Approved->value && ! $this->record->approved_at) {
            $data['approved_at'] = now();
        }

        // Clear approved_at if status changes from Approved
        if ($data['status'] !== ProjectStatus::Approved->value && $this->record->approved_at) {
            $data['approved_at'] = null;
        }

        // Clear rejection_reason if not rejected
        if ($data['status'] !== ProjectStatus::Rejected->value) {
            $data['rejection_reason'] = null;
        }

        return $data;
    }
}
