<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use App\Models\ArticleImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Makaleler';

    protected static ?string $modelLabel = 'Makale';

    protected static ?string $pluralModelLabel = 'Makaleler';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Başlık')
                    ->required()
                    ->maxLength(255)
                    ->live()
                    ->afterStateUpdated(function (Forms\Set $set, $state) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('URL için kullanılacak benzersiz tanımlayıcı')
                    ->afterStateUpdated(fn ($state) => Str::slug($state)),
                Forms\Components\Section::make('SEO Ayarları')
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->label('SEO Başlık')
                            ->maxLength(255)
                            ->helperText('Arama motorları için başlık (60 karakter önerilir)')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('seo_description')
                            ->label('SEO Açıklama')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Arama motorları için açıklama (160 karakter önerilir)')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('content')
                    ->label('İçerik')
                    ->required()
                    ->columnSpanFull()
                    ->disableToolbarButtons([
                        'blockquote',
                    ])
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'heading',
                        'bulletList',
                        'orderedList',
                        'redo',
                        'undo',
                    ]),
                Forms\Components\FileUpload::make('featured_image')
                    ->label('Öne Çıkan Görsel')
                    ->image()
                    ->directory('articles/featured')
                    ->visibility('public')
                    ->helperText('Ana sayfada gösterilecek görsel. Önerilen boyut: 1200x800px veya 3:2 oran')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('article_gif')
                    ->label('Hover GIF')
                    ->directory('articles/gifs')
                    ->visibility('public')
                    ->acceptedFileTypes(['image/gif'])
                    ->helperText('Ana sayfada makale üzerine gelindiğinde gösterilecek GIF. Önerilen boyut: Öne çıkan görsel ile aynı boyut')
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('images')
                    ->label('Makale Görselleri')
                    ->relationship('images')
                    ->schema([
                        Forms\Components\FileUpload::make('image_path')
                            ->label('Görsel')
                            ->image()
                            ->directory('articles/images')
                            ->visibility('public')
                            ->required(),
                        Forms\Components\TextInput::make('order')
                            ->label('Sıra')
                            ->numeric()
                            ->default(0),
                    ])
                    ->defaultItems(0)
                    ->addActionLabel('Görsel Ekle')
                    ->reorderableWithButtons()
                    ->helperText('Makale detay sayfasında gösterilecek ek görseller. İstediğiniz kadar görsel ekleyebilirsiniz.')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Öne Çıkan Görsel')
                    ->disk('public')
                    ->circular(),
                Tables\Columns\TextColumn::make('views_count')
                    ->label('Görüntülenme')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma Tarihi')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
