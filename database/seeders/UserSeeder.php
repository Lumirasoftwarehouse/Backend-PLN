<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Divisi;
use App\Models\UserDivisi;
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
        // user
        User::create([
            'image' => 'aepOP1ZSPwIUoPII47AZlt7bTOXQ8HCmBe6eyUtw.png',
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '0',
            'position' => 'test'
        ]);
        User::create([
            'image' => 'aepOP1ZSPwIUoPII47AZlt7bTOXQ8HCmBe6eyUtw.png',
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '0',
            'position' => 'test'
        ]);
        // manager
        User::create([
            'image' => 'p6LVKEgeGQLgSBN8l51APsgv8vxtRAAL0t859D7K.png',
            'name' => 'manager1',
            'email' => 'manager1@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '1',
            'position' => 'test'
        ]);
        User::create([
            'image' => 'p6LVKEgeGQLgSBN8l51APsgv8vxtRAAL0t859D7K.png',
            'name' => 'manager2',
            'email' => 'manager2@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '1',
            'position' => 'test'
        ]);
        // admin
        User::create([
            'image' => 'p6LVKEgeGQLgSBN8l51APsgv8vxtRAAL0t859D7K.png',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '2',
            'position' => 'test'
        ]);

        Divisi::create([
            'nama_divisi' => 'IT',
            'id_atasan' => '3',
        ]);
        Divisi::create([
            'nama_divisi' => 'Keuangan',
            'id_atasan' => '4',
        ]);

        UserDivisi::create([
            'id_user' => '1',
            'id_divisi' => '1',
        ]);
        UserDivisi::create([
            'id_user' => '2',
            'id_divisi' => '2',
        ]);

        Project::create([
            'client' => 'Bank Mandiri',
            'project' => 'm-Banking',
            'dueDate' => '2025/08/01',
            'status' => '1'
        ]);
        Project::create([
            'client' => 'Bank BCA',
            'project' => 'm-Banking',
            'dueDate' => '2025/08/01',
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
            'start_date' => '2025/05/08',
            'end_date' => '2025/05/13',
            // 'id_user' => '1',
            'id_project' => '1'
        ]);
        Phase::create([
            'phase' => 'kedua',
            'start_date' => '2025/05/26',
            'end_date' => '2025/05/27',
            // 'id_user' => '1',
            'id_project' => '1'
        ]);
        Phase::create([
            'phase' => 'pertama',
            'start_date' => '2025/05/26',
            'end_date' => '2025/05/27',
            // 'id_user' => '1',
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
