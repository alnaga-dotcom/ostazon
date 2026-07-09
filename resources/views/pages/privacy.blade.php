@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy')
@section('meta_description', 'OstazON privacy policy — how we collect, use, and protect your personal data.')

@section('content')
<section style="background: linear-gradient(135deg, #166534 0%, #15803D 100%); padding: 48px 24px; text-align: center;">
    <div style="max-width: 800px; margin: 0 auto;">
        <h1 style="font-size: 36px; font-weight: 800; color: #FFFFFF; margin-bottom: 12px;">
            {{ app()->getLocale() == 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}
        </h1>
        <p style="color: #DCFCE7; font-size: 16px;">
            {{ app()->getLocale() == 'ar' ? 'آخر تحديث: يوليو 2026' : 'Last updated: July 2026' }}
        </p>
    </div>
</section>

<div style="max-width: 800px; margin: 0 auto; padding: 40px 24px;">
    @php $ar = app()->getLocale() == 'ar'; @endphp

    <div style="background: white; border-radius: 16px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <div style="width: 40px; height: 40px; background: #DBEAFE; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">🔒</div>
            <h2 style="font-size: 20px; font-weight: 700; color: #14532D; margin: 0;">
                {{ $ar ? 'المعلومات التي نجمعها' : 'Information We Collect' }}
            </h2>
        </div>
        <div style="color: #4b5563; line-height: 1.8; display: flex; flex-direction: column; gap: 16px;">
            <p>{{ $ar ? 'عند إنشاء حساب على OstazON، قد نجمع المعلومات التالية:' : 'When you create an account on OstazON, we may collect the following information:' }}</p>
            <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 8px;">
                <li>{{ $ar ? 'الاسم الكامل وعنوان البريد الإلكتروني ورقم الهاتف' : 'Full name, email address, and phone number' }}</li>
                <li>{{ $ar ? 'معلومات الملف الشخصي مثل الصورة والسيرة الذاتية والمؤهلات التعليمية' : 'Profile information such as photo, bio, and educational qualifications' }}</li>
                <li>{{ $ar ? 'سجل الحجوزات والمراجعات والمدفوعات' : 'Booking history, reviews, and payment records' }}</li>
                <li>{{ $ar ? 'بيانات الاستخدام مثل الصفحات التي تزورها ووقت زيارتك' : 'Usage data such as pages visited and time of visit' }}</li>
            </ul>
        </div>
    </div>

    <div style="background: white; border-radius: 16px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <div style="width: 40px; height: 40px; background: #ECFDF0; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">📋</div>
            <h2 style="font-size: 20px; font-weight: 700; color: #14532D; margin: 0;">
                {{ $ar ? 'كيف نستخدم معلوماتك' : 'How We Use Your Information' }}
            </h2>
        </div>
        <ul style="color: #4b5563; line-height: 1.8; padding-left: 20px; display: flex; flex-direction: column; gap: 8px;">
            <li>{{ $ar ? 'تقديم خدمات المنصة وتسهيل التواصل بين الطلاب والمعلمين' : 'Providing platform services and facilitating communication between students and tutors' }}</li>
            <li>{{ $ar ? 'معالجة المدفوعات والعمليات المالية' : 'Processing payments and financial transactions' }}</li>
            <li>{{ $ar ? 'تحسين تجربة المستخدم وتطوير المنصة' : 'Improving user experience and platform development' }}</li>
            <li>{{ $ar ? 'إرسال الإشعارات والتحديثات الهامة' : 'Sending important notifications and updates' }}</li>
            <li>{{ $ar ? 'الامتثال للمتطلبات القانونية والتنظيمية' : 'Complying with legal and regulatory requirements' }}</li>
        </ul>
    </div>

    <div style="background: white; border-radius: 16px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <div style="width: 40px; height: 40px; background: #FEF3C7; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">🛡️</div>
            <h2 style="font-size: 20px; font-weight: 700; color: #14532D; margin: 0;">
                {{ $ar ? 'حماية البيانات' : 'Data Protection' }}
            </h2>
        </div>
        <p style="color: #4b5563; line-height: 1.8;">{{ $ar ? 'نحن نأخذ أمن بياناتك على محمل الجد. نستخدم إجراءات أمنية مناسبة لحماية معلوماتك الشخصية من الوصول غير المصرح به أو التعديل أو الكشف أو الإتلاف. جميع المدفوعات تتم عبر بوابات دفع آمنة ومشفرة.' : 'We take your data security seriously. We use appropriate security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction. All payments are processed through secure, encrypted payment gateways.' }}</p>
    </div>

    <div style="background: white; border-radius: 16px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <div style="width: 40px; height: 40px; background: #FCE7F3; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">📧</div>
            <h2 style="font-size: 20px; font-weight: 700; color: #14532D; margin: 0;">
                {{ $ar ? 'التواصل معنا' : 'Contact Us' }}
            </h2>
        </div>
        <p style="color: #4b5563; line-height: 1.8;">
            {{ $ar ? 'إذا كان لديك أي استفسار حول سياسة الخصوصية هذه، يرجى التواصل معنا على' : 'If you have any questions about this privacy policy, please contact us at' }}
            <a href="mailto:support@ostazon.com" style="color: #166534; font-weight: 600;">support@ostazon.com</a>.
        </p>
    </div>
</div>
@endsection