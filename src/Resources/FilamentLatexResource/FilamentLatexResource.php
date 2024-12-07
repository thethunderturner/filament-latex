<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource;

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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->color('warning'),
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
