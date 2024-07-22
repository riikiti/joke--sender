<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JokeResource\Pages;
use App\Filament\Resources\JokeResource\RelationManagers;
use App\Models\Joke;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class JokeResource extends Resource
{
    protected static ?string $model = Joke::class;
    protected static ?string $navigationLabel = 'Шутки';
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)
                    ->schema([
                        Textarea::make('body')->label('Шутка')->maxLength(4096),
                        DateTimePicker::make('published_at')->label('Дата публикации'),
                        Toggle::make('sms')->label('SMS'),
                        Toggle::make('tg')->label('Telegram'),
                        FileUpload::make('photo')
                            ->directory('photos')
                            ->label('Фото')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('id')->searchable(),
                TextColumn::make('body')->label('Шутка')->searchable()->formatStateUsing(fn ($state) => Str::limit($state, 30)),
                TextColumn::make('published_at')->label('Дата отправки')->searchable()->sortable(),
                ToggleColumn::make('sms')->label('SMS'),
                ToggleColumn::make('tg')->label('Telegram'),
                ToggleColumn::make('completed')->label('Опубликовано')->sortable(),
                ImageColumn::make('photo')->label('Фото')->sortable(),
                TextColumn::make('created_at')->label('Дата создания')->sortable()
            ])
            ->filters([
                Filter::make('completed')->label('Опубликовано')
                    ->query(fn (Builder $query): Builder => $query->where('completed', true))
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
            'index' => Pages\ListJokes::route('/'),
            'create' => Pages\CreateJoke::route('/create'),
            'edit' => Pages\EditJoke::route('/{record}/edit'),
        ];
    }
}
