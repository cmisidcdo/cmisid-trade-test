<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class Users extends Component
{

    use WithPagination;
    public $editMode;
    public $search;
    public $user; 
    public $name, $email, $password, $type = '', $user_id;
    public $permission;
    public $permissions = [];
    public $archive = false;

    // public function mount()
    // {
    //     $user = auth()->user();

    //     if(!$user->can('read user')){
    //         abort(403);
    //     }
    // }

    public function render()
    {
        return view('livewire.settings.users',
    [
        'users'=> $this->getUsers()
    ]);
    }

    public function toggleArchive()
    {
        $this->archive = !$this->archive;
    }

    public function getUsers()
    {
        $query = User::query();

        if ($this->archive) {
            $query->onlyTrashed(); 
        }

        return $query
            ->when($this->search, function ($query){
                $query->where('name','like','%'. $this->search .'%')
                ->orWhere('email','like','%'. $this->search .'%');
            })
            ->paginate(10);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function rules()
    {
        return [
            'name'  => ['required', 'string'],
            'type'  => ['required', 'string', Rule::in(['superadmin', 'admin', 'assessor', 'secretariat'])],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email')->ignore($this->user_id),
            ],
        ];
    }
    

    public function loadUsers()
    {
        // return User::all();
        return User::withTrashed()
        ->when($this->search, function ($query){
            $query->where('name','like','%'. $this->search .'%')
            ->orWhere('email','like','%'. $this->search .'%');
        })
        ->paginate(10);
    }

    public function createUser()
    {
        $this->validate();

        DB::transaction(function () {
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->type = $this->type;
            if (!empty($this->password)) {
                $user->password = Hash::make($this->password);
            } else {
                $user->password = Hash::make('admin12345');
            }
            $user->save();

            if (!empty($this->permissions)) {
                $user->syncPermissions($this->permissions);
            }

            activity('user_management')
                ->event('create') 
                ->performedOn($user)
                ->causedBy(auth()->user())
                ->withProperties([
                    'name' => $user->name,
                    'email' => $user->email,
                    'type' => $user->type,
                    'permissions' => $user->permissions->pluck('name')->toArray(),
                ])
                ->log('Created a new user');
        });

        $this->clear();
        $this->dispatch('hide-userModal');
        $this->dispatch('success', 'User Created Successfully');
    }


    public function clear()
    {
        $this->reset();
        $this->password = null;
        $this->resetValidation();
    }

    public function readUser($userId)
    {
        $user = User::withTrashed()->findOrFail($userId);
    
        $this->fill(
            $user->only(['name', 'email', 'type'])
        );
    
        $this->user_id = $user->id;
        $this->editMode = true;
        $this->permissions = $user->getPermissionNames()->toArray();
        $this->dispatch('show-userModal');
    }
    

    public function updateUser()
    {
        $this->validate();

        DB::transaction(function () {  
            $user = User::withTrashed()->findOrFail($this->user_id);
            
            $originalData = [
                'name' => $user->name,
                'type' => $user->type,
                'email' => $user->email,
                'permissions' => $user->permissions->pluck('name')->toArray(),
            ];

            $user->name = $this->name;
            $user->type = $this->type;
            $user->email = $this->email;
            if (!empty($this->password)) {
                $user->password = Hash::make($this->password);
            }
            $user->save();

            $user->syncPermissions($this->permissions);

            $updatedData = [
                'name' => $user->name,
                'type' => $user->type,
                'email' => $user->email,
                'permissions' => $user->permissions->pluck('name')->toArray(),
            ];

            if ($user instanceof User) {
                activity('user_management')
                    ->event('update')
                    ->performedOn($user)
                    ->causedBy(auth()->user())
                    ->withProperties([
                        'old' => $originalData,
                        'new' => $updatedData,
                    ])
                    ->log('updated');
            } else {
                \Log::warning('Activity log skipped: Expected User model but got ' . gettype($user));
            }
            
        });

        $this->clear();
        $this->dispatch('hide-userModal');
        $this->dispatch('success', 'User updated successfully.');
    }

    

    
    public function deleteUser(User $user)
    {
        DB::transaction(function () use ($user) {
            $originalData = [
                'name' => $user->name,
                'email' => $user->email,
                'type' => $user->type,
                'permissions' => $user->permissions->pluck('name')->toArray(),
            ];
    
            $user->delete();
    
            activity('user_management')
                ->event('deleted')
                ->performedOn($user)
                ->causedBy(auth()->user())
                ->withProperties([
                    'deleted_user' => $originalData,
                    'deleted_at' => now(),
                ])
                ->log('deleted');
        });
    
        $this->dispatch('success', 'User deleted successfully');
    }
    

    public function restoreUser($user_id)
    {
        DB::transaction(function () use ($user_id) {
            $user = User::withTrashed()->findOrFail($user_id);
            
            $user->restore();
            
            if ($user instanceof User) {
                activity('user_management')
                    ->event('restored') 
                    ->performedOn($user)
                    ->causedBy(auth()->user())
                    ->withProperties([
                        'restored_user' => [
                            'name' => $user->name,
                            'email' => $user->email,
                            'type' => $user->type,
                            'permissions' => optional($user->permissions)->pluck('name')->toArray(),
                        ],
                        'restored_at' => now(),
                    ])
                    ->log('restored');
            }
            
        });
    
        $this->dispatch('success', 'User restored successfully.');
    }
    


    public function updatedType($value)
    {
        if ($value === 'superadmin') {
            $this->permissions = [
                "assessor permission",
                "secretariat permission",
                "create user", "update user", "read user", "delete user",
                "create candidate", "update candidate", "read candidate", "delete candidate",
                "create reference", "update reference", "read reference", "delete reference",
                "create exam", "update exam", "read exam", "delete exam"
            ];
        } elseif ($value === 'admin') {
            $this->permissions = [
                "read user",
                "read candidate",
                "read reference",
                "read exam"
            ];
        } elseif ($value === 'assessor') {
            $this->permissions = ["assessor permission"];
        } elseif ($value === 'secretariat') {
            $this->permissions = ["secretariat permission"];
        } else {
            $this->permissions = [];
        }
    }

    public function viewUser($userId)
    {
        $this->user = User::withTrashed()->findOrFail($userId);

        $this->permissions = $this->user->getPermissionNames()->toArray();

        $this->dispatch('show-viewModal');
    }


}
