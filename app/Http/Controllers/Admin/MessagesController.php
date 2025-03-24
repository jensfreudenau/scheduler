<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class MessagesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $messages = Message::all();

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.messages.create');
    }

    /**
     * @param Request $request
     * @return Redirector
     * @throws ValidationException
     */
    public function store(Request $request): Redirector
    {
        $this->validate(
            $request,
            [
                'text' => 'required'
            ]
        );
        $requests = $request->all();
        $requests['user_id'] = Auth::user()->id;
        Message::create($requests);

        return redirect('admin/messages');
    }

    /**
     * @param Message $message
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Message $message)
    {
//        if (!Gate::allows('message_access')) {
//            return abort(401);
//        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * @param Message $message
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Message $message)
    {
//        if (!Gate::allows('message_edit')) {
//            return abort(401);
//        }

        return view('admin.messages.edit', compact('message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Message $message
     * @return Redirector
     */
    public function update(Request $request, Message $message): Redirector
    {
        if (!Gate::allows('message_edit')) {
            return abort(401);
        }
        $requests = $request->all();
        $requests['user_id'] = Auth::user()->id;
        $message->update($requests);

        return redirect('admin/messages');
    }

    /**
     * @param Message $message
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|Redirector|void
     * @throws \Exception
     */
    public function destroy(Message $message)
    {
        if (!Gate::allows('message_delete')) {
            return abort(401);
        }
        $message->delete();
        return redirect('admin/messages');
    }
}
