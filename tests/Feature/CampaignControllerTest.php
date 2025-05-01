<?php
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

// db refresh on running test
uses(RefreshDatabase::class);

// Shared setup for Admin
beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'Admin']);
    $this->user = User::factory()->create(['role' => 'User']); // Non-admin
});

// --- Admin Tests ---

it('allows admin to view all campaigns, check if at least the newly created ones can be viewed', function () {
    Campaign::factory()->count(3)->create();

    $this->actingAs($this->admin, 'sanctum');

    $response = $this->getJson('/api/campaigns');
    $response->assertOk()->assertJsonCount(3);
});

it('allows admin to create a campaign', function () {
    $this->actingAs($this->admin, 'sanctum');

    $payload = [
        'name' => 'Test Campaign',
        'description' => 'Created by Admin',
        'group_id' => null,
        'is_active' => 1,
    ];

    $response = $this->postJson('/api/campaigns', $payload);

    $response->assertCreated();
    $this->assertDatabaseHas('campaigns', ['name' => 'Test Campaign']);
});

it('allows admin to update a campaign', function () {
    $campaign = Campaign::factory()->create();
    $this->actingAs($this->admin, 'sanctum');

    $payload = [
        'name' => 'Updated Campaign',
        'description' => 'Updated by Admin',
        'group_id' => null,
        'is_active' => 0,
    ];

    $response = $this->putJson("/api/campaigns/{$campaign->id}", $payload);

    $response->assertOk();
    $this->assertDatabaseHas('campaigns', ['id' => $campaign->id, 'name' => 'Updated Campaign']);
});

it('allows admin to delete a campaign', function () {
    $campaign = Campaign::factory()->create();
    $this->actingAs($this->admin, 'sanctum');

    $response = $this->deleteJson("/api/campaigns/{$campaign->id}");

    $response->assertNoContent();
    $this->assertDatabaseMissing('campaigns', ['id' => $campaign->id]);
});

// --- Non-Admin Restrictions ---

it('prevents non-admin from creating a campaign', function () {
    $this->actingAs($this->user, 'sanctum');

    $payload = [
        'name' => 'Should Not Work',
        'description' => 'Attempt by User',
        'group_id' => null,
        'is_active' => 1,
    ];

    $response = $this->postJson('/api/campaigns', $payload);
    $response->assertForbidden();
});

it('prevents non-admin from updating a campaign', function () {
    $campaign = Campaign::factory()->create();
    $this->actingAs($this->user, 'sanctum');

    $payload = ['name' => 'Blocked'];

    $response = $this->putJson("/api/campaigns/{$campaign->id}", $payload);
    $response->assertForbidden();
});

it('prevents non-admin from deleting a campaign', function () {
    $campaign = Campaign::factory()->create();
    $this->actingAs($this->user, 'sanctum');

    $response = $this->deleteJson("/api/campaigns/{$campaign->id}");
    $response->assertForbidden();
});
