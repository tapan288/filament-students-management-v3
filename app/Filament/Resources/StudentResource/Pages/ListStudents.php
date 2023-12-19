<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Actions;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\StudentResource;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('importStudents')
                ->label('Import Students')
                ->color('danger')
                ->form([
                    FileUpload::make('attachment'),
                ])
                ->action(function (array $data) {
                    $file = public_path("storage/" . $data['attachment']);

                    Excel::import(new StudentsImport, $file);

                    Notification::make()
                        ->success()
                        ->title('Students Imported')
                        ->body('Students data imported successfully.')
                        ->send();
                })
        ];
    }
}
