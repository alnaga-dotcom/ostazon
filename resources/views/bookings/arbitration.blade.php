@extends('layouts.main')

@section('title', __('messages.arbitration') . ' - Booking #' . $booking->id)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <a href="{{ url()->previous() }}" class="text-primary hover:text-green-800 text-sm font-medium flex items-center gap-1 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back
        </a>
        <h1 class="text-3xl font-extrabold text-text-dark">{{ __('messages.arbitration') }}</h1>
        <p class="text-gray-600 mt-2">Booking #{{ $booking->id }} - {{ $booking->subject->name ?? 'N/A' }}</p>
    </div>

    @if(session('success'))
        <div class="bg-accent/10 border border-accent text-primary px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-danger/10 border border-danger text-danger px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Status Card -->
    <div class="bg-white rounded-2xl shadow-md p-6 border border-primary/5 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-text-dark">Status</h2>
            <span class="px-3 py-1 rounded-full text-sm font-semibold 
                {{ $booking->arbitration_status === 'none' ? 'bg-gray-100 text-gray-600' : '' }}
                {{ $booking->arbitration_status === 'pending' ? 'bg-secondary/10 text-secondary' : '' }}
                {{ $booking->arbitration_status === 'resolved_student' ? 'bg-accent/10 text-accent' : '' }}
                {{ $booking->arbitration_status === 'resolved_tutor' ? 'bg-primary/10 text-primary' : '' }}
                {{ $booking->arbitration_status === 'rejected' ? 'bg-danger/10 text-danger' : '' }}">
                {{ ucfirst(str_replace('_', ' ', $booking->arbitration_status)) }}
            </span>
        </div>

        @if($booking->arbitration_status === 'none')
            @if($booking->canDispute())
                <div class="bg-bg-lime rounded-xl p-4 border border-primary/10">
                    <p class="text-sm text-gray-700 mb-4">
                        You can file a dispute within <strong>{{ $booking->frozen_until->diffForHumans() }}</strong>.
                        Arbitration fee: <strong class="text-secondary">{{ $booking->getArbitrationFee() }} coins</strong> (20% of lesson fee, non-refundable).
                    </p>

                    <form action="{{ route('bookings.dispute', $booking) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Reason for dispute *</label>
                            <textarea name="reason" required minlength="20" maxlength="1000" rows="4" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Describe the issue in detail (minimum 20 characters)..."></textarea>
                            <p class="text-xs text-gray-500 mt-1">Minimum 20 characters. Be specific and provide details.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-text-dark mb-1">Evidence (optional)</label>
                            <textarea name="evidence" maxlength="5000" rows="3" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Chat logs, screenshots, or any supporting evidence..."></textarea>
                        </div>

                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-secondary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <div class="text-sm text-amber-800">
                                    <strong>Important:</strong> The arbitration fee ({{ $booking->getArbitrationFee() }} coins) will be deducted immediately and is <strong>non-refundable</strong> regardless of outcome. If your claim is successful, you may receive up to 100% of the lesson fee refunded.
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-danger hover:bg-red-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-md">
                            {{ __('messages.claim_now') }} - Pay {{ $booking->getArbitrationFee() }} Coins
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-4 text-gray-500 text-sm">
                    @if($booking->isFrozen())
                        Dispute window closes in {{ $booking->frozen_until->diffForHumans() }}.
                    @else
                        Dispute window has closed. No further claims can be filed for this booking.
                    @endif
                </div>
            @endif
        @elseif($booking->arbitration_status === 'pending')
            <div class="bg-secondary/10 rounded-xl p-4 border border-secondary/20">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-secondary animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <div>
                        <p class="text-sm font-medium text-text-dark">Under Review</p>
                        <p class="text-xs text-gray-600">Filed {{ $booking->disputed_at->diffForHumans() }}. Our team will review within 48 hours.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-bg-lime rounded-xl p-4 border border-primary/10">
                <p class="text-sm text-gray-700">
                    <strong>Resolution:</strong> {{ ucfirst(str_replace('_', ' ', $booking->arbitration_status)) }}<br>
                    <strong>Date:</strong> {{ $booking->updated_at->format('M d, Y H:i') }}<br>
                    @if($booking->arbitration_evidence && str_contains($booking->arbitration_evidence, '[Admin Notes]'))
                        <strong>Admin Notes:</strong> {{ str_replace('[Admin Notes]: ', '', strstr($booking->arbitration_evidence, '[Admin Notes]:')) }}
                    @endif
                </p>
            </div>
        @endif
    </div>

    <!-- Booking Details -->
    <div class="bg-white rounded-2xl shadow-md p-6 border border-primary/5">
        <h2 class="text-lg font-bold text-text-dark mb-4">Booking Details</h2>
        <div class="grid md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-500">Student:</span>
                <span class="font-medium text-text-dark ml-2">{{ $booking->student->name }}</span>
            </div>
            <div>
                <span class="text-gray-500">Tutor:</span>
                <span class="font-medium text-text-dark ml-2">{{ $booking->tutor->name }}</span>
            </div>
            <div>
                <span class="text-gray-500">Subject:</span>
                <span class="font-medium text-text-dark ml-2">{{ $booking->subject->name ?? 'N/A' }}</span>
            </div>
            <div>
                <span class="text-gray-500">Amount:</span>
                <span class="font-medium text-text-dark ml-2">{{ $booking->total_price }} coins</span>
            </div>
            <div>
                <span class="text-gray-500">Completed:</span>
                <span class="font-medium text-text-dark ml-2">{{ $booking->completed_at ? $booking->completed_at->format('M d, Y') : 'N/A' }}</span>
            </div>
            <div>
                <span class="text-gray-500">Frozen Until:</span>
                <span class="font-medium text-text-dark ml-2">{{ $booking->frozen_until ? $booking->frozen_until->format('M d, Y') : 'N/A' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
