<?php

namespace App\Http\Requests;

use App\Rules\Name;
use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = optional($this->route('user'))->id;

        return [
            'name' => ['required', 'min:3', new Name],
            'email' => ['required', 'max:50', 'email', 'unique:users,email,' . $userId . ',id'],
            'password' => ['nullable', 'min:6', 'confirmed'],
            'avatar' => [empty($userId) ? 'required' : 'nullable', 'image', 'max:2000', 'dimensions:min_width=250'],
            'roles' => ['present', 'filled', 'array'],
        ];
    }
}
