<?php

namespace TheThunderTurner\FilamentLatex\Resources\LatexResource;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use TheThunderTurner\FilamentLatex\Models\Latex;

class LatexResource extends Resource
{
    protected static ?string $model = Latex::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => \TheThunderTurner\FilamentLatex\Resources\LatexResource\Pages\ListLatexes::route('/'),
            'create' => \TheThunderTurner\FilamentLatex\Resources\LatexResource\Pages\CreateLatex::route('/create'),
            'edit' => \TheThunderTurner\FilamentLatex\Resources\LatexResource\Pages\EditLatex::route('/{record}/edit'),
        ];
    }
}
