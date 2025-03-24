<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('user-list', User::class);
        $superAdmin = User::role('super-admin')->get()->first();
        $users = User::where('id', '<>', $superAdmin->id)->orderBy('group_id', 'DESC')->paginate(10);
        return view('admin.users.index', compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('user-create', User::class);
        $roles = Role::where('name', '<>', 'super-admin')->get()->pluck('name', 'id')->prepend('Please select', '');
        $groups = Group::get()->pluck('name', 'id')->prepend('Please select', '');

        return view('admin.users.create', compact('roles', 'groups'));
    }

    /**
     * @param StoreUsersRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreUsersRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('user-create', User::class);

        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'roles' => 'required',
                'group_id' => 'required'
            ]
        );

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing User.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('user-edit', User::class);
        $user = User::find($id);
        $roles = Role::where('name', '<>', 'super-admin')->get()->pluck('name', 'id');
        $groups = Group::get()->pluck('name', 'id');
        return view('admin.users.edit', compact('user', 'roles', 'groups'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->authorize('user-edit', User::class);
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'same:password_confirmation',
                'roles' => 'required'
            ]
        );

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    /**
     * Display User.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('user-list', User::class);
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * @param $user_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function scheduler(int $user_id)
    {
        $this->authorize('user-list', Event::class);
        $user = User::findOrFail($user_id);

        return view('admin.users.scheduler', compact('user'));
    }

    /**
     * Remove User from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('user-delete', User::class);
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        $this->authorize('user-delete', User::class);
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
