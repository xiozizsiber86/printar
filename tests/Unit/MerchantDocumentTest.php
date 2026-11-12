<?php

namespace Tests\Unit;

use App\Models\MerchantDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class MerchantDocumentTest extends TestCase
{
    use RefreshDatabase;

    public function test_document_model_uses_correct_table(): void
    {
        $document = new MerchantDocument();

        $this->assertEquals('merchant_documents', $document->getTable());
    }

    public function test_document_model_has_fillable_attributes(): void
    {
        $document = new MerchantDocument();

        $this->assertContains('merchant_id', $document->getFillable());
        $this->assertContains('document_type', $document->getFillable());
        $this->assertContains('file_path', $document->getFillable());
    }

    public function test_document_belongs_to_merchant_profile(): void
    {
        $document = new MerchantDocument();

        $this->assertInstanceOf(
            BelongsTo::class,
            $document->merchantProfile()
        );
    }
}

