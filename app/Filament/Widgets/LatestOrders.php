<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 2;
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

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->rowIndex()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->sortable()
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
            ->actions([
                Action::make('View Order')
                    ->url(fn(Order $record): string => OrderResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-s-eye'),
            ]);
    }
}
