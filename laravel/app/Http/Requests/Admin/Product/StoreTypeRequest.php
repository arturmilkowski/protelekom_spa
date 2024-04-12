<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StoreTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(['slug' => Str::slug($this->name)]);
        $this['hide'] = filter_var($this->hide, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required'],
            'condition_id' => ['required', 'min:1'], // 'numeric', 'max:99'
            'slug' => ['required', 'max:255'],
            'name' => ['required', 'max:255', Rule::unique('types', 'name')->ignore($this->type)],
            'price' => ['required', 'numeric', 'min:1', 'max:9999.99'],
            'promo_price' => ['sometimes', 'numeric', 'min:0.00', 'max:9999.99'],
            'quantity' => ['required', 'numeric', 'min:0', 'max:255'],
            'hide' => ['required', 'boolean'], // 'sometimes',
            'description' => [],
            'img' => ['sometimes', 'image'], // 'file',
        ];
    }
}
