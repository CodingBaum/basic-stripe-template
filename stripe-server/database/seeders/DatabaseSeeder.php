<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('products')->delete();

        $products = Http::withHeaders([
            'Authorization' => 'Bearer ' . env("STRIPE_SECRET_KEY")
        ])->get('https://api.stripe.com/v1/products')["data"];

        foreach ($products as $product){
            $price = Http::withHeaders([
                'Authorization' => 'Bearer ' . env("STRIPE_SECRET_KEY")
            ])->get('https://api.stripe.com/v1/prices/' . $product["default_price"]);

            DB::table('products')->insert([
                'prod_id' => $product["id"],
                'name' => $product["name"],
                'description' => $product["description"],
                'image' => $product["images"][0],
                'price' => $price['unit_amount']/100,
                'currency_code' => $price['currency']
            ]);
        }
    }
}
