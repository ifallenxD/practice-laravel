<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use App\Models\State;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Indicator;
use Carbon\Carbon;
use Filament\Tables\Enums\FiltersLayout;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Employee Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identity')
                    ->description('Input name details')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('middle_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                    ])->columns(3),
                Forms\Components\Section::make('Location')
                    ->schema([
                        Forms\Components\Section::make('')
                        ->schema([
                            Forms\Components\Select::make('country_id')
                                ->relationship(name: 'country', titleAttribute: 'name')
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(function (Set $set) {
                                    $set('state_id', null);
                                    $set('city_id', null);
                                })
                                ->required(),
                            Forms\Components\Select::make('state_id')
                                ->label('State')
                                ->options(fn (Get $get): Collection => State::query()
                                    ->where('country_id', $get('country_id'))
                                    ->pluck('name', 'id'))
                                ->afterStateUpdated(fn (Set $set) => $set('city_id', null))
                                ->searchable()
                                ->live()
                                ->preload()
                                ->required(),
                            Forms\Components\Select::make('city_id')
                                ->label('City')
                                ->options(fn (Get $get): Collection => City::query()
                                    ->where('state_id', $get('state_id'))
                                    ->pluck('name', 'id'))
                                ->searchable()
                                ->live( )
                                ->preload()
                                ->required(),
                            Forms\Components\Select::make('department_id')
                                ->relationship(name: 'department', titleAttribute: 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                        ])->columns(4),
                        Forms\Components\Section::make('')
                        ->schema([
                            Forms\Components\TextInput::make('address')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(3),
                            Forms\Components\TextInput::make('zip_code')
                                ->required()
                                ->maxLength(4)
                                ->columnSpan(1),
                        ])->columns(4),
                    ])->compact(),
                Forms\Components\Section::make('Dates')
                    ->schema([
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->format('Y-m-d')
                            ->seconds(false)
                            ->native(false)
                            ->required(),
                        Forms\Components\DatePicker::make('date_hired')
                            ->format('Y-m-d')
                            ->seconds(false)
                            ->native(false)
                            ->required()
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country.name')
                    ->label('Country')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->label('State')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->label('City')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->label('Department')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_hired')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('department')
                    ->label('By Department')
                    ->indicator('Department')
                    ->relationship('department', 'name'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    // ...
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                 
                        if ($data['from'] ?? null) {
                            $indicators[] = Indicator::make('Created from ' . Carbon::parse($data['from'])->toFormattedDateString())
                                ->removeField('from');
                        }
                 
                        if ($data['until'] ?? null) {
                            $indicators[] = Indicator::make('Created until ' . Carbon::parse($data['until'])->toFormattedDateString())
                                ->removeField('until');
                        }
                 
                        return $indicators;
                    })->columnSpan(2)->columns(2)
                ], layout: FiltersLayout::AboveContent)->filtersFormColumns(3)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistSection::make('Identity')
                    ->label('Indentity Details')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Full Name')
                            ->state( function (Employee $record): string {
                                return $record->first_name . ' ' . $record->middle_name . ' ' . $record->last_name;
                            })->columnSpanFull(),

                            TextEntry::make('first_name')->columnSpan(1),
                            TextEntry::make('middle_name')->columnSpan(1),
                            TextEntry::make('last_name')->columnSpan(1),
                    ])->columns(3),  
                InfolistSection::make('Location')
                    ->label('Location Details')
                    ->schema([
                        TextEntry::make('address')->columnSpan(2),
                        TextEntry::make('city.name')->columnSpan(1),
                        TextEntry::make('state.name')->columnSpan(1),
                        TextEntry::make('country.name')->columnSpan(1),
                        TextEntry::make('department.name')->columnSpan(1),
                        TextEntry::make('zip_code')->columnSpan(1),
                    ])->columns(4),   
                InfolistSection::make('Dates')
                    ->label('Dates Details')
                    ->schema([
                        TextEntry::make('date_of_birth'),
                        TextEntry::make('date_hired'),
                        TextEntry::make('created_at'),
                        TextEntry::make('updated_at'),
                    ])->columns(2),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            // 'view' => Pages\ViewEmployee::route('/{record}'),
            // 'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
