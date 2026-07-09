@extends('layouts.main')
@section('title', 'Payment Settings - OstazON')
@section('content')
<style>
    .settings-container { max-width: 600px; margin: 0 auto; padding: 40px 24px; }
    .settings-card { background: white; border-radius: 20px; padding: 32px; box-shadow: var(--shadow); }
    .settings-card h1 { font-size: 24px; font-weight: 800; margin-bottom: 24px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 6px; color: #14532D; }
    .form-group input { width: 100%; padding: 12px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; }
    .form-group input:focus { outline: none; border-color: #16A34A; }
    .form-group .hint { font-size: 13px; color: #6b7280; margin-top: 4px; }
    .btn-save { width: 100%; padding: 14px; background: #16A34A; color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; }
    .btn-save:hover { background: #15803D; }
    .success-msg { background: #D4EDDA; color: #155724; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; }
</style>
<div class="settings-container">
    <div class="settings-card">
        <h1>⚙️ Payment Settings</h1>

        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            <div class="form-group">
                <label>Vodafone Cash</label>
                <input type="text" name="vodafone_cash" value="{{ $settings['vodafone_cash'] ?? '' }}" required>
                <div class="hint">Phone number for Vodafone Cash transfers</div>
            </div>
            <div class="form-group">
                <label>InstaPay</label>
                <input type="text" name="instapay" value="{{ $settings['instapay'] ?? '' }}" required>
                <div class="hint">Email or phone for InstaPay transfers</div>
            </div>
            <div class="form-group">
                <label>Bank Name</label>
                <input type="text" name="bank_name" value="{{ $settings['bank_name'] ?? '' }}" required>
                <div class="hint">e.g. National Bank of Egypt</div>
            </div>
            <div class="form-group">
                <label>Bank Account</label>
                <input type="text" name="bank_account" value="{{ $settings['bank_account'] ?? '' }}" required>
                <div class="hint">Account number for bank transfers</div>
            </div>
            <div class="form-group">
                <label>PayPal Email</label>
                <input type="email" name="paypal_email" value="{{ $settings['paypal_email'] ?? '' }}" required>
                <div class="hint">PayPal business email for receiving payments</div>
            </div>
            <div class="form-group">
                <label>Platform Fee (%)</label>
                <input type="number" name="platform_fee_percent" value="{{ $settings['platform_fee_percent'] ?? '5' }}" min="0" max="100" step="0.5" required>
                <div class="hint">Percentage deducted from each lesson as platform commission</div>
            </div>
            <button type="submit" class="btn-save">Save Settings</button>
        </form>
    </div>
</div>
@endsection
