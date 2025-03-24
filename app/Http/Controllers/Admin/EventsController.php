<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Doctrine\DBAL\Events;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventsController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $this->authorize('event-list', Event::class);

        return view('admin.events.index');
    }

    public function list()
    {
        $this->authorize('event-list', Event::class);

        $search = false;
        $group = false;
        $events = Event::query()
            ->where("end_date", ">", Carbon::today()->subWeek())
            ->when($group, function ($query, $group) {
                $query->whereIn('user_id', $group->user->pluck('id'));
            })
            ->orderBy('start_date', 'DESC')
            ->get();

        return view('admin.events.list', compact('events', 'search'));
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorize('event-create', Event::class);
        $event = $this->saveEvent($request);
        $status = "inserted";
        if ($event->rec_type === "none") {
            $status = "deleted";
        }

        return response()->json(
            [
                "action" => $status,
                "tid" => $event->id
            ]
        );
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $this->authorize('event-edit', Event::class);
        $this->saveEvent($request, $id);
        return response()->json(
            [
                "action" => "updated"
            ]
        );
    }

    /**
     * @param Request $request
     * @return array
     * @throws AuthorizationException
     */
    public function destroy(Request $request): array
    {
        $this->authorize('event-delete', Event::class);
        foreach ($request->all() as $item) {
            $event = Event::find($item[1]);
            if ($event->event_pid) {
                $event->rec_type = "none";
                $event->save();
            } else {
                $event->delete();
            }
            $this->deleteRelated($event);
        }

        return ['success' => true, 'message' => 'Event deleted'];
    }

    public function search(Request $request)
    {
        $search = $request->search;
        return view('admin.events.list', compact('search'));
    }

    /**
     * @param $event
     * @throws \Exception
     */
    private function deleteRelated($event): void
    {
        if ($event->event_pid && $event->event_pid !== "none") {
            Event::where("event_pid", $event->id)->delete();
        }
    }


    /**
     * @param Request $request
     * @param int|null $id
     * @return Event
     */
    private function saveEvent(Request $request, int $id = null): Event
    {
        if ($request->event_length === "null") {
            $request->event_length = null;
        }
        $event = $id ? Event::find($id) : new Event();
        $event->text = $request->text;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->rec_type = $request->rec_type;
        $event->event_length = $request->event_length;
        $event->event_pid = $request->event_pid;
        $event->color = $request->color;
        $event->save();

        return $event;
    }
}
