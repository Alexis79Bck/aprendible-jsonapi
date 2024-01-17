<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Middleware\ValidateJsonApiHeaders;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidateJsonApiHeadersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function accept_header_must_be_present_in_all_requests(): void
    {
        Route::get('test_route', function () {
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);

        $this->getJson('test_route')->assertStatus(406);

        $this->getJson('test_route', [
            'accept' => 'application/vnd.api+json'
        ])->assertSuccessful();
    }

    /** @test */
    public function content_type_header_must_be_present_in_all_post_requests(): void
    {
        Route::post('test_route', function () {
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);

        $this->postJson('test_route', [], [
            'accept' => 'application/vnd.api+json'
        ])->assertStatus(415);

        $this->postJson('test_route', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])->assertSuccessful();
    }

    /** @test */
    public function content_type_header_must_be_present_in_all_patch_requests(): void
    {
        Route::patch('test_route', function () {
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);

        $this->patchJson('test_route', [], [
            'accept' => 'application/vnd.api+json'
        ])->assertStatus(415);

        $this->patchJson('test_route', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])->assertSuccessful();
    }

    /** @test */
    public function content_type_header_must_be_present_in_responses(): void
    {
        Route::any('test_route', function () {
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);

        $this->getJson('test_route', [
            'accept' => 'application/vnd.api+json'
        ])->assertHeader('content-type', 'application/vnd.api+json');

        $this->postJson('test_route', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])->assertHeader('content-type', 'application/vnd.api+json');

        $this->patchJson('test_route', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])->assertHeader('content-type', 'application/vnd.api+json');

        $this->deleteJson('test_route', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])->assertHeader('content-type', 'application/vnd.api+json');
    }

    /** @test */
    public function content_type_header_must_not_be_present_in_empty_responses(): void
    {
        Route::any('empty_response', function () {
            return response()->noContent();
        })->middleware(ValidateJsonApiHeaders::class);

        $this->getJson('empty_response', [
            'accept' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');

        $this->postJson('empty_response', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])->assertHeaderMissing('content-type');

        $this->patchJson('empty_response', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])->assertHeaderMissing('content-type');

        $this->deleteJson('empty_response', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])->assertHeaderMissing('content-type');
    }
}
