<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\OrderResource;
use Filament\Resources\RelationManagers\RelationManager;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';
    private static $status = [
        'new' => 'New',
        'processing' => 'Processing',
        'shipped' => 'Shipped',
        'delivered' => 'Delivered',
        'canceled' => 'Cancelled',
    ];
    private static $paymentMethod = [
        'ba' => 'Bank Account',
        'cod' => 'Cash On Delivery',
        'cc' => 'Credit Card',
        'stripe' => 'Stripe',
        'check' => 'Check',
    ];
    private static $paymentStatus = [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'failed' => 'Failed',
    ];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->searchable(),
                TextColumn::make('grand_total')
                    ->numeric()
                    ->sortable()
                    ->money('USD'),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn($state) => self::$status[$state] ?? $state)
                    ->color(fn(string $state): string => match ($state) {
                        'new' => 'info',
                        'processing' => 'warning',
                        'shipped' => 'success',
                        'delivered' => 'success',
                        'canceled' => 'danger',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'new' => 'heroicon-m-sparkles',
                        'processing' => 'heroicon-m-arrow-path',
                        'shipped' => 'heroicon-m-truck',
                        'delivered' => 'heroicon-m-check-badge',
                        'canceled' => 'heroicon-m-x-circle',
                    })
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => self::$paymentMethod[$state] ?? $state),

                TextColumn::make('payment_status')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->formatStateUsing(fn($state) => self::$paymentStatus[$state] ?? $state),
                TextColumn::make('created_at')
                    ->since()
                    ->dateTimeTooltip()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Action::make('View Order')
                ->url(fn(Order $record):string => OrderResource::getUrl('view',['record' => $record]))
                ->color('info')
                ->icon('heroicon-m-eye'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
