<?php

namespace App\Http\Responses;

use App\Entities\Place;

class StarDestroyResponse extends GottaShitResponse
{
    /** @var Place */
    public $place;

    /** @var string */
    public $statusMessage;

    public function __construct(Place $place)
    {
        $this->place = $place;
        $this->statusMessage = trans('gottashit.star.deleted_star', ['place' => $place->name]);
    }

    protected function toJson()
    {
        return response()->json([
            'status' => 200,
            'status_message' => $this->statusMessage,
            'star_width' => $this->place->stars_progress_bar,
            'star_text' => $this->place->stars_average . ' / ' . trans('gottashit.star.votes') . ': '
                . $this->place->stars_amount,
        ]);
    }

    protected function toView()
    {
        return redirect($this->place->path)
            ->with('status', $this->statusMessage);
    }
}
