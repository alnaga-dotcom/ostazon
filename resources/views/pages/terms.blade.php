@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions')

@section('content')
<section style="background: linear-gradient(135deg, #166534 0%, #15803D 100%); padding: 48px 24px; text-align: center;">
    <div style="max-width: 800px; margin: 0 auto;">
        <h1 style="font-size: 36px; font-weight: 800; color: #FFFFFF; margin-bottom: 12px;">
            {{ app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions' }}
        </h1>
        <p style="color: #DCFCE7; font-size: 16px;">
            {{ app()->getLocale() == 'ar' ? 'آخر تحديث: يوليو 2026' : 'Last updated: July 2026' }}
        </p>
    </div>
</section>

<div style="max-width: 800px; margin: 0 auto; padding: 40px 24px;">
    @php $ar = app()->getLocale() == 'ar'; @endphp

    <!-- 1. General Terms -->
    <div style="background: white; border-radius: 16px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <div style="width: 40px; height: 40px; background: #ECFDF0; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">📜</div>
            <h2 style="font-size: 20px; font-weight: 700; color: #14532D; margin: 0;">
                {{ $ar ? 'الشروط العامة' : 'General Terms' }}
            </h2>
        </div>
        <div style="color: #4b5563; line-height: 1.8; display: flex; flex-direction: column; gap: 16px;">
            <p>{{ $ar ? 'باستخدام منصة OstazON، فإنك توافق على الالتزام بهذه الشروط والأحكام. إذا كنت لا توافق على أي جزء من هذه الشروط، يجب عليك عدم استخدام المنصة.' : 'By using OstazON, you agree to comply with these terms and conditions. If you do not agree with any part of these terms, you must not use the platform.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'الحسابات' : 'Accounts' }}</h3>
            <p>{{ $ar ? 'يجب عليك إنشاء حساب لاستخدام خدماتنا. أنت مسؤول عن الحفاظ على سرية معلومات حسابك وكلمة المرور. يجب أن تكون معلومات الحساب دقيقة وكاملة ومحدثة.' : 'You must create an account to use our services. You are responsible for maintaining the confidentiality of your account and password. Account information must be accurate, complete, and up-to-date.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'المعلمون' : 'Tutors' }}</h3>
            <p>{{ $ar ? 'يجب على المعلمين تقديم معلومات دقيقة عن مؤهلاتهم وخبراتهم. تخضع جميع المعلمين لعملية تحقق. تحتفظ OstazON بالحق في رفض أو إلغاء تسجيل أي معلم لا يستوفي معاييرنا.' : 'Tutors must provide accurate information about their qualifications and experience. All tutors undergo a verification process. OstazON reserves the right to reject or revoke any tutor registration that does not meet our standards.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'الطلاب' : 'Students' }}</h3>
            <p>{{ $ar ? 'يتعهد الطلاب باستخدام المنصة للأغراض التعليمية فقط. يجب على الطلاب احترام المعلمين والالتزام بمواعيد الحصص المتفق عليها.' : 'Students agree to use the platform for educational purposes only. Students must respect tutors and adhere to agreed lesson schedules.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'رسوم المنصة' : 'Platform Fees' }}</h3>
            <p>{{ $ar ? 'تحتفظ OstazON بنسبة 15% من قيمة كل حصة دراسية كرسوم خدمة. تذهب النسبة المتبقية (85%) إلى المعلم بعد اكتمال الحصة بنجاح. جميع الرسوم واضحة وشفافة قبل تأكيد الحجز.' : 'OstazON retains 15% of each lesson fee as a service fee. The remaining 85% goes to the tutor upon successful lesson completion. All fees are clearly displayed before booking confirmation.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'الملكية الفكرية' : 'Intellectual Property' }}</h3>
            <p>{{ $ar ? 'جميع المحتويات المنشورة على المنصة بما في ذلك المواد التعليمية والنصوص والصور محمية بموجب قوانين الملكية الفكرية. لا يجوز نسخ أو توزيع أو إعادة استخدام أي محتوى دون إذن صريح.' : 'All content published on the platform including educational materials, text, and images is protected by intellectual property laws. Content may not be copied, distributed, or reused without explicit permission.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'تحديد المسؤولية' : 'Limitation of Liability' }}</h3>
            <p>{{ $ar ? 'OstazON هي منصة وسيطة بين الطلاب والمعلمين. نحن لسنا مسؤولين بشكل مباشر عن جودة التعليم المقدم أو سلوك أي من الطرفين. أقصى مسؤولية لـ OstazON تقتصر على قيمة الحصة المعنية.' : 'OstazON is an intermediary platform between students and tutors. We are not directly liable for the quality of education provided or the conduct of either party. OstazON\'s maximum liability is limited to the value of the lesson in question.' }}</p>
        </div>
    </div>

    <!-- 2. Money-Back Guarantee -->
    <div style="background: white; border-radius: 16px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <div style="width: 40px; height: 40px; background: #FEF3C7; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">🛡️</div>
            <h2 style="font-size: 20px; font-weight: 700; color: #14532D; margin: 0;">
                {{ $ar ? 'ضمان استرداد المال' : 'Money-Back Guarantee' }}
            </h2>
        </div>
        <div style="color: #4b5563; line-height: 1.8; display: flex; flex-direction: column; gap: 16px;">
            <p>{{ $ar ? 'نحن نضمن رضاك عن أول حصة لك على OstazON. إذا لم تكن راضياً، سنقوم باسترداد المبلغ بالكامل.' : 'We guarantee your satisfaction with your first lesson on OstazON. If you are not satisfied, we will refund the full amount.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'الشروط' : 'Eligibility' }}</h3>
            <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 8px;">
                <li>{{ $ar ? 'يجب اختيار "ضمان المنصة" عند الحجز' : 'Must select "Platform Guarantee" at booking' }}</li>
                <li>{{ $ar ? 'يجب تقديم طلب الاسترداد خلال 48 ساعة من انتهاء الحصة' : 'Refund request must be submitted within 48 hours of lesson completion' }}</li>
                <li>{{ $ar ? 'الضمان ساري فقط على أول حصة مع كل معلم' : 'The guarantee applies only to the first lesson with each tutor' }}</li>
                <li>{{ $ar ? 'يجب تقديم سبب معقول لطلب الاسترداد' : 'A reasonable reason for the refund must be provided' }}</li>
            </ul>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'عملية الاسترداد' : 'Refund Process' }}</h3>
            <ol style="padding-left: 20px; display: flex; flex-direction: column; gap: 8px;">
                <li>{{ $ar ? 'اذهب إلى صفحة الحجز واضغط على "طلب استرداد"' : 'Go to the booking page and click "Request Refund"' }}</li>
                <li>{{ $ar ? 'قدم سبب طلبك (اختياري)' : 'Provide your reason (optional)' }}</li>
                <li>{{ $ar ? 'سيتم مراجعة طلبك خلال 24 ساعة' : 'Your request will be reviewed within 24 hours' }}</li>
                <li>{{ $ar ? 'في حالة الموافقة، سيتم إرجاع المبلغ إلى رصيد العملات الخاص بك' : 'If approved, the amount will be returned to your coin wallet' }}</li>
            </ol>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'الاستثناءات' : 'Exclusions' }}</h3>
            <p>{{ $ar ? 'لا ينطبق الضمان في الحالات التالية: عدم حضور الطالب للحصة، إلغاء الحصة بعد بدئها، أو إذا كان سبب عدم الرضا خارج نطاق سيطرة المعلم (مثل مشكلات تقنية من طرف الطالب).' : 'The guarantee does not apply in the following cases: student no-show, cancellation after the lesson has started, or if the reason for dissatisfaction is outside the tutor\'s control (e.g. technical issues on the student\'s side).' }}</p>
        </div>
    </div>

    <!-- 3. Arbitration Policy -->
    <div style="background: white; border-radius: 16px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <div style="width: 40px; height: 40px; background: #FCE7F3; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">⚖️</div>
            <h2 style="font-size: 20px; font-weight: 700; color: #14532D; margin: 0;">
                {{ $ar ? 'سياسة التحكيم' : 'Arbitration Policy' }}
            </h2>
        </div>
        <div style="color: #4b5563; line-height: 1.8; display: flex; flex-direction: column; gap: 16px;">
            <p>{{ $ar ? 'نظام التحكيم في OstazON مصمم لحل النزاعات بين الطلاب والمعلمين بطريقة عادلة وشفافة.' : 'The OstazON arbitration system is designed to resolve disputes between students and tutors fairly and transparently.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'تقديم دعوى' : 'Filing a Claim' }}</h3>
            <ol style="padding-left: 20px; display: flex; flex-direction: column; gap: 8px;">
                <li>{{ $ar ? 'تأكد من اكتمال الحصة واختيار ضمان المنصة عند الحجز' : 'Ensure the lesson is completed and platform guarantee was selected' }}</li>
                <li>{{ $ar ? 'يجب تقديم الدعوى خلال 7 أيام من اكتمال الحصة' : 'Claims must be filed within 7 days of lesson completion' }}</li>
                <li>{{ $ar ? 'قدم سبب النزاع (20 حرفاً على الأقل) مع أي أدلة' : 'Provide the dispute reason (at least 20 characters) with any evidence' }}</li>
                <li>{{ $ar ? 'سيتم خصم رسوم تحكيم قدرها 20% من قيمة الحصة' : 'An arbitration fee of 20% of the lesson value will be deducted' }}</li>
            </ol>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'المراجعة والقرار' : 'Review & Decision' }}</h3>
            <p>{{ $ar ? 'سيراجع فريق التحكيم القضية خلال 48 ساعة من تقديم الدعوى. سيتم النظر في الأدلة المقدمة من الطرفين واتخاذ قرار بناءً على سياسات المنصة.' : 'The arbitration team will review the case within 48 hours of filing. Evidence from both parties will be considered and a decision will be made based on platform policies.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'النتائج المحتملة' : 'Possible Outcomes' }}</h3>
            <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 8px;">
                <li>{{ $ar ? 'الحكم لصالح الطالب: يسترد الطالب المبلغ كاملاً، ويدفع المعلم رسوم التحكيم' : 'In favor of the student: Full refund to student, tutor pays arbitration fee' }}</li>
                <li>{{ $ar ? 'الحكم لصالح المعلم: يحصل المعلم على المبلغ كاملاً، ويدفع الطالب رسوم التحكيم' : 'In favor of the tutor: Full payment to tutor, student pays arbitration fee' }}</li>
                <li>{{ $ar ? 'المسؤولية المشتركة: تقسيم المبلغ بعد خصم رسوم التحكيم' : 'Shared responsibility: Amount split after deducting arbitration fee' }}</li>
            </ul>

            <p style="font-size: 14px; color: #9CA3AF; margin-top: 8px;">
                {{ $ar ? 'جميع قرارات التحكيم نهائية وملزمة للطرفين.' : 'All arbitration decisions are final and binding on both parties.' }}
            </p>
        </div>
    </div>
</div>
@endsection
