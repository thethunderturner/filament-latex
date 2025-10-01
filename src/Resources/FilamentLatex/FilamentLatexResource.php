<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatex;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use TheThunderTurner\FilamentLatex\Models\FilamentLatex;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatex\Pages\CreateFilamentLatex;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatex\Pages\EditFilamentLatex;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatex\Pages\ListFilamentLatexes;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatex\Pages\ViewFilamentLatex;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatex\Schemas\FilamentLatexForm;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatex\Tables\FilamentLatexTable;

class FilamentLatexResource extends Resource
{
    protected static ?string $model = FilamentLatex::class;

    /**
     * The view(...) in this case is the default view for the navigation icon.
     */
    public static function getNavigationIcon(): string | BackedEnum | Htmlable | null
    {
        return config('filament-latex.navigation-icon') ?? view('filament-latex::svg.latex');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-latex::filament-latex.page.navigation.label') ?? parent::getNavigationLabel();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament-latex::filament-latex.page.navigation.label') ?? parent::getNavigationGroup();
    }

    public static function form(Schema $schema): Schema
    {
        return FilamentLatexForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FilamentLatexTable::configure($table);
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
