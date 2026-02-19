<?php

namespace App\Livewire\Forms\Admin;

use App\Models\ShippingMethod;
use Livewire\Form;

class ShippingMethodForm extends Form
{
    public ?ShippingMethod $method = null;

    public string $name = '';
    public ?string $code = null;
    public ?string $description = null;
    public ?string $estimated_delivery = null;
    public bool $is_active = true;

    public function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'code' => 'nullable|string',
            'description' => 'nullable|string',
            'estimated_delivery' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'estimated_delivery.required' => 'Please provide an estimated delivery time e.g. 3-5 Business Days.',
        ];
    }

    public function setMethod(ShippingMethod $method): void
    {
        $this->method = $method;
        $this->fill($method->only('name', 'code', 'description', 'estimated_delivery', 'is_active'));
    }

    public function store(): ShippingMethod
    {
        $this->validate();
        return ShippingMethod::create($this->only('name', 'code', 'description', 'estimated_delivery', 'is_active'));
    }

    public function update(): ShippingMethod
    {
        $this->validate();
        $this->method->update($this->only('name', 'code', 'description', 'estimated_delivery', 'is_active'));
        return $this->method->fresh();
    }
}
