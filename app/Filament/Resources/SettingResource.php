<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Ayarlar';

    protected static ?string $modelLabel = 'Ayar';

    protected static ?string $pluralModelLabel = 'Ayarlar';

    public static function form(Form $form): Form
    {
        $fieldTypes = [
            'text' => 'Text',
            'textarea' => 'Textarea',
            'rich_editor' => 'Rich Editor',
            'image' => 'Image',
            'file' => 'File',
            'select' => 'Select',
            'radio' => 'Radio',
            'checkbox' => 'Checkbox',
            'color' => 'Color',
            'date' => 'Date',
            'datetime' => 'DateTime',
            'number' => 'Number',
            'url' => 'URL',
            'email' => 'Email',
        ];

        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Key')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->alphaDash()
                    ->helperText('Sadece harf, rakam, tire ve alt çizgi kullanılabilir'),
                Forms\Components\TextInput::make('name')
                    ->label('İsim')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->label('Tip')
                    ->options($fieldTypes)
                    ->required()
                    ->live(),
                Forms\Components\KeyValue::make('options')
                    ->label('Seçenekler (JSON)')
                    ->visible(fn (Forms\Get $get) => in_array($get('type'), ['select', 'radio']))
                    ->helperText('Select ve Radio tipleri için seçenekler (key: value formatında)'),
                
                // Text, URL, Email
                Forms\Components\TextInput::make('value_text')
                    ->label('Değer')
                    ->visible(fn (Forms\Get $get) => in_array($get('type'), ['text', 'url', 'email']))
                    ->maxLength(255),
                
                // Number
                Forms\Components\TextInput::make('value_number')
                    ->label('Değer')
                    ->numeric()
                    ->visible(fn (Forms\Get $get) => $get('type') === 'number'),
                
                // Textarea
                Forms\Components\Textarea::make('value_textarea')
                    ->label('Değer')
                    ->rows(5)
                    ->visible(fn (Forms\Get $get) => $get('type') === 'textarea')
                    ->columnSpanFull(),
                
                // Rich Editor
                Forms\Components\RichEditor::make('value_rich_editor')
                    ->label('Değer')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'rich_editor')
                    ->columnSpanFull(),
                
                // Image
                Forms\Components\FileUpload::make('value_image')
                    ->label('Değer')
                    ->image()
                    ->disk('public')
                    ->directory('settings')
                    ->visibility('public')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'image')
                    ->columnSpanFull(),
                
                // File
                Forms\Components\FileUpload::make('value_file')
                    ->label('Değer')
                    ->disk('public')
                    ->directory('settings')
                    ->visibility('public')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'file')
                    ->columnSpanFull(),
                
                // Select
                Forms\Components\Select::make('value_select')
                    ->label('Değer')
                    ->options(function (Forms\Get $get) {
                        $options = $get('options');
                        if (is_array($options)) {
                            return $options;
                        }
                        return [];
                    })
                    ->visible(fn (Forms\Get $get) => $get('type') === 'select')
                    ->searchable(),
                
                // Radio
                Forms\Components\Radio::make('value_radio')
                    ->label('Değer')
                    ->options(function (Forms\Get $get) {
                        $options = $get('options');
                        if (is_array($options)) {
                            return $options;
                        }
                        return [];
                    })
                    ->visible(fn (Forms\Get $get) => $get('type') === 'radio'),
                
                // Checkbox
                Forms\Components\Toggle::make('value_checkbox')
                    ->label('Değer')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'checkbox'),
                
                // Color
                Forms\Components\ColorPicker::make('value_color')
                    ->label('Değer')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'color'),
                
                // Date
                Forms\Components\DatePicker::make('value_date')
                    ->label('Değer')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'date')
                    ->nullable(),
                
                // DateTime
                Forms\Components\DateTimePicker::make('value_datetime')
                    ->label('Değer')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'datetime')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Key')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('İsim')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tip')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Değer')
                    ->limit(50)
                    ->wrap()
                    ->formatStateUsing(function ($state, $record) {
                        if (!$record) {
                            return $state;
                        }
                        // Görsel veya dosya ise sadece dosya adını göster
                        if (in_array($record->type, ['image', 'file']) && $state) {
                            return basename($state);
                        }
                        // Checkbox ise Evet/Hayır göster
                        if ($record->type === 'checkbox') {
                            return $state == '1' ? 'Evet' : 'Hayır';
                        }
                        return $state;
                    }),
                Tables\Columns\ImageColumn::make('value')
                    ->label('Önizleme')
                    ->disk('public')
                    ->visible(fn ($record) => $record && $record->type === 'image')
                    ->size(50),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tip')
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Textarea',
                        'rich_editor' => 'Rich Editor',
                        'image' => 'Image',
                        'file' => 'File',
                        'select' => 'Select',
                        'radio' => 'Radio',
                        'checkbox' => 'Checkbox',
                        'color' => 'Color',
                        'date' => 'Date',
                        'datetime' => 'DateTime',
                        'number' => 'Number',
                        'url' => 'URL',
                        'email' => 'Email',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}