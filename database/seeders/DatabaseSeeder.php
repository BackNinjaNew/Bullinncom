<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categories;
use App\Models\TypeUsers;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = new Categories;
        $categories->category = 'Cintas';
        $categories->save();
        $categories = new Categories;
        $categories->category = 'Luminarias';
        $categories->save();
        $categories = new Categories;
        $categories->category = 'Perfiles';
        $categories->save();
        $categories = new Categories;
        $categories->category = 'Proyectores';
        $categories->save();

        $type_user = new TypeUsers;
        $type_user->type_user = 'Administrador';
        $type_user->save();
        $type_user = new TypeUsers;
        $type_user->type_user = 'Cliente';
        $type_user->save();

        $user = new User;
        $user->fk_type_user = 1;
        $user->document = '1057573250';
        $user->firstname = 'Daniel';
        $user->lastname = 'Parra Barrera';
        $user->email = 'bullinncom@gmail.com';
        $user->phone = '3014153760';
        $user->address = 'Kr 70  A # 68 - 75 SUR';
        $user->password = 'Proyecto2024*';
        $user->save();
    }
}