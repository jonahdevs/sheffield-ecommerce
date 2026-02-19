<?php

namespace App\Livewire\Forms\Admin;

use App\Models\PickupStation;
use Livewire\Form;

class PickupStationForm extends Form
{
    public ?PickupStation $station = null;

    public string $name = '';
    public string $code = '';
    public ?int $county_id = null;
    public ?int $area_id = null;
    public string $address = '';
    public ?string $phone = null;
    public ?string $operating_hours = null;
    public ?float $latitude = null;
    public ?float $longitude = null;
    public bool $is_active = true;

    public function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'code' => 'required|unique:pickup_stations,code,' . $this->station?->id,
            'county_id' => 'required|exists:counties,id',
            'area_id' => 'nullable|exists:areas,id',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            'operating_hours' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'county_id.required' => 'Please select a county.',
            'county_id.exists' => 'The selected county is invalid.',
            'code.unique' => 'This station code is already taken.',
        ];
    }

    public function setStation(PickupStation $station): void
    {
        $this->station = $station;
        $this->fill($station->only('name', 'code', 'county_id', 'area_id', 'address', 'phone', 'operating_hours', 'latitude', 'longitude', 'is_active'));
    }

    public function store(): PickupStation
    {
        $this->validate();
        return PickupStation::create($this->only('name', 'code', 'county_id', 'area_id', 'address', 'phone', 'operating_hours', 'latitude', 'longitude', 'is_active'));
    }

    public function update(): PickupStation
    {
        $this->validate();
        $this->station->update($this->only('name', 'code', 'county_id', 'area_id', 'address', 'phone', 'operating_hours', 'latitude', 'longitude', 'is_active'));
        return $this->station->fresh();
    }
}
