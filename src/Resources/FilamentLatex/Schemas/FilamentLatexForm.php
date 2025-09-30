<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatex\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use TheThunderTurner\FilamentLatex\Models\FilamentLatex;

class FilamentLatexForm
{
    public static function configure(Schema $schema): Schema
    {
        $userModel = app(FilamentLatex::class)->getUserModel();

        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make([
                            TextInput::make('name')
                                ->label(__('filament-latex::filament-latex.field.name'))
                                ->translateLabel()
                                ->required(),
                            Select::make('author_id')
                                ->label(__('filament-latex::filament-latex.field.author_id'))
                                ->default(fn () => Auth::id())
                                ->options(fn () => $userModel::all()->pluck('name', 'id'))
                                ->disabled()
                                ->dehydrated()
                                ->required(),
                        ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make([
                            DateTimePicker::make('deadline')
                                ->label(__('filament-latex::filament-latex.field.deadline'))
                                ->native(false)
                                ->placeholder('DD-MM-YYYY HH:MM')
                                ->suffixIcon('heroicon-m-calendar')
                                ->format('Y-m-d H:i:s')
                                ->displayFormat('d-m-Y H:i'),
                            Select::make('collaborators_id')
                                ->label(__('filament-latex::filament-latex.field.collaborators_id'))
                                ->native(false)
                                ->multiple()
                                ->options(fn () => $userModel::all()->pluck('name', 'id'))
                                ->searchable(),
                            Select::make('parser')
                                ->label(__('filament-latex::filament-latex.page.options.parser.label', ['default' => 'TeX Parser']))
                                ->required()
                                ->native(false)
                                ->options(config('filament-latex.parsers')),
                        ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }
}
