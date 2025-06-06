<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    public $permissions = [];
    public $permission_name;

    public function clear()
    {
        $this->reset();
    }
    public function render()
    {
        return view('livewire.permissions', [
            'permissions' => $this->loadPermissions()
        ]);
    }


    public function createPermission()
    {
        Permission::create([
            'name'=> $this->permission_name
        ]);
        
        $this->clear();
        $this->dispatch('success', 'Permission Created Successfuly');
       
    }

    public function loadPermissions()
    {
        $this->permissions = Permission::all();   
    }

    public function mount()
    {
        $user = auth()->user();
        
        if (!$user || $user->type !== 'superadmin') {
            abort(403, 'Unauthorized');
        }
    }

}
