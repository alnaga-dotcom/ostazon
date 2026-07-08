@extends('layouts.main')
@section('title', __('messages.coins') . ' - OstazON')
@section('content')
<style>
    .coins-container { max-width: 900px; margin: 0 auto; padding: 40px 24px; }
    .coins-header h1 { font-size: 28px; font-weight: 800; margin-bottom: 24px; }
    .section-card { background: white; border-radius: 20px; padding: 28px; box-shadow: var(--shadow); margin-bottom: 24px; }
    .section-card h2 { font-size: 20px; font-weight: 700; margin-bottom: 20px; }
    .balance-big { font-size: 48px; font-weight: 800; color: var(--primary); text-align: center; padding: 24px; }
    .tx-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6; }
    .tx-item:last-child { border-bottom: none; }
    .tx-debit { color: #dc2626; }
    .tx-credit { color: #16a34a; }
    .empty-state { text-align: center; padding: 40px; color: var(--text-light); }
</style>
<div class="coins-container">
    <div class="coins-header">
        <h1>{{ app()->getLocale() == 'ar' ? 'رصيد العملات' : 'Coin Balance' }}</h1>
    </div>
    <div class="section-card">
        <div class="balance-big">{{ auth()->user()->studentProfile->coins_balance ?? 0 }}</div>
        <p style="text-align: center; color: var(--text-light);">{{ app()->getLocale() == 'ar' ? 'عملة متاحة' : 'available coins' }}</p>
    </div>
    <div class="section-card">
        <h2>{{ app()->getLocale() == 'ar' ? 'سجل المعاملات' : 'Transaction History' }}</h2>
        @php $txns = \App\Models\CoinTransaction::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get(); @endphp
        @if($txns->count() > 0)
            @foreach($txns as $tx)
                <div class="tx-item">
                    <div>
                        <strong>{{ $tx->type }}</strong>
                        <p style="font-size: 13px; color: var(--text-light);">{{ $tx->description }}</p>
                    </div>
                    <div class="{{ $tx->amount > 0 ? 'tx-credit' : 'tx-debit' }}">{{ $tx->amount > 0 ? '+' : '' }}{{ $tx->amount }}</div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <p>{{ app()->getLocale() == 'ar' ? 'لا توجد معاملات بعد' : 'No transactions yet.' }}</p>
            </div>
        @endif
    </div>
</div>
@endsection