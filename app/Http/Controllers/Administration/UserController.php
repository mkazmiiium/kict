<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUser\StoreUserRequest;
use App\Http\Requests\AdminUser\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $users = $this->filteredQuery($search)
            ->paginate($this->perPage($request))
            ->withQueryString();

        return view('administration.users.index', [
            'users' => $users,
            'search' => $search,
            'perPage' => $this->perPage($request),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $search = $request->get('search');

        $users = $this->filteredQuery($search)->get();

        $rows = $users->map(fn (User $user) => [
            $user->name,
            $user->email,
            $user->roles->pluck('name')->implode(', ') ?: '—',
        ])->all();

        $filters = $search ? "Search: \"{$search}\"" : '';

        return $this->exportListPdf('Users', ['Name', 'Email', 'Roles'], $rows, $filters);
    }

    private function filteredQuery(?string $search)
    {
        return User::query()
            ->with('roles')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name');
    }

    public function create()
    {
        return view('administration.users.create', $this->formData());
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $user->syncRoles($data['roles'] ?? []);

        return redirect()->route('administration.users.index')
            ->with('status', "User {$user->name} created.");
    }

    public function edit(User $user)
    {
        return view('administration.users.edit', [
            'user' => $user->load('roles'),
            ...$this->formData(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        $user->syncRoles($data['roles'] ?? []);

        return redirect()->route('administration.users.index')
            ->with('status', "User {$user->name} updated.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('administration.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('administration.users.index')
            ->with('status', "User {$name} deleted.");
    }

    private function formData(): array
    {
        return [
            'roles' => Role::orderBy('name')->get(),
        ];
    }
}
