@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'سياسة التحكيم' : 'Arbitration Policy')

@section('content')
<!-- Hero -->
<section style="background: linear-gradient(135deg, #166534 0%, #15803D 100%); padding: 48px 24px; text-align: center;">
    <div style="max-width: 800px; margin: 0 auto;">
        <h1 style="font-size: 36px; font-weight: 800; color: #FFFFFF; margin-bottom: 12px;">
            {{ app()->getLocale() == 'ar' ? 'سياسة التحكيم' : 'Arbitration Policy' }}
        </h1>
        <p style="color: #DCFCE7; font-size: 18px;">
            {{ app()->getLocale() == 'ar' ? 'كيفية حل النزاعات بين الطلاب والمعلمين' : 'How disputes between students and tutors are resolved' }}
        </p>
    </div>
</section>

<div style="max-width: 800px; margin: 0 auto; padding: 40px 24px;">


    <div style="display: flex; flex-direction: column; gap: 24px;">
        <div style="background: white; border-radius: 16px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="width: 40px; height: 40px; background: #ECFDF0; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">⚖️</div>
                <h2 style="font-size: 20px; font-weight: 700; color: #14532D; margin: 0;">
                    {{ app()->getLocale() == 'ar' ? 'نظرة عامة' : 'Overview' }}
                </h2>
            </div>
            <p style="color: #4b5563; line-height: 1.8;">
                {{ app()->getLocale() == 'ar' ? 'نظام التحكيم في OstazON مصمم لحل النزاعات بين الطلاب والمعلمين بطريقة عادلة وشفافة. عندما تختار ضمان المنصة عند الحجز، يتم تجميد أموالك حتى اكتمال الحصة بنجاح. إذا نشأ نزاع، يمكن لأي من الطرفين تقديم دعوى خلال 7 أيام من اكتمال الحصة.' : 'OstazON\'s arbitration system is designed to resolve disputes between students and tutors fairly and transparently. When you choose platform guarantee at booking, your funds are frozen until the lesson is completed successfully. If a dispute arises, either party can file a claim within 7 days of lesson completion.' }}
            </p>
        </div>

        <div style="background: white; border-radius: 16px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="width: 40px; height: 40px; background: #FEF3C7; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">📋</div>
                <h2 style="font-size: 20px; font-weight: 700; color: #14532D; margin: 0;">
                    {{ app()->getLocale() == 'ar' ? 'كيفية تقديم دعوى' : 'How to File a Claim' }}
                </h2>
            </div>
            <ol style="color: #4b5563; line-height: 2; padding-left: 20px;">
                <li>{{ app()->getLocale() == 'ar' ? 'تأكد من أن الحصة مكتملة وأن نافذة الـ 7 أيام لم تنتهِ' : 'Ensure the lesson is completed and the 7-day window has not closed' }}</li>
                <li>{{ app()->getLocale() == 'ar' ? 'اذهب إلى صفحة الحجز واضغط على "تقديم دعوى"' : 'Go to the booking page and click "File a Claim"' }}</li>
                <li>{{ app()->getLocale() == 'ar' ? 'قدم سبب النزاع (20 حرفاً على الأقل) وأي أدلة تدعم قضيتك' : 'Provide the reason for dispute (at least 20 characters) and any supporting evidence' }}</li>
                <li>{{ app()->getLocale() == 'ar' ? 'سيتم خصم رسوم تحكيم قدرها 20% من قيمة الحصة' : 'An arbitration fee of 20% of the lesson value will be deducted' }}</li>
                <li>{{ app()->getLocale() == 'ar' ? 'سيراجع فريق التحكيم القضية خلال 48 ساعة' : 'Our arbitration team will review the case within 48 hours' }}</li>
            </ol>
        </div>

        <div style="background: white; border-radius: 16px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="width: 40px; height: 40px; background: #DBEAFE; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">💰</div>
                <h2 style="font-size: 20px; font-weight: 700; color: #14532D; margin: 0;">
                    {{ app()->getLocale() == 'ar' ? 'الرسوم والتوقيت' : 'Fees & Timing' }}
                </h2>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div style="background: #F9FAFB; padding: 16px; border-radius: 12px; text-align: center;">
                    <div style="font-size: 28px; font-weight: 800; color: #166534;">7</div>
                    <div style="font-size: 13px; color: #4b5563;">{{ app()->getLocale() == 'ar' ? 'أيام للنزاع' : 'Days to dispute' }}</div>
                </div>
                <div style="background: #F9FAFB; padding: 16px; border-radius: 12px; text-align: center;">
                    <div style="font-size: 28px; font-weight: 800; color: #D97706;">20%</div>
                    <div style="font-size: 13px; color: #4b5563;">{{ app()->getLocale() == 'ar' ? 'رسوم التحكيم' : 'Arbitration fee' }}</div>
                </div>
                <div style="background: #F9FAFB; padding: 16px; border-radius: 12px; text-align: center;">
                    <div style="font-size: 28px; font-weight: 800; color: #166534;">48</div>
                    <div style="font-size: 13px; color: #4b5563;">{{ app()->getLocale() == 'ar' ? 'ساعة للمراجعة' : 'Hours to review' }}</div>
                </div>
                <div style="background: #F9FAFB; padding: 16px; border-radius: 12px; text-align: center;">
                    <div style="font-size: 28px; font-weight: 800; color: #10B981;">7</div>
                    <div style="font-size: 13px; color: #4b5563;">{{ app()->getLocale() == 'ar' ? 'أيام تجميد الأموال' : 'Days funds frozen' }}</div>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="width: 40px; height: 40px; background: #FCE7F3; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">✅</div>
                <h2 style="font-size: 20px; font-weight: 700; color: #14532D; margin: 0;">
                    {{ app()->getLocale() == 'ar' ? 'نتائج التحكيم' : 'Arbitration Outcomes' }}
                </h2>
            </div>
            <ul style="color: #4b5563; line-height: 2; padding-left: 20px;">
                <li>{{ app()->getLocale() == 'ar' ? 'إذا حكم لصالح الطالب: يسترد الطالب المبلغ كاملاً، ويدفع المعلم رسوم التحكيم' : 'If ruled in favor of the student: Full refund to student, tutor pays arbitration fee' }}</li>
                <li>{{ app()->getLocale() == 'ar' ? 'إذا حكم لصالح المعلم: يحصل المعلم على المبلغ كاملاً، ويدفع الطالب رسوم التحكيم' : 'If ruled in favor of the tutor: Full payment to tutor, student pays arbitration fee' }}</li>
                <li>{{ app()->getLocale() == 'ar' ? 'إذا كان الطرفان مسؤولين: يتم تقسيم المبلغ بعد خصم رسوم التحكيم' : 'If both parties are at fault: Amount is split after deducting arbitration fee' }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection
