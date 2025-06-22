<?php

namespace App\Filament\Resources;

use App\Models\Booking;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\BookingResource\Pages;
use Filament\Tables\Actions\DeleteBulkAction;


class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Relasi ke tabel `users`
            Select::make('user_id')
                ->relationship('user', 'username') // Sesuaikan dengan kolom `username` di tabel `users`
                ->label('User')
                ->required(),

            // Relasi ke tabel `services`
            Select::make('service_id')
                ->relationship('service', 'service_name') // Sesuaikan dengan kolom yang benar
                ->label('Tujuan')
                ->required(),

            DatePicker::make('booking_date')
                ->label('Tanggal Booking')
                ->required(),

            Select::make('vehicle_id')
                ->relationship('vehicle', 'name') // Relasi ke `vehicles`
                ->label('Kendaraan')
                ->required(),

            Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'active' => 'Active',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                ])
                ->default('pending')
                ->required(),


        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('user.username')->label('Customer'), // Relasi ke `users`
            TextColumn::make('service.service_name')->label('Tujuan'), // Kolom yang benar di `services`
            TextColumn::make('booking_date')
                ->label('Tanggal Booking')
                ->date(),
            TextColumn::make('pickup_date')
                ->label('Tanggal Penjemputan')
                ->date(),

            TextColumn::make('end_date')
                ->label('Tanggal Selesai')
                ->date(),

            TextColumn::make('vehicle.name')
                ->label('Kendaraan'),

            TextColumn::make('status')
                ->label('Status Pembayaran')
                ->sortable()
                ->searchable(),
        ])
        ->bulkActions([
            DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
