<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Details')
                    ->description('Basic post information.')
                    ->headerActions([
                        Action::make('generateSlug')
                            ->label('Generate slug from title')
                            ->icon(Heroicon::Sparkles)
                            ->action(fn (Get $get, Set $set) => $set('slug', Str::slug((string) $get('title')))),
                        Action::make('clearSlug')
                            ->label('Clear slug')
                            ->icon(Heroicon::XMark)
                            ->color('danger')
                            ->action(fn (Set $set) => $set('slug', '')),

                        // ActionGroup::make([
                        //     Action::make('generateSlug')
                        //         ->label('Generate slug from title')
                        //         ->icon(Heroicon::Sparkles)
                        //         ->action(fn (Get $get, Set $set) => $set('slug', Str::slug((string) $get('title')))),
                        //     Action::make('clearSlug')
                        //         ->label('Clear slug')
                        //         ->icon(Heroicon::XMark)
                        //         ->color('danger')
                        //         ->action(fn (Set $set) => $set('slug', '')),
                        // ]),
                    ])
                    ->columns()
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->required()
                            ->default('draft'),
                        DateTimePicker::make('published_at')
                            ->columnSpanFull(),
                    ]),

                Section::make('Body')
                    ->schema([
                        Textarea::make('content')
                            ->required()
                            ->rows(10)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
