<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Number;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?int $navigationSort = 4;

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
    private static $status = [
        'new' => 'New',
        'processing' => 'Processing',
        'shipped' => 'Shipped',
        'delivered' => 'Delivered',
        'canceled' => 'Cancelled',
    ];
    private static $currency = [
        'usd' => 'USD',
        'khr' => 'KHR',
        'eur' => 'EUR',
    ];
    private static $shippingMethod = [
        'fedex' => 'FedEx',
        'ups' => 'UPS',
        'dhl' => 'DHL',
        'usps' => 'USPS',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Order Information')->schema([
                        Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('payment_method')
                            ->options(self::$paymentMethod)->required(),

                        Select::make('payment_status')
                            ->options(self::$paymentStatus)->default('pending')->required(),

                        ToggleButtons::make('status')
                            ->inline()
                            ->default('new')
                            ->required()
                            ->options(self::$status)
                            ->colors([
                                'new' => 'info',
                                'processing' => 'warning',
                                'shipped' => 'success',
                                'delivered' => 'success',
                                'canceled' => 'danger',
                            ])
                            ->icons([
                                'new' => 'heroicon-m-sparkles',
                                'processing' => 'heroicon-m-arrow-path',
                                'shipped' => 'heroicon-m-truck',
                                'delivered' => 'heroicon-m-check-badge',
                                'canceled' => 'heroicon-m-x-circle',
                            ]),

                        Select::make('currency')
                            ->options(self::$currency)
                            ->required()
                            ->default('usd'),

                        Select::make('shipping_method')
                            ->options(self::$shippingMethod),

                        Textarea::make('notes')->columnSpanFull(),
                    ])->columns(2),

                    Section::make('Order Items')->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->distinct()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->columnSpan(4)
                                    ->reactive()
                                    ->afterStateUpdated(fn($state, Set $set) => $set('unit_price', Product::find($state)?->price ?? 0))
                                    ->afterStateUpdated(fn($state, Set $set) => $set('total_price', Product::find($state)?->price ?? 0)),

                                TextInput::make('quantity')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required()
                                    ->columnSpan(2)
                                    ->reactive()
                                    ->afterStateUpdated(fn($state, Set $set, Get $get) => $set('total_price', $state * $get('unit_price'))),

                                TextInput::make('unit_price')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->prefix('$')
                                    ->columnSpan(3),

                                TextInput::make('total_price')
                                    ->numeric()
                                    ->required()
                                    ->disabled()
                                    ->prefix('$')
                                    ->dehydrated()
                                    ->columnSpan(3),
                            ])->columns(12),

                        Placeholder::make('grand_total_placeholder')
                            ->label('Grand Total')
                            ->content(function (Get $get, Set $set) {
                                $total = 0;
                                if (!$repeaters = $get('items')) {
                                    return $total;
                                }

                                foreach ($repeaters as $item) {
                                    $total += $item['total_price'];
                                }

                                $set('grand_total', $total);
                                return Number::currency($total);
                            }),

                        Hidden::make('grand_total')->default(0),
                    ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->rowIndex(),
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->label("Customer"),

                TextColumn::make('grand_total')
                    ->numeric()
                    ->sortable()
                    ->money('USD'),

                TextColumn::make('payment_method')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => self::$paymentMethod[$state] ?? $state),

                TextColumn::make('payment_status')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => self::$paymentStatus[$state] ?? $state),

                TextColumn::make('currency')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => self::$currency[$state] ?? $state),

                TextColumn::make('shipping_method')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => self::$shippingMethod[$state] ?? $state),

                SelectColumn::make('status')
                    ->options(self::$status)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->since()
                    ->dateTimeTooltip()
                // ->dateTime('d M Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
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
            AddressRelationManager::class,
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string | array | null
    {
        return static::getModel()::count() > 10 ? 'danger' : 'success';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
