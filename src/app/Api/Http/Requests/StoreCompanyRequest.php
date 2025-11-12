<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class StoreCompanyRequest extends FormRequest
{

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:256',
            'edrpou' => 'required|string|max:10',
            'address' => 'required|string',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Поле є обов’язковим.',
            'name.max' => 'Назва компанії не може бути довшою за 256 символів.',
            'edrpou.required' => 'Поле є обов’язковим.',
            'edrpou.max' => 'Код ЄДРПОУ повинен містити не більше 10 символів.',
            'address.required' => 'Поле є обов’язковим.',
        ];
    }

    /**
     * @param Validator $validator
     * @return JsonResponse
     */
    protected function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
