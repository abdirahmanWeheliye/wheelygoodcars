<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Cache\TagSet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
             'Elektrisch', 'Hybride', 'SUV', 'Sedan', 'Hatchback',
            'Cabrio', 'Diesel', 'Benzine', 'Automaat', 'Handgeschakeld',
            '4x4', 'Familieauto', 'Stadsauto', 'Sportauto', 'Oldtimer',
            'Compact', 'Luxe', 'Budget', 'Bedrijfswagen', 'Leasable',
        ];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
}
