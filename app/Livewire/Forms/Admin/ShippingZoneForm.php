<?php

namespace App\Livewire\Forms\Admin;

use App\Models\ShippingZone;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ShippingZoneForm extends Form
{
    public ?ShippingZone $zone = null;
    public string $name = '';
    public string $code = '';
    public ?string $description = null;
    public bool $is_active = false;

    public function rules(): array
    {
        $zoneId = $this->zone?->id;

        return [
            "name" => 'required|min:3',
            "code" => "required|unique:shipping_zones,code," . $zoneId,
            "description" => "nullable|string",
            'is_active' => 'boolean'
        ];
    }

    public function setZone(ShippingZone $zone)
    {
        $this->zone = $zone;
        $this->fill($zone->toArray());
    }

    public function store()
    {
        $this->validate();
        $data = $this->prepareData();

        return ShippingZone::create($data);
    }


    public function update()
    {
        $this->validate();

        $data = $this->prepareData();
        $this->zone->update($data);
        return $this->zone;
    }

    public function prepareData()
    {
        $data = $this->except(['zone']);
        return $data;
    }

}
