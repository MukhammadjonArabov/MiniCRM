<?php

namespace App\Filament\Resources\Tickets\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required(),
                TextInput::make('subject')
                    ->required(),
                TextInput::make('message')
                    ->required(),
                Select::make('status')
                    ->options(['new' => 'New', 'in_progress' => 'In progress', 'processed' => 'Processed'])
                    ->default('new')
                    ->required(),
                Textarea::make('manager_reply')
                    ->columnSpanFull(),
                DateTimePicker::make('manager_reply_date'),
                Select::make('manager_id')
                    ->relationship('manager', 'name'),
            ]);
    }
}
