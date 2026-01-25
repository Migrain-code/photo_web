<?php

namespace App\Filament\Resources\ProjectSubmissionResource\Pages;

use App\Filament\Resources\ProjectSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectSubmissions extends ListRecords
{
    protected static string $resource = ProjectSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
