<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_uses_correct_table(): void
    {
        $category = new Category();

        $this->assertEquals('categories', $category->getTable());
    }

    public function test_category_has_fillable_attributes(): void
    {
        $category = new Category();

        $this->assertContains('name', $category->getFillable());
        $this->assertContains('description', $category->getFillable());
        $this->assertContains('is_active', $category->getFillable());
    }

    public function test_category_has_many_services(): void
    {
        $category = new Category();

        $this->assertInstanceOf(
            HasMany::class,
            $category->services()
        );
    }
}
