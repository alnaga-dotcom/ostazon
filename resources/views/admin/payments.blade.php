@extends('layouts.main')

@section('title', 'Payment Verifications - Admin - OstazON')

@section('content')
<style>
    .admin-container { max-width: 1400px; margin: 0 auto; padding: 40px 24px; }
    .admin-header { margin-bottom: 32px; }
    .admin-header h1 { font-size: 32px; font-weight: 800; }
    .tabs { display: flex; gap: 8px; margin-bottom: 24px; background: white; padding: 6px; border-radius: 12px; box-shadow: var(--shadow); width: fit-content; }
    .tab { padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; border: none; background: transparent; color: var(--text-light); transition: all 0.3s; }
    .tab.active { background: var(--primary); color: white; }
    .payment-card { background: white; border-radius: 20px; padding: 28px; box-shadow: var(--shadow); margin-bottom: 20px; display: grid; grid-template-columns: 1fr auto auto; gap: 24px; align-items: start; }
    .payment-info h3 { font-size: 18px; font-weight: 700; margin-bottom: 8px; }
    .payment-info p { font-size: 14px; color: var(--text-light); margin-bottom: 4px; }
    .payment-amount { text-align: center; padding: 16px; background: var(--primary-light); border-radius: 12px; min-width: 140px; }
    .payment-amount .coins { font-size: 28px; font-weight: 800; color: var(--primary); }
    .payment-amount .price { font-size: 14px; color: var(--text-light); }
    .payment-actions { display: flex; flex-direction: column; gap: 8px; }
    .payment-actions .btn { padding: 10px 20px; font-size: 14px; text-align: center; }
    .screenshot-thumb { width: 80px; height: 80px; border-radius: 10px; object-fit: cover; cursor: pointer; border: 2px solid var(--bg); }
    .screenshot-thumb:hover { border-color: var(--primary); }
    .verified-card { background: white; border-radius: 16px; padding: 20px 24px; box-shadow: var(--shadow); margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; }
    .verified-info h4 { font-size: 15px; font-weight: 600; }
    .verified-info p { font-size: 13px; color: var(--text-light); }
    .status-verified { background: #d4edda; color: #155724; padding: 6px 14px; border-radius: 50px; font-size: 12px; font-weight: 600; }
    .status-rejected { background: #f8d7da; color: #721c24; padding: 6px 14px; border-radius: 50px; font-size: 12px; font-weight: 600; }
    .empty-state { text-align: center; padding: 60px; color: var(--text-light); }
    .modal-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 2000; justify-content: center; align-items: center; }
    .modal-overlay.show { display: flex; }
    .modal-content { background: white; border-radius: 20px; padding: 24px; max-width: 600px; width: 90%; max-height: 90vh; overflow: auto; }
    .modal-content img { width: 100%; border-radius: 12px; }
    .modal-close { background: var(--accent); color: white; border: none; padding: 10px 24px; border-radius: 10px; font-weight: 600; cursor: pointer; margin-top: 16px; width: 100%; }
    .admin-notes { width: 100%; padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; font-family: inherit; margin-bottom: 12px; outline: none; }
    .admin-notes:focus { border-color: var(--primary); }
</style>

<div class="admin-container">
    <div class="admin-header">
        <h1>💳 Payment Verifications</h1>
    </div>

    <div class="tabs">
        <button class="tab active" onclick="showTab('pending')">Pending ({{ $pendingPayments->count() }})</button>
        <button class="tab" onclick="showTab('verified')">Verified</button>
    </div>

    <div id="pending-tab">
        @forelse($pendingPayments as $payment)
            <div class="payment-card">
                <div class="payment-info">
                    <h3>{{ $payment->user->name }}</h3>
                    <p>📧 {{ $payment->user->email }} • 📱 {{ $payment->user->phone }}</p>
                    <p>💳 {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }} • Ref: {{ $payment->transaction_reference ?? 'N/A' }}</p>
                    <p>📅 Submitted {{ $payment->created_at->diffForHumans() }}</p>
                </div>

                <div class="payment-amount">
                    <div class="coins">{{ $payment->coins_requested }}</div>
                    <div class="price">{{ $payment->amount_egp }} EGP</div>
                </div>

                <div style="display: flex; gap: 16px; align-items: center;">
                    @if($payment->screenshot_url)
                        <img src="{{ Storage::disk('public')->url($payment->screenshot_url) }}"
                             class="screenshot-thumb"
                             onclick="openModal('{{ Storage::disk('public')->url($payment->screenshot_url) }}')"
                             alt="Payment screenshot">
                    @endif

                    <div class="payment-actions">
                        <form method="POST" action="{{ route('admin.payments.verify', $payment->id) }}">
                            @csrf
                            <input type="text" class="admin-notes" name="notes" placeholder="Admin notes (optional)">
                            <button type="submit" class="btn btn-primary">✅ Verify & Credit</button>
                        </form>
                        <form method="POST" action="{{ route('admin.payments.reject', $payment->id) }}">
                            @csrf
                            <input type="text" class="admin-notes" name="notes" placeholder="Rejection reason (optional)">
                            <button type="submit" class="btn btn-outline" style="border-color: var(--accent); color: var(--accent);">❌ Reject</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div style="font-size: 48px; margin-bottom: 16px;">✅</div>
                <h3>No pending payments</h3>
                <p>All caught up! New payments will appear here.</p>
            </div>
        @endforelse

        <div style="margin-top: 20px;">
            {{ $pendingPayments->links() }}
        </div>
    </div>

    <div id="verified-tab" style="display: none;">
        @forelse($verifiedPayments as $payment)
            <div class="verified-card">
                <div class="verified-info">
                    <h4>{{ $payment->user->name }} - {{ $payment->coins_requested }} Coins ({{ $payment->amount_egp }} EGP)</h4>
                    <p>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }} • Verified {{ $payment->verified_at->diffForHumans() }} by {{ $payment->verifier->name ?? 'Admin' }}</p>
                    @if($payment->admin_notes)
                        <p style="color: var(--text-light); margin-top: 4px;">Note: {{ $payment->admin_notes }}</p>
                    @endif
                </div>
                <span class="status-{{ $payment->status }}">{{ ucfirst($payment->status) }}</span>
            </div>
        @empty
            <div class="empty-state">
                <p>No verified payments yet.</p>
            </div>
        @endforelse
    </div>
</div>

<div class="modal-overlay" id="screenshotModal" onclick="closeModal()">
    <div class="modal-content" onclick="event.stopPropagation()">
        <img id="modalImage" src="" alt="Payment screenshot">
        <button class="modal-close" onclick="closeModal()">Close</button>
    </div>
</div>

<script>
    function showTab(tab) {
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        document.getElementById('pending-tab').style.display = tab === 'pending' ? 'block' : 'none';
        document.getElementById('verified-tab').style.display = tab === 'verified' ? 'block' : 'none';
        if (tab === 'pending') {
            document.querySelectorAll('.tab')[0].classList.add('active');
        } else {
            document.querySelectorAll('.tab')[1].classList.add('active');
        }
    }
    function openModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('screenshotModal').classList.add('show');
    }
    function closeModal() {
        document.getElementById('screenshotModal').classList.remove('show');
    }
</script>
@endsection