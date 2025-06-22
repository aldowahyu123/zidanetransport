<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use Filament\Resources\Resource;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Vehicles';
    protected static ?string $pluralLabel = 'Vehicles';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Nama Kendaraan')
                ->required(),
            TextInput::make('type')
                ->label('Jenis Kendaraan')
                ->required(),

            Toggle::make('status')
                ->label('Available Status')
                ->inline(false)
                ->default(true),

            TextInput::make('base_price')
                ->label('Base Price')
                ->numeric()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->label('Nama Kendaraan')->searchable(),
                TextColumn::make('type')->label('Jenis Kendaraan')->searchable(),
                TextColumn::make('base_price')->label('Base Price'),
                IconColumn::make('status')
                    ->label('Available')
                    ->boolean(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
