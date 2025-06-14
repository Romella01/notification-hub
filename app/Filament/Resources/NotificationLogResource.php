<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationLogResource\Pages;
use App\Models\NotificationDevice;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class NotificationLogResource extends Resource
{
    protected static ?string $model = NotificationDevice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Push Center';
    protected static ?string $navigationLabel = 'Notification Logs';
    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

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
                TextColumn::make('notification.body')
                    ->label('Message')
                    ->limit(30),
                TextColumn::make('device.user.name')
                    ->label('User'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string =>
                    match ($state) {
                        'queued'    => 'gray',
                        'sent'      => 'success',
                        'failed'    => 'danger',
                        default     => 'secondary',
                    }
                    ),
                TextColumn::make('error_message')
                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'queued'    => 'Queued',
                        'sent'      => 'Sent',
                        'failed'    => 'Failed',
                    ])
                    ->default(null)
                    ->attribute('status'),
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
            'index' => Pages\ListNotificationLogs::route('/'),
            'create' => Pages\CreateNotificationLog::route('/create'),
            'edit' => Pages\EditNotificationLog::route('/{record}/edit'),
        ];
    }
}
