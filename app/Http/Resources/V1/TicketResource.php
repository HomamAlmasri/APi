<?php

namespace App\Http\Resources\V1;

use App\Enums\TicketStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
            return [
                'type'=> 'Ticket',
                'id'  => $this->id,
                'attributes'=>
                [
                    'title'         => $this->title,
                    'description'   => $this->when(
                        !$request->routeIs(['tickets.index',' authors.tickets.index']),
                        $this->description
                    ),
                    'status'        => $this->status,
                    'createdAt'     => $this->created_at,
                    'updatedAt'     => $this->updated_at,
                ],

                'relationships'=>
                [
                    'author'=>
                    [
                        'data'=>
                        [
                            'type'=> 'user',
                            'UserId'=> $this->user_id,
                        ],
                        'includes'=> UserResource::make($this->whenLoaded('author')),
                        'links'=>
                        [
                            'self'=> 'todo'
                        ]
                    ]
                ],
                'links'=>
                [
                    [
                        'self'=>route('tickets.show',['ticket'=> $this->id])
                    ]
                ],
                'statuses'=>TicketStatus::values(),
            ];
    }
}
