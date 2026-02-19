<?php

namespace App\Livewire\Forms\Admin;

use App\Models\County;
use Livewire\Form;

class CountyForm extends Form
{
    public ?County $county = null;

    public string $name = '';
    public ?string $code = null;
    public ?int $shipping_zone_id = null;

    public function rules(): array
    {
        return [
            'name' => 'required|unique:counties,name,' . $this->county?->id,
            'code' => 'nullable|unique:counties,code,' . $this->county?->id,
            'shipping_zone_id' => 'required|exists:shipping_zones,id',
        ];
    }

    public function messages(): array
    {
        return [
            'shipping_zone_id.required' => 'Please select a shipping zone.',
            'shipping_zone_id.exists' => 'The selected zone is invalid.',
        ];
    }

    public function setCounty(County $county): void
    {
        $this->county = $county;
        $this->fill($county->only('name', 'code', 'shipping_zone_id'));
    }

    public function store(): County
    {
        $this->validate();
        return County::create($this->only('name', 'code', 'shipping_zone_id'));
    }

    public function update(): County
    {
        $this->validate();
        $this->county->update($this->only('name', 'code', 'shipping_zone_id'));
        return $this->county->fresh();
    }
}
