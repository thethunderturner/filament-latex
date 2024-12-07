<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use TheThunderTurner\FilamentLatex\Models\FilamentLatex;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages\CreateFilamentLatex;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages\EditFilamentLatex;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages\ListFilamentLatexes;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages\ViewFilamentLatex;

class FilamentLatexResource extends Resource
{
    protected static ?string $model = FilamentLatex::class;

    public static function getNavigationIcon(): string | Htmlable | null
    {
        return view('filament-latex::svg.latex');
    }

    public static function getNavigationLabel(): string
    {
        return config('filament-latex.navigation-label') ?? parent::getNavigationLabel();
    }

    public static function getNavigationGroup(): ?string
    {
        return config('filament-latex.navigation-group') ?? parent::getNavigationGroup();
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        DateTimePicker::make('deadline')
                            ->required()
                            ->native(false)
                            ->placeholder('DD-MM-YYYY HH:MM')
                            ->suffixIcon('heroicon-m-calendar')
                            ->format('d-m-Y H:i')
                            ->displayFormat('d-m-Y H:i'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),
                TextColumn::make('name'),
                TextColumn::make('deadline')
                    ->dateTime(),
                TextColumn::make('created_at')
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                    Tables\Actions\DeleteAction::make()
                        ->visible(function ($record) {
                            // In the future, only the creator can delete the record
                            return true;
                        })
                        ->requiresConfirmation()
                        ->color('danger'),
                ]),
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
            'index' => ListFilamentLatexes::route('/'),
            'create' => CreateFilamentLatex::route('/create'),
            'edit' => EditFilamentLatex::route('/{record}/edit'),
            'document' => ViewFilamentLatex::route('/{record}/view-document'),
        ];
    }
}
