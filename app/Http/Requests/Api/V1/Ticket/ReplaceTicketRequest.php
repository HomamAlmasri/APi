<?php

namespace App\Http\Requests\Api\V1\Ticket;

use App\Http\Requests\Api\V1\BaseTicketRequest;
use Illuminate\Foundation\Http\FormRequest;

class ReplaceTicketRequest extends BaseTicketRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules =
            [
                'data.attributes.title'              => 'required|string',
                'data.attributes.description'        => 'required|string',
                'data.attributes.status'             => 'required|string|in:A,C,H,X',
                'data.relationships.author.data.id'  =>'required|string|exists:users,id',
                ];
        return $rules;
    }
}