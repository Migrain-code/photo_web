<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSetting extends CreateRecord
{
    protected static string $resource = SettingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Merge all value_* fields into value based on type
        $type = $data['type'] ?? null;
        
        if (in_array($type, ['text', 'url', 'email']) && isset($data['value_text'])) {
            $data['value'] = $data['value_text'];
        } elseif ($type === 'number' && isset($data['value_number'])) {
            $data['value'] = $data['value_number'];
        } elseif ($type === 'textarea' && isset($data['value_textarea'])) {
            $data['value'] = $data['value_textarea'];
        } elseif ($type === 'rich_editor' && isset($data['value_rich_editor'])) {
            $data['value'] = $data['value_rich_editor'];
        } elseif ($type === 'image' && isset($data['value_image'])) {
            // Handle array from FileUpload - FileUpload component returns array
            if (is_array($data['value_image']) && !empty($data['value_image'])) {
                $data['value'] = $data['value_image'][0];
            } elseif (is_string($data['value_image']) && !empty($data['value_image'])) {
                $data['value'] = $data['value_image'];
            } else {
                $data['value'] = null;
            }
        } elseif ($type === 'file' && isset($data['value_file'])) {
            // Handle array from FileUpload - FileUpload component returns array
            if (is_array($data['value_file']) && !empty($data['value_file'])) {
                $data['value'] = $data['value_file'][0];
            } elseif (is_string($data['value_file']) && !empty($data['value_file'])) {
                $data['value'] = $data['value_file'];
            } else {
                $data['value'] = null;
            }
        } elseif ($type === 'select' && isset($data['value_select'])) {
            $data['value'] = $data['value_select'];
        } elseif ($type === 'radio' && isset($data['value_radio'])) {
            $data['value'] = $data['value_radio'];
        } elseif ($type === 'checkbox') {
            // Toggle component returns boolean, convert to '1' or '0'
            $data['value'] = ($data['value_checkbox'] ?? false) ? '1' : '0';
        } elseif ($type === 'color' && isset($data['value_color'])) {
            $data['value'] = $data['value_color'];
        } elseif ($type === 'date' && isset($data['value_date'])) {
            $data['value'] = $data['value_date'];
        } elseif ($type === 'datetime' && isset($data['value_datetime'])) {
            $data['value'] = $data['value_datetime'];
        }
        
        // Remove all value_* fields
        unset(
            $data['value_text'],
            $data['value_number'],
            $data['value_textarea'],
            $data['value_rich_editor'],
            $data['value_image'],
            $data['value_file'],
            $data['value_select'],
            $data['value_radio'],
            $data['value_checkbox'],
            $data['value_color'],
            $data['value_date'],
            $data['value_datetime']
        );
        
        return $data;
    }
}
