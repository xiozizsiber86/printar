<?php

namespace Database\Factories;

use App\Models\MerchantDocument;
use App\Models\MerchantProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MerchantDocument>
 */
class MerchantDocumentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'merchant_id' => MerchantProfile::factory(),
            'document_type' => fake()->randomElement([
                'ktp',
                'npwp',
                'business_license',
            ]),
            'file_path' => 'merchant-documents/' . fake()->uuid() . '.pdf',
        ];
    }
}
