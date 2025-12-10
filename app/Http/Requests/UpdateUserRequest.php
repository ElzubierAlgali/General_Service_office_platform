<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $user = $this->route('user');
        $userId = $user instanceof \App\Models\User ? $user->id : $user;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($userId),
            ],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'organization_id' => ['nullable', 'exists:organizations,id'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'حقل الاسم مطلوب.',
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.unique' => 'البريد الإلكتروني مستخدم مسبقاً.',
            'email.email' => 'يرجى إدخال عنوان بريد إلكتروني صحيح.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'organization_id.exists' => 'المنظمة المحددة غير موجودة.',
            'roles.array' => 'يجب أن تكون الصلاحيات مصفوفة.',
            'roles.*.exists' => 'أحد الصلاحيات المحددة غير موجود.',
        ];
    }
}

