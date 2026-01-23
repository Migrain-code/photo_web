<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function fillForm(): void
    {
        $record = $this->record;
        $type = $record->type;
        $value = $record->value;

        // Prepare all form data including base fields
        $formData = [
            'key' => $record->key,
            'name' => $record->name,
            'type' => $type,
            'options' => $record->options,
        ];

        // Set the appropriate value field based on type
        switch ($type) {
            case 'text':
            case 'url':
            case 'email':
                $formData['value_text'] = $value;
                break;
            case 'number':
                $formData['value_number'] = $value;
                break;
            case 'textarea':
                $formData['value_textarea'] = $value;
                break;
            case 'rich_editor':
                $formData['value_rich_editor'] = $value;
                break;
            case 'image':
                if ($value) {
                    // FileUpload component expects an array
                    $formData['value_image'] = [$value];
                }
                break;
            case 'file':
                if ($value) {
                    // FileUpload component expects an array
                    $formData['value_file'] = [$value];
                }
                break;
            case 'select':
                $formData['value_select'] = $value;
                break;
            case 'radio':
                $formData['value_radio'] = $value;
                break;
            case 'checkbox':
                $formData['value_checkbox'] = $value === '1' || $value === true || $value === 'true';
                break;
            case 'color':
                $formData['value_color'] = $value;
                break;
            case 'date':
                if ($value && $value !== '1970-01-01' && $value !== '1970-01-01 00:00:00') {
                    $formData['value_date'] = $value;
                }
                break;
            case 'datetime':
                if ($value && $value !== '1970-01-01' && $value !== '1970-01-01 00:00:00') {
                    $formData['value_datetime'] = $value;
                }
                break;
        }

        // Fill the form with prepared data
        $this->form->fill($formData);
    }

    protected function mutateFormDataBeforeSave(array $data): array
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
