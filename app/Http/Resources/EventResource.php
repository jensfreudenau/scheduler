<?php

namespace App\Http\Resources;

use App\Models\Color;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class EventResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array|JsonResponse
     */
    public function toArray($request)
    {
        $color = Color::where('id', $this->color_id)->first();
        $agenda = '#000';
        if($request->agenda) {
            $text = '';
            $agenda = $color['text'];
        }
        else {
            $text = $color['text'];
        }

        return [
            'id' => $this->id,
            'text' => $this->text,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'rec_type' => $this->rec_type,
            'event_length' => $this->event_length,
            'event_pid' => $this->event_pid,
            'color_id' => $this->color_id,
            'color' => $text,
            'agenda' => $agenda,
        ];

    }
}
