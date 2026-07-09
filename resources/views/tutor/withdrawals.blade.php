@extends('layouts.main')
@section('title', __('messages.withdrawals') . ' - OstazON')
@section('content')
<style>
    .wd-container { max-width: 800px; margin: 0 auto; padding: 40px 24px; }
    .wd-card { background: white; border-radius: 20px; padding: 32px; box-shadow: var(--shadow); margin-bottom: 24px; }
    .wd-card h2 { font-size: 20px; font-weight: 700; margin-bottom: 20px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 6px; color: #14532D; }
    .form-group input, .form-group select { width: 100%; padding: 12px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; }
    .balance-display { font-size: 24px; font-weight: 800; color: var(--primary); margin-bottom: 20px; }
</style>
<div class="wd-container">
    <div class="wd-card">
        <h2>{{ app()->getLocale() == 'ar' ? 'طلب سحب' : 'Withdrawal Request' }}</h2>
        <div class="balance-display">
            {{ app()->getLocale() == 'ar' ? 'الرصيد المتاح:' : 'Available Balance:' }} {{ number_format(auth()->user()->tutorProfile->available_balance ?? 0, 0) }} EGP
        </div>
        <form method="POST" action="{{ route('tutor.withdrawals.store') }}">
            @csrf
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'المبلغ' : 'Amount' }}</label>
                <input type="number" name="amount" min="500" max="{{ auth()->user()->tutorProfile->available_balance ?? 0 }}" required>
                <div style="font-size: 13px; color: #6b7280; margin-top: 4px;">
                    {{ app()->getLocale() == 'ar' ? 'الحد الأدنى للسحب هو 500 جنيه' : 'Minimum withdrawal is 500 EGP' }}
                </div>
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'طريقة الدفع' : 'Payment Method' }}</label>
                <select name="payment_method" required>
                    <option value="bank">{{ app()->getLocale() == 'ar' ? 'تحويل بنكي' : 'Bank Transfer' }}</option>
                    <option value="vodafone">{{ app()->getLocale() == 'ar' ? 'فودافون كاش' : 'Vodafone Cash' }}</option>
                    <option value="instapay">InstaPay</option>
                </select>
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'تفاصيل الدفع' : 'Payment Details' }}</label>
                <input type="text" name="payment_details" placeholder="{{ app()->getLocale() == 'ar' ? 'رقم الحساب أو المحفظة' : 'Account or wallet number' }}" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ app()->getLocale() == 'ar' ? 'تقديم الطلب' : 'Submit Request' }}</button>
        </form>
    </div>
</div>
@endsection