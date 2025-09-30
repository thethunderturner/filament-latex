<?php

namespace TheThunderTurner\FilamentLatex\Resources\FilamentLatex\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use TheThunderTurner\FilamentLatex\Models\FilamentLatex;
use TheThunderTurner\FilamentLatex\Resources\FilamentLatex\FilamentLatexResource;

class FilamentLatexTable
{
    public static function configure(Table $table): Table
    {
        $userModel = app(FilamentLatex::class)->getUserModel();

        return $table
            ->recordUrl(
                fn (Model $record): string => FilamentLatexResource::getUrl('document', ['record' => $record])
            )
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament-latex::filament-latex.column.id')),
                TextColumn::make('name')
                    ->searchable()
                    ->label(__('filament-latex::filament-latex.column.name')),
                ImageColumn::make('author_avatar')
                    ->label(__('filament-latex::filament-latex.column.author_avatar'))
                    ->visible(config('filament-latex.avatar-columns'))
                    ->circular()
                    ->tooltip(function ($record) use ($userModel) {
                        return $userModel::find($record->author_id)->name;
                    })
                    ->getStateUsing(function ($record) use ($userModel) {
                        return $userModel::find($record->author_id)->avatar_url;
                    }),
                ImageColumn::make('collaborators_avatars')
                    ->label(__('filament-latex::filament-latex.column.collaborators_avatars'))
                    ->visible(config('filament-latex.avatar-columns'))
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->getStateUsing(function ($record) use ($userModel) {
                        return $userModel::whereIn('id', $record->collaborators_id)->pluck('avatar_url')->toArray();
                    }),
                TextColumn::make('author.name')
                    ->label(__('filament-latex::filament-latex.column.author.name'))
                    ->visible(! config('filament-latex.avatar-columns'))
                    ->badge()
                    ->color('info'),
                TextColumn::make('collaborators')
                    ->label(__('filament-latex::filament-latex.column.collaborators'))
                    ->visible(! config('filament-latex.avatar-columns'))
                    ->badge()
                    ->limit(15)
                    ->color('info')
                    ->getStateUsing(function ($record) use ($userModel) {
                        return $userModel::whereIn('id', $record->collaborators_id)->pluck('name')->toArray();
                    }),
                TextColumn::make('deadline')
                    ->label(__('filament-latex::filament-latex.column.deadline'))
                    ->dateTime(),
                TextColumn::make('created_at')
                    ->label(__('filament-latex::filament-latex.column.created_at'))
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->label(__('filament-latex::filament-latex.column.updated_at'))
                    ->dateTime()
                    ->since(),
            ])
            ->filters([
                SelectFilter::make('author_id')
                    ->label(__('filament-latex::filament-latex.column.author.name'))
                    ->default(fn () => Auth::id())
                    ->options(fn () => $userModel::all()->pluck('name', 'id'))
                    ->native(false),
                SelectFilter::make('collaborators_id')
                    ->label(__('filament-latex::filament-latex.column.collaborators'))
                    ->options(fn () => $userModel::all()->pluck('name', 'id'))
                    ->query(function ($query, $data) {
                        if (! empty($data)) {
                            // Apply the filter for JSON column
                            foreach ($data as $id) {
                                $query->whereJsonContains('collaborators_id', $id);
                            }
                        }
                    })
                    ->multiple()
                    ->native(false),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->color('warning'),
                    DeleteAction::make()
                        ->visible(function ($record) {
                            // Only the creator can delete the record
                            return $record->author_id === Auth::id();
                        })
                        ->requiresConfirmation()
                        ->color('danger'),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
