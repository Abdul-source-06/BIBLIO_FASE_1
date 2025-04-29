<?php
namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {

        $perms = [
            'create-books','edit-books','delete-books',
            'create-autores','edit-autores','delete-autores',
            'create-categorias','edit-categorias','delete-categorias',
        ];
        
        foreach ($perms as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }


        $admin  = Role::firstOrCreate(['name'=>'administrador']);
        $editor = Role::firstOrCreate(['name'=>'usuario']);

        
        $admin->syncPermissions($perms);

        $editor->syncPermissions(['create-books','edit-books','delete-books']);

        $user = User::where('email', 'admin@gmail.com')->first(); 
        if ($user) {
            $user->assignRole('administrador'); 
        }
    }
}
