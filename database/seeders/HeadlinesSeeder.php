<?php

namespace Database\Seeders;

use App\Models\Headline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeadlinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Headline::truncate();

        $headlineDataFile = fopen(base_path("database/data/headlines_data.json"), "r");

        while(!feof($headlineDataFile)) {
            
            try {
                $headlineData = json_decode(fgets($headlineDataFile));

                // continue on error
                if(!$headlineData)
                    continue;

                Headline::create([
                    "link" => $headlineData->link,
                    "headline" => $headlineData->headline,
                    "category" => $headlineData->category,
                    "short_description" => $headlineData->short_description,
                    "authors" => $headlineData->authors,
                    "date" => $headlineData->date,
                ]);
            } catch(\Throwable|\Exception $e) {
                continue;
            }
            

        }

        fclose($headlineDataFile);
    }
}
