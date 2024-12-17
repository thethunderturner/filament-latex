<?php

namespace TheThunderTurner\FilamentLatex\Resources;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use TheThunderTurner\FilamentLatex\Models\FilamentLatex;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages\CreateFilamentLatex;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages\EditFilamentLatex;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages\ListFilamentLatexes;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatexResource\Pages\ViewFilamentLatex;

class FilamentLatexResource extends Resource
{
    protected static ?string $model = FilamentLatex::class;

    /**
     * The view(...) in this case is the default view for the navigation icon.
     */
    public static function getNavigationIcon(): string | Htmlable | null
    {
        return config('filament-latex.navigation-icon') ?? view('filament-latex::svg.latex');
    }

    public static function getNavigationLabel(): string
    {
        return config('filament-latex.navigation-label') ?? parent::getNavigationLabel();
    }

    public static function getNavigationGroup(): ?string
    {
        return config('filament-latex.navigation-group') ?? parent::getNavigationGroup();
    }

    public static function form(Form $form): Form
    {
        $userModel = app(FilamentLatex::class)->getUserModel();

        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Document Title')
                            ->required(),
                        DateTimePicker::make('deadline')
                            ->required()
                            ->native(false)
                            ->placeholder('DD-MM-YYYY HH:MM')
                            ->suffixIcon('heroicon-m-calendar')
                            ->format('Y-m-d H:i:s')
                            ->displayFormat('d-m-Y H:i'),
                        Select::make('author_id')
                            ->label('Author')
                            ->default(fn () => Auth::id())
                            ->options(fn () => $userModel::all()->pluck('name', 'id'))
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        Select::make('collaborators_id')
                            ->label('Collaborators')
                            ->multiple()
                            ->options(fn () => $userModel::all()->pluck('name', 'id'))
                            ->searchable(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        $userModel = app(FilamentLatex::class)->getUserModel();

        return $table
            ->recordUrl(
                fn (Model $record): string => FilamentLatexResource::getUrl('document', ['record' => $record])
            )
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),
                TextColumn::make('name'),
                TextColumn::make('deadline')
                    ->dateTime(),
                TextColumn::make('created_at')
                    ->dateTime(),
                ImageColumn::make('author_avatar')
                    ->label('Author')
                    ->visible(config('filament-latex.avatar-columns'))
                    ->circular()
                    ->tooltip(function ($record) use ($userModel) {
                        return $userModel::find($record->author_id)->name;
                    })
                    ->getStateUsing(function ($record) use ($userModel) {
                        return $userModel::find($record->author_id)->avatar_url;
                    }),
                ImageColumn::make('collaborators_avatars')
                    ->label('Collaborators')
                    ->visible(config('filament-latex.avatar-columns'))
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->getStateUsing(function ($record) use ($userModel) {
                        return $userModel::whereIn('id', $record->collaborators_id)->pluck('avatar_url')->toArray();
                    }),
                TextColumn::make('author.name')
                    ->label('Author')
                    ->visible(! config('filament-latex.avatar-columns'))
                    ->badge()
                    ->color('info'),
                TextColumn::make('collaborators')
                    ->label('Collaborators')
                    ->visible(! config('filament-latex.avatar-columns'))
                    ->badge()
                    ->color('info')
                    ->getStateUsing(function ($record) use ($userModel) {
                        return $userModel::whereIn('id', $record->collaborators_id)->pluck('name')->toArray();
                    }),
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
