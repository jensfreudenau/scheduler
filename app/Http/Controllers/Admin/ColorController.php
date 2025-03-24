<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class ColorController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $colors = Color::all();

        return view('admin.colors.index', compact('colors'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate(
            $request,
            [
                'text' => 'required'
            ]
        );


        Color::create($request->all());

        return redirect('admin/colors');
    }

    /**
     * @param Color $color
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Color $color)
    {
        return view('admin.colors.show', compact('color'));
    }

    /**
     * @param Color $color
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Color $color)
    {

        return view('admin.colors.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Color $color
     */
    public function update(Request $request, Color $color)
    {
        $requests = $request->all();
        $requests['user_id'] = Auth::user()->id;
        $color->update($requests);

        return redirect('admin/colors');
    }

    /**
     * @param Color $color
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|Redirector|void
     * @throws \Exception
     */
    public function destroy(Color $color)
    {
        if (!Gate::allows('colors-delete')) {
            return abort(401);
        }
        $events = $color->events();
        if ($events->count() > 0) {
            return redirect()->back()->with('errors', 'quickadmin.events.fields.user_error');
        }
        $color->delete();
        return redirect('admin/colors');
    }
}
