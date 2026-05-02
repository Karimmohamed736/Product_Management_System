<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'            => 'required|array',
            'title.ar'         => 'required|string|max:255',
            'title.en'         => 'required|string|max:255',
            'description'      => 'nullable|string',
            'description.ar'   => 'nullable|string',
            'description.en'   => 'nullable|string',
            'sku'              => 'required|string|max:100|unique:products,sku,' . $this->route('product'),
            'price'            => 'required|numeric|min:0',
            'sale_price'       => 'nullable|numeric|min:0|lt:price',
            'stock'            => 'required|integer|min:0',
            'brand'            => 'nullable|string|max:255',
            'status'           => 'required|boolean',
            'category_id'      => 'required|exists:categories,id',
            'main_image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery'          => 'nullable|array',
            'gallery.*'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'files'            => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'files.*'          => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ];
    }
}
