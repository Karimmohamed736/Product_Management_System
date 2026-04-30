<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name'      => 'required|array',
            'name.ar'   => 'required|string|max:255',
            'name.en'   => 'required|string|max:255',
            'status'    => 'required|boolean',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
            function($attribute, $value, $fail){
                // Prevent setting the category as its own parent
                if ($value && $value==$this->route('category')?->id) {
                    $fail('Category cannot be its own parent.');
                }
            }
        ];
    }
}
