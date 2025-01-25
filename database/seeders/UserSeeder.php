<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\UserProject;
use App\Models\Phase;
use App\Models\Deliverable;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'image' => 'aepOP1ZSPwIUoPII47AZlt7bTOXQ8HCmBe6eyUtw.png',
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '0',
            'position' => 'test'
        ]);
        User::create([
            'image' => 'p6LVKEgeGQLgSBN8l51APsgv8vxtRAAL0t859D7K.png',
            'name' => 'pic bagus',
            'email' => 'picbagus@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '1',
            'position' => 'test'
        ]);
        User::create([
            'image' => 'p6LVKEgeGQLgSBN8l51APsgv8vxtRAAL0t859D7K.png',
            'name' => 'pic untoro',
            'email' => 'picuntoro@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '1',
            'position' => 'test'
        ]);
        User::create([
            'image' => 'p6LVKEgeGQLgSBN8l51APsgv8vxtRAAL0t859D7K.png',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '2',
            'position' => 'test'
        ]);

        Project::create([
            'client' => 'Bank Mandiri',
            'project' => 'm-Banking',
            'dueDate' => '2024/05/01',
            'status' => '1'
        ]);
        Project::create([
            'client' => 'Bank BCA',
            'project' => 'm-Banking',
            'dueDate' => '2024/06/01',
        ]);

        UserProject::create([
            'userId' => '2',
            'projectId' => '1'
        ]);
        UserProject::create([
            'userId' => '3',
            'projectId' => '2'
        ]);
        Phase::create([
            'phase' => 'pertama',
            'start_date' => '2024/06/08',
            'end_date' => '2024/06/13',
            'id_user' => '1',
            'id_project' => '1'
        ]);
        Phase::create([
            'phase' => 'kedua',
            'start_date' => '2024/06/26',
            'end_date' => '2024/06/27',
            'id_user' => '1',
            'id_project' => '1'
        ]);
        Phase::create([
            'phase' => 'pertama',
            'start_date' => '2024/06/26',
            'end_date' => '2024/06/27',
            'id_user' => '1',
            'id_project' => '2'
        ]);
        Deliverable::create([
            'deliverable' => 'Finish',
            'file' => 'Dokumen',
            'notes' => 'Tugas selesai',
            'id_project' => '1',
        ]);
        Deliverable::create([
            'deliverable' => 'Finish',
            'file' => 'Dokumen',
            'notes' => 'Tugas selesai',
            'id_project' => '2',
        ]);
    }
}
