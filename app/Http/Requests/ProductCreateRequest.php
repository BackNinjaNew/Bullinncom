<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|unique:products,code|numeric|digits_between:3,10',
            'category' => 'required',
            'name' => 'required|min:3|max:50',
            'description' => 'required|min:3|max:2000',
            'brand' => 'required|min:3|max:50',
            'stock' => 'required|numeric|digits_between:1,20',
            'price' => 'required|numeric|digits_between:1,10',
            'image' => 'required|image|mimes:bmp,gif,jpg,jpeg,png,svg',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'El campo código es obligatorio.',
            'code.unique' => 'El código ya ha sido registrado.',
            'code.digits_between' => 'El campo código debe tener entre 3 y 10 dígitos.',
            'category.required' => 'El campo categoria es obligatorio.',
            'name.required' => 'El campo nombre es obligatorio.',
            'name.min' => 'El campo nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El campo nombre no debe tener más de 50 caracteres.',
            'description.required' => 'El campo descripción es obligatorio.',
            'description.min' => 'El campo descripción debe tener al menos 3 caracteres.',
            'description.max' => 'El campo descripción no debe tener más de 50 caracteres.',
            'brand.required' => 'El campo marca es obligatorio.',
            'brand.min' => 'El campo marca debe tener al menos 3 caracteres.',
            'brand.max' => 'El campo marca no debe tener más de 50 caracteres.',
            'stock.required' => 'El campo existencias es obligatorio.',
            'stock.digits_between' => 'El campo existencias debe tener entre 3 y 20 dígitos.',
            'price.required' => 'El campo precio es obligatorio.',
            'price.digits_between' => 'El campo precio debe tener entre 3 y 10 dígitos.',
            'image.required' => 'El campo imagen es obligatorio.',
            'image.image' => 'El campo imagen debe ser una imagen.',
            'image.mimes' => 'El campo imagen debe ser un archivo de tipo: bmp, gif, jpg, jpeg, png, svg.',
        ];
    }
}
