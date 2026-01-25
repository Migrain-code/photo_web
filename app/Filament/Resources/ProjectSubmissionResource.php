<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectSubmissionResource\Pages;
use App\Models\ProjectSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectSubmissionResource extends Resource
{
    protected static ?string $model = ProjectSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Proje Formları';

    protected static ?string $modelLabel = 'Proje Formu';

    protected static ?string $pluralModelLabel = 'Proje Formları';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Ad')
                    ->required()
                    ->maxLength(255)
                    ->disabledOn('view'),
                Forms\Components\TextInput::make('email')
                    ->label('E-posta')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->disabledOn('view'),
                Forms\Components\TextInput::make('phone')
                    ->label('Telefon')
                    ->required()
                    ->maxLength(255)
                    ->disabledOn('view'),
                Forms\Components\Textarea::make('message')
                    ->label('Proje açıklaması')
                    ->required()
                    ->columnSpanFull()
                    ->disabledOn('view'),
                Forms\Components\CheckboxList::make('services')
                    ->label('Seçilen hizmetler')
                    ->options(ProjectSubmission::serviceOptions())
                    ->required()
                    ->columns(2)
                    ->disabledOn('view')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Ad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-posta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('message')
                    ->label('Mesaj')
                    ->limit(40)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectSubmissions::route('/'),
            'create' => Pages\CreateProjectSubmission::route('/create'),
            'view' => Pages\ViewProjectSubmission::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function canEdit($record): bool
    {
        return false;
    }
}
