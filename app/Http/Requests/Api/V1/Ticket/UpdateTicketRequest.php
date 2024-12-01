<?php

namespace App\Http\Requests\Api\V1\Ticket;

use App\Http\Requests\Api\V1\BaseTicketRequest;

class UpdateTicketRequest extends BaseTicketRequest
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
        $rules =
            [
                'data.attributes.title'              => 'sometimes|string',
                'data.attributes.description'        => 'sometimes|string',
                'data.attributes.status'             => 'sometimes|string|in:A,C,H,X',
                'data.relationships.author.data.id'  => 'sometimes|string|exists:users,id',
            ];
        return $rules;

    }
}
