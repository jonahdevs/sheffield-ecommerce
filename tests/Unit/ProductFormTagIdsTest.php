<?php

use App\Livewire\Forms\Admin\ProductForm;

test('ProductForm has tag_ids property', function () {
    $reflection = new ReflectionClass(ProductForm::class);

    expect($reflection->hasProperty('tag_ids'))->toBeTrue();

    $property = $reflection->getProperty('tag_ids');
    $docComment = $property->getDocComment();

    expect($docComment)->toContain('array<int, int>');
});

test('ProductForm validates tag_ids as nullable array', function () {
    $component = Mockery::mock('Livewire\Component');
    $form = new ProductForm($component, 'form');

    $rules = $form->rules();

    expect($rules)->toHaveKey('tag_ids')
        ->and($rules['tag_ids'])->toContain('nullable')
        ->and($rules['tag_ids'])->toContain('array');
});

test('ProductForm validates tag_ids elements as integers', function () {
    $component = Mockery::mock('Livewire\Component');
    $form = new ProductForm($component, 'form');

    $rules = $form->rules();

    expect($rules)->toHaveKey('tag_ids.*')
        ->and($rules['tag_ids.*'])->toContain('integer');
});

test('ProductForm has validation messages for tag_ids', function () {
    $component = Mockery::mock('Livewire\Component');
    $form = new ProductForm($component, 'form');

    $messages = $form->messages();

    expect($messages)->toHaveKey('tag_ids.array')
        ->and($messages)->toHaveKey('tag_ids.*.integer');
});
