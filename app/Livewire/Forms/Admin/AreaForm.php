<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Area;
use Livewire\Form;

class AreaForm extends Form
{
    public ?Area $area = null;

    public string $name = '';
    public ?int $county_id = null;
    public ?int $shipping_zone_id = null;

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2',
            'county_id' => 'required|exists:counties,id',
            'shipping_zone_id' => 'nullable|exists:shipping_zones,id',
        ];
    }

    public function messages(): array
    {
        return [
            'county_id.required' => 'Please select a parent county.',
            'county_id.exists' => 'The selected county is invalid.',
        ];
    }

    public function setArea(Area $area): void
    {
        $this->area = $area;
        $this->fill($area->only('name', 'county_id', 'shipping_zone_id'));
    }

    public function store(): Area
    {
        $this->validate();
        return Area::create($this->only('name', 'county_id', 'shipping_zone_id'));
    }

    public function update(): Area
    {
        $this->validate();
        $this->area->update($this->only('name', 'county_id', 'shipping_zone_id'));
        return $this->area->fresh();
    }
}
