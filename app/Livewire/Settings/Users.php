<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;


class Users extends Component
{

    use WithPagination;
    public $editMode;
    public $search;
    public $name, $email, $user_id;
    public $archive = false;

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
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
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
            $user->password = Hash::make('password');
            $user->save();
        });

        $this->clear();
        $this->dispatch('hide-userModal');
        $this->dispatch('success', 'User Created Successfuly');
       
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function readUser($userId)
    {
        $user = User::withTrashed()->findOrFail($userId);

        $this->fill(
            $user->only(['name', 'email'])
        );

        $this->user_id = $user->id;
        $this->editMode = true;
        $this->dispatch('show-userModal');

    }

    public function updateUser()
    {
        $this->validate();

        DB::transaction(function () {  
        
            $user = User::withTrashed()->findOrFail($this->user_id);
            $user->name = $this->name;
            $user->email = $this->email;
            // $user->password = Hash::make('password');
            $user->save();
        });

        $this->clear();
        $this->dispatch('hide-userModal');
        $this->dispatch('success', 'User updated successfully.');
    } 
    
    public function deleteUser(User $user)
    {
        $user->delete();

        $this->dispatch('success', 'User deleted successfully');
    }

    public function restoreUser($user_id)
    {
        $user = User::withTrashed()->findOrFail($user_id);
        $user->restore();
    
        $this->dispatch('success', 'User restored successfully.');
    }
}
