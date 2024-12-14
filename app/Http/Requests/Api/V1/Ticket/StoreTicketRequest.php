<?php

namespace App\Http\Requests\Api\V1\Ticket;

use App\Http\Requests\Api\V1\BaseTicketRequest;
use App\Persmisions\V1\Abilities;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends BaseTicketRequest
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
        $authorId = $this->routeIs('tickets.store') ? 'data.relationships.author.data.id' : 'author' ;
       $rules =
        [
            'data.attributes.title'              => 'required|string',
            'data.attributes.description'        => 'required|string',
            'data.attributes.status'             => 'required|string|in:A,C,H,X',
            $authorId                            => 'required|integer|exists:users,id',
        ];
       $user = $this->user();

            if($user->tokenCan(Abilities::CreateOwnTicket)) {
            $rules[$authorId]  .= '|size:'. $user->id;
        }
        return $rules;
    }
//    public function messages(): array
//    {
//        return [
//            'data.relationships.author.data.id' => 'Wrong User ID'
//        ];
//    }
    protected function prepareForValidation()
    {
        if ($this->routeIs('authors.tickets.store')) {
            $this->merge([
                'author' => $this->route('author'),
            ]);
        }
    }

}
