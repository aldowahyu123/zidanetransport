<?php

namespace App\Filament\Resources;

use App\Models\Service;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\ServiceResource\Pages; 
use Filament\Forms\Components\Textarea;


class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('service_name')->required()->label('Tujuan'),
            Textarea::make('description')->label('Description'),
            TextInput::make('price_multiplier')
                ->numeric()
                ->step(0.01)
                ->required()
                ->label('Price Multiplier'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('service_name')->label('Tujuan')->sortable()->searchable(),
            TextColumn::make('description')->label('Description')->wrap(),
            TextColumn::make('price_multiplier')->label('Price Multiplier')->sortable(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
