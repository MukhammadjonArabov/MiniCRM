<?php

namespace App\Filament\Resources\Tickets\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TicketInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('customer.name')
                    ->label('Customer'),
                TextEntry::make('subject'),
                TextEntry::make('message'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('manager_reply')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('manager_reply_date')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('manager.name')
                    ->label('Manager')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
