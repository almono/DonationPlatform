<?php

namespace App\Http\Controllers;

use App\Events\SendDonationConfirmation;
use App\Models\Campaign;
use App\Models\Donation;
use App\Services\DonationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DonationController extends Controller
{
    public function __construct(
        private DonationService $donationService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|gt:0',
            'campaign_id' => 'required'
        ]);

        $user = auth('sanctum')->user();
        $validated['user_id'] = $user->id;
        $newDonation = $this->donationService->sendDonation($validated);
        event(new SendDonationConfirmation($user, $newDonation, Campaign::find($validated['campaign_id']))); // Dispatch registered event

        return response()->json($newDonation, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donation $donation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        //
    }
}
