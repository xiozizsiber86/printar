<?php

namespace Tests\Unit;

use App\Models\MerchantProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class MerchantProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_merchant_profile_uses_correct_table(): void
    {
        $profile = new MerchantProfile();

        $this->assertEquals('merchant_profiles', $profile->getTable());
    }

    public function test_merchant_profile_has_fillable_attributes(): void
    {
        $profile = new MerchantProfile();

        $this->assertContains('user_id', $profile->getFillable());
        $this->assertContains('phone', $profile->getFillable());
        $this->assertContains('verification_status', $profile->getFillable());
        $this->assertContains('verified_by', $profile->getFillable());
    }

    public function test_merchant_profile_belongs_to_user(): void
    {
        $profile = new MerchantProfile();

        $this->assertInstanceOf(BelongsTo::class, $profile->user());
    }

    public function test_merchant_profile_belongs_to_verifier(): void
    {
        $profile = new MerchantProfile();

        $this->assertInstanceOf(BelongsTo::class, $profile->verifier());
    }

    public function test_merchant_profile_has_many_documents(): void
    {
        $profile = new MerchantProfile();

        $this->assertInstanceOf(HasMany::class, $profile->documents());
    }

    public function test_merchant_profile_has_many_shops(): void
    {
        $profile = new MerchantProfile();

        $this->assertInstanceOf(HasMany::class, $profile->shops());
    }
}
