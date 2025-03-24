<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Resources\ColorResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\UserResource;
use App\Models\Color;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class EventDataController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|void
     */
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $colors = Color::all();
        $eventsQuery = Event::query()
            ->where("start_date", "<", $request->to)
            ->where("end_date", ">=", $request->from);

        if($request->search) {
            $eventsQuery->where("text", "LIKE", '%'.$request->search.'%');
        }
        $events = $eventsQuery->get();
        return EventResource::collection($events)->additional(
                [
                    'collections' =>
                        ['colors' => ColorResource::collection($colors)]
                ]
            );
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function show(Request $request): AnonymousResourceCollection
    {
        $user = User::find($request->id);
        $group = false;

        $simpleUser = false;
        $roles = $user->getRoleNames();

        if (!($roles->contains('Admin') || $roles->contains('super-admin'))) {
            $users = User::where('id', '=', $user->id)->get();
            $simpleUser = true;
        } else {
            $superAdmin = User::role('super-admin')->get()->first();
            $users = User::where('id', '<>', $superAdmin->id)->orderBy('name', 'ASC')->get();
        }

        $eventsQuery = Event::query()
            ->where("start_date", "<", $request->to)
            ->where("end_date", ">=", $request->from)
            ->when(
                $group,
                function ($query, $group) {
                    $query->whereIn('user_id', $group->user->pluck('id'));
                }
            )
            ->when(
                $simpleUser,
                function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id);
                }
            );
        $events = $eventsQuery->get();

        return EventResource::collection($events)->additional(
            [
                'collections' =>
                    ['users' => UserResource::collection($users)]
            ]
        );
    }

    public function users()
    {
        $users = User::role('nurse')->get();
        return UserResource::collection($users);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
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
        $event = $this->saveEvent($request, $id);
        $this->deleteRelated($event);
        return response()->json(
            [
                "action" => "updated"
            ]
        );
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $event = Event::find($id);

        // delete the modified instance of the recurring series
        if ($event->event_pid) {
            $event->rec_type = "none";
            $event->save();
        } else {
            // delete a regular instance
            $event->delete();
        }
        $this->deleteRelated($event);
        return response()->json(
            [
                "action" => "deleted"
            ]
        );
    }

    /**
     * @param $event
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
        if ($request->event_pid === "null") {
            $request->event_pid = null;
        }
        $event = $id ? Event::find($id) : new Event();
        $event->text = $request->text;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->rec_type = $request->rec_type;
        $event->event_length = $request->event_length;
        $event->event_pid = $request->event_pid;
        $event->color_id = $request->color_id;
        $event->save();

        return $event;
    }
}
