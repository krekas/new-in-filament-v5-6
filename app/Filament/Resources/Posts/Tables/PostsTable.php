<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Support\Enums\SlideOverPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'published',
                    ]),
                TextColumn::make('views')
                    ->numeric()
                    ->sortable()
                    ->summarize(
                        Sum::make()
                        // ->hiddenLabel()
                    ),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('—'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ]),
            ])
            ->recordActions([
                Action::make('quickEditBody')
                    ->label('Quick edit body')
                    ->icon(Heroicon::PencilSquare)
                    ->slideOver()
                    ->slideOverPosition(SlideOverPosition::Start)
                    ->modalHeading(fn (Post $record): string => "Edit body — {$record->title}")
                    ->fillForm(fn (Post $record): array => ['content' => $record->content])
                    ->schema([
                        Textarea::make('content')
                            ->required()
                            ->rows(15)
                            ->columnSpanFull(),
                    ])
                    ->action(fn (array $data, Post $record) => $record->update($data)),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
