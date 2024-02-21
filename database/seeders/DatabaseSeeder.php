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
        $categories->category = 'Balas';
        $categories->save();
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
        $user->document = '80760503';
        $user->firstname = 'Andres Orlando';
        $user->lastname = 'Cubillos Acero';
        $user->email = 'andres.cubillos100@gmail.com';
        $user->phone = '3187168370';
        $user->address = 'TV 70 D BIS A # 68 - 75 SUR TORRE 3 APTO 105';
        $user->password = 'Nacional.2016';
        $user->save();
    }
}