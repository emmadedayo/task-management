<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'task_name' => 'required|string|max:255',
            'task_description' => 'required|string',
            'task_priority' => 'required|in:LOW,MEDIUM,HIGH',
            'task_start_date' => 'required|date',
            'task_due_date' => 'required|date',
            'user_id' => 'required|integer',
            'task_status' => 'required|in:PENDING,IN-PROGRESS,BLOCKER,COMPLETED',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'task_name.required' => 'Task name is required',
            'task_description.required' => 'Task description is required',
            'task_priority.required' => 'Task priority is required',
            'task_start_date.required' => 'Task start date is required',
            'task_due_date.required' => 'Task due date is required',
            'task_status.required' => 'Task status is required',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        throw new HttpResponseException(ApiResponse::error($validator->errors()->first(), 422));
    }
}
