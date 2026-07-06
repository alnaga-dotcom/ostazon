@extends('layouts.main')

@section('title', __('messages.arbitration') . ' - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-text-dark">{{ __('messages.arbitration') }}</h1>
        <p class="text-gray-600 mt-2">Review and resolve pending disputes</p>
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

    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-primary/5">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">ID</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Claimant</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Booking</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Reason</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Fee</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Date</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($arbitrations as $arbitration)
                        <tr class="hover:bg-bg-lime transition">
                            <td class="px-6 py-4 text-sm text-gray-900">#{{ $arbitration->id }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-text-dark">
                                    {{ $arbitration->claimant_type === 'student' ? $arbitration->student->name : $arbitration->tutor->name }}
                                </div>
                                <div class="text-xs text-gray-500">{{ ucfirst($arbitration->claimant_type) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-text-dark">{{ $arbitration->subject->name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $arbitration->total_price }} coins</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 max-w-xs truncate">{{ $arbitration->dispute_reason }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-secondary">{{ $arbitration->arbitration_fee_amount }} coins</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $arbitration->disputed_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.arbitrations.resolve', $arbitration) }}" method="POST" class="space-y-2">
                                    @csrf
                                    <select name="resolution" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="">Select...</option>
                                        <option value="student">Favor Student</option>
                                        <option value="tutor">Favor Tutor</option>
                                        <option value="reject">Reject Claim</option>
                                    </select>
                                    <textarea name="admin_notes" placeholder="Admin notes..." rows="2" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary focus:border-primary"></textarea>
                                    <button type="submit" class="w-full bg-primary hover:bg-green-800 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                                        Resolve
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                No pending arbitrations
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $arbitrations->links() }}
        </div>
    </div>
</div>
@endsection
