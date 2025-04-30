<div>
    <p>Dear {{ $user->email }}, </p>
    <p>You have pledged <span style="font-weight: 600">{{ $donation->amount }}$</span> towards <span style="font-weight: 600">{{ $campaign->name }}</span></p>
    <p>Thank you for your support and we are looking forward to you!</p>
    <p>Kind Regards,</p>
    <p>Platform_XYZ</p>
</div>
