<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('group-list', Group::class);
        $groups = Group::all();

        return view('admin.groups.index', compact('groups'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('group-create', Group::class);
        return view('admin.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('group-create', Group::class);
        $this->validate(
            $request,
            [
                'name' => 'required|unique:groups,name'
            ]
        );
        Group::create(['name' => $request->input('name')]);

        return redirect()->route('admin.groups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $this->authorize('group-list', Group::class);
        $users = User::where('group_id', $id)->get();

        $group = Group::findOrFail($id);

        return view('admin.groups.show', compact('group', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $this->authorize('group-edit', Group::class);
        $group = Group::findOrFail($id);
        return view('admin.groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->authorize('group-edit', Group::class);
        $group = Group::findOrFail($id);
        $group->update($request->all());

        return redirect()->route('admin.groups.index');

    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('group-delete', Group::class);

        $group = Group::find($id);
        $users = $group->user();
        if($users->count() > 0) {
            return redirect()->back()->with('errors', 'quickadmin.groups.fields.user_error');
        }
        $group->delete();
        return redirect()->route('admin.groups.index');
    }
}
