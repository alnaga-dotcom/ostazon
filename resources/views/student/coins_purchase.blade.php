@php
    $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
@endphp
@extends('layouts.main')
@section('title', __('messages.buy_coins') . ' - OstazON')
@section('content')
<style>
    .purchase-container { max-width: 600px; margin: 0 auto; padding: 40px 24px; }
    .purchase-card { background: white; border-radius: 20px; padding: 32px; box-shadow: var(--shadow); }
    .purchase-card h1 { font-size: 24px; font-weight: 800; margin-bottom: 24px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 6px; color: #14532D; }
    .form-group input, .form-group select { width: 100%; padding: 12px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; }
    .form-group input[type="file"] { padding: 10px; }
    .bank-info { background: var(--primary-light); border-radius: 12px; padding: 16px; margin-bottom: 20px; font-size: 14px; line-height: 1.8; }
    .bank-info strong { color: var(--primary); }
    .form-hint { font-size: 13px; color: var(--text-light); margin-top: 4px; }
    .back-link { display: inline-block; margin-bottom: 16px; color: #16A34A; font-size: 14px; font-weight: 600; text-decoration: none; }
    .back-link:hover { text-decoration: underline; }
</style>
<div class="purchase-container">
    <a href="{{ url('/student/dashboard') }}" class="back-link">← {{ app()->getLocale() == 'ar' ? 'العودة للوحة التحكم' : 'Back to Dashboard' }}</a>
    <div class="purchase-card">
        <h1>{{ app()->getLocale() == 'ar' ? 'شراء عملات' : 'Buy Coins' }}</h1>

        @if(session('success'))
            <div style="background:#D4EDDA;color:#155724;padding:12px 16px;border-radius:12px;margin-bottom:16px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background:#F8D7DA;color:#721C24;padding:12px 16px;border-radius:12px;margin-bottom:16px;">{{ session('error') }}</div>
        @endif

        <!-- Bank/Wallet details for transfer -->
        <div class="bank-info">
            <strong>{{ app()->getLocale() == 'ar' ? '📌 يرجى تحويل المبلغ إلى أحد الحسابات التالية ثم إرسال الإثبات:' : '📌 Please transfer to one of the following accounts and submit proof:' }}</strong><br>
            <strong>Vodafone Cash:</strong> {{ $settings['vodafone_cash'] ?? '0100 000 0000' }}<br>
            <strong>InstaPay:</strong> {{ $settings['instapay'] ?? 'ostazon@instapay.com' }}<br>
            <strong>{{ $settings['bank_name'] ?? 'National Bank of Egypt' }}:</strong> {{ $settings['bank_account'] ?? '123-456-789-0123456' }}<br>
            <strong>PayPal:</strong> {{ $settings['paypal_email'] ?? 'paypal@ostazon.com' }}<br>
            <small style="color:#DC2626;">{{ app()->getLocale() == 'ar' ? '* العملات ستُضاف إلى حسابك بعد التحقق من الدفع من قبل الإدارة' : '* Coins will be credited after admin verifies your payment' }}</small>
        </div>

        <form method="POST" action="{{ route('student.coins.purchase.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'كمية العملات' : 'Coin Amount' }}</label>
                <select name="amount" required>
                    <option value="50" @selected(old('amount') == 50)>50 Coins - 50 EGP</option>
                    <option value="100" @selected(old('amount') == 100)>100 Coins - 100 EGP</option>
                    <option value="250" @selected(old('amount') == 250)>250 Coins - 250 EGP</option>
                    <option value="500" @selected(old('amount') == 500)>500 Coins - 500 EGP</option>
                    <option value="1000" @selected(old('amount') == 1000)>1000 Coins - 1000 EGP</option>
                </select>
                @error('amount') <div class="form-hint" style="color:#DC2626;">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'طريقة الدفع' : 'Payment Method' }}</label>
                <select name="payment_method" required>
                    <option value="vodafone_cash" @selected(old('payment_method') == 'vodafone_cash')>Vodafone Cash</option>
                    <option value="instapay" @selected(old('payment_method') == 'instapay')>InstaPay</option>
                    <option value="bank_transfer" @selected(old('payment_method') == 'bank_transfer')>{{ app()->getLocale() == 'ar' ? 'تحويل بنكي' : 'Bank Transfer' }}</option>
                    <option value="paypal" @selected(old('payment_method') == 'paypal')>PayPal</option>
                </select>
                @error('payment_method') <div class="form-hint" style="color:#DC2626;">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'رقم المرجع (رقم العملية)' : 'Transaction Reference' }}</label>
                <input type="text" name="transaction_reference" value="{{ old('transaction_reference') }}" placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: VF123456 أو رقم الحوالة' : 'e.g. VF123456 or transfer number' }}">
                @error('transaction_reference') <div class="form-hint" style="color:#DC2626;">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'صورة إثبات الدفع (اختياري)' : 'Payment Proof Screenshot (optional)' }}</label>
                <input type="file" name="screenshot" accept="image/*">
                @error('screenshot') <div class="form-hint" style="color:#DC2626;">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 16px;">{{ app()->getLocale() == 'ar' ? 'إرسال طلب الشراء' : 'Submit Purchase Request' }}</button>
        </form>
    </div>
</div>
@endsection
