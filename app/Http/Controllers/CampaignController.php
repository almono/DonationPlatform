<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Services\CampaignsService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CampaignController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private CampaignsService $campaignsService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campaigns = $this->campaignsService->getCampaigns();
        return response()->json($campaigns, empty($campaigns) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->user()->can('create', Campaign::class)) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:200',
            'description' => 'required|string|min:3|max:200'
        ]);

        $newCampaign = $this->campaignsService->createCampaign($validated);
        return response()->json($newCampaign, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        if (!$request->user()->can('update', $campaign)) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name'          => 'required|string|max:200',
            'description'   => 'nullable|string|max:200',
            'group_id'      => 'nullable|exists:groups,id',
            'is_active'     => 'nullable|numeric'
        ]);
    
        $updatedCampaign = $this->campaignsService->updateCampaign($campaign, $validated);
    
        return response()->json([
            'message' => 'Campaign updated successfully',
            'updated' => $updatedCampaign
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);

        $this->campaignsService->deleteCampaign($campaign);
        return response()->json(['message' => 'Campaign deleted successfully.'], Response::HTTP_NO_CONTENT);

    }
}
