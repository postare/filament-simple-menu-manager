<?php

namespace Postare\SimpleMenuManager\Filament\Resources\MenuResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Postare\SimpleMenuManager\Filament\Resources\MenuResource;

class CreateMenu extends CreateRecord
{
    protected static string $resource = MenuResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['items'] = removeEmptyValues($data['items']);

        return $data;
    }
}
