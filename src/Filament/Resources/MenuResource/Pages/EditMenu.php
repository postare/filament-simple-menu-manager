<?php

namespace Postare\SimpleMenuManager\Filament\Resources\MenuResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Postare\SimpleMenuManager\Filament\Resources\MenuResource;

class EditMenu extends EditRecord
{
    protected static string $resource = MenuResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['items'] = removeEmptyValues($data['items']);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
