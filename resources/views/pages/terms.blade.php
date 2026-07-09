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

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'التواصل داخل المنصة' : 'On-Platform Communication' }}</h3>
            <p>{{ $ar ? 'جميع التواصل بين الطلاب والمعلمين يتم عبر نظام المحادثة المدمج في المنصة. يمنع منعاً باتاً مشاركة أرقام الهواتف أو عناوين البريد الإلكتروني أو أي معلومات اتصال في الرسائل. المخالفون يتعرضون لإيقاف الحساب.' : 'All communication between students and tutors must take place through the platform\'s built-in chat system. Sharing phone numbers, email addresses, or any contact information in messages is strictly prohibited. Violators risk account suspension.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'رسوم المنصة' : 'Platform Fees' }}</h3>
            <p>{{ $ar ? 'تحتفظ OstazON بنسبة 5% من قيمة كل حصة دراسية كرسوم خدمة. تذهب النسبة المتبقية (95%) إلى المعلم فور اكتمال الحصة بنجاح. يمكن تعديل النسبة من قبل الإدارة وسيتم إشعار المستخدمين بأي تغييرات.' : 'OstazON retains 5% of each lesson fee as a service fee. The remaining 95% goes to the tutor immediately upon successful lesson completion. The percentage may be adjusted by management with prior notice to users.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'سحب أرباح المعلمين' : 'Tutor Withdrawals' }}</h3>
            <p>{{ $ar ? 'يمكن للمعلمين سحب أرباحهم عندما يصل الرصيد المتاح إلى 500 جنيه أو أكثر. يتم طلب السحب من لوحة تحكم المعلم وتتم معالجته يدوياً من قبل الإدارة.' : 'Tutors can withdraw their earnings once their available balance reaches 500 EGP or more. Withdrawal requests are submitted from the tutor dashboard and processed manually by the admin team.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'الملكية الفكرية' : 'Intellectual Property' }}</h3>
            <p>{{ $ar ? 'جميع المحتويات المنشورة على المنصة بما في ذلك المواد التعليمية والنصوص والصور محمية بموجب قوانين الملكية الفكرية. لا يجوز نسخ أو توزيع أو إعادة استخدام أي محتوى دون إذن صريح.' : 'All content published on the platform including educational materials, text, and images is protected by intellectual property laws. Content may not be copied, distributed, or reused without explicit permission.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'تحديد المسؤولية' : 'Limitation of Liability' }}</h3>
            <p>{{ $ar ? 'OstazON هي منصة وسيطة بين الطلاب والمعلمين. نحن لسنا مسؤولين بشكل مباشر عن جودة التعليم المقدم أو سلوك أي من الطرفين. أقصى مسؤولية لـ OstazON تقتصر على قيمة الحصة المعنية.' : 'OstazON is an intermediary platform between students and tutors. We are not directly liable for the quality of education provided or the conduct of either party. OstazON\'s maximum liability is limited to the value of the lesson in question.' }}</p>
        </div>
    </div>

    <!-- 2. Platform Guarantee -->
    <div style="background: white; border-radius: 16px; padding: 28px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <div style="width: 40px; height: 40px; background: #FEF3C7; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">🛡️</div>
            <h2 style="font-size: 20px; font-weight: 700; color: #14532D; margin: 0;">
                {{ $ar ? 'ضمان المنصة' : 'Platform Guarantee' }}
            </h2>
        </div>
        <div style="color: #4b5563; line-height: 1.8; display: flex; flex-direction: column; gap: 16px;">
            <p>{{ $ar ? 'جميع الحجوزات على OstazON مشمولة بضمان المنصة إلزامياً. يتم خصم قيمة الحصة من عملات الطالب عند الحجز وإيداعها للمعلم فور اكتمال الحصة بنجاح.' : 'All bookings on OstazON are covered by the platform guarantee. The lesson fee is deducted from the student\'s coins at booking and released to the tutor immediately upon successful lesson completion.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'الإلغاء والاسترداد' : 'Cancellation & Refund' }}</h3>
            <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 8px;">
                <li>{{ $ar ? 'يمكن إلغاء الحصة قبل بدايتها فقط' : 'Lessons can only be cancelled before they start' }}</li>
                <li>{{ $ar ? 'في حالة الإلغاء قبل البدء، يسترد الطالب المبلغ كاملاً في رصيد العملات' : 'If cancelled before start, the student receives a full refund to their coin balance' }}</li>
                <li>{{ $ar ? 'بعد اكتمال الحصة، يتم تحويل المبلغ للمعلم فوراً' : 'After lesson completion, the amount is immediately released to the tutor' }}</li>
            </ul>
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
                <li>{{ $ar ? 'يمكن تقديم النزاع خلال 7 أيام من اكتمال الحصة' : 'Disputes can be filed within 7 days of lesson completion' }}</li>
                <li>{{ $ar ? 'قدم سبب النزاع (20 حرفاً على الأقل) مع أي أدلة' : 'Provide the dispute reason (at least 20 characters) with any evidence' }}</li>
                <li>{{ $ar ? 'سيتم خصم رسوم تحكيم قدرها 20% من قيمة الحصة من مقدم النزاع' : 'An arbitration fee of 20% of the lesson value will be deducted from the filer' }}</li>
                <li>{{ $ar ? 'عند تقديم النزاع، يتم تجميد قيمة الحصة في حساب المعلم لحين البت' : 'When a dispute is filed, the lesson amount is frozen in the tutor\'s balance until resolution' }}</li>
            </ol>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'المراجعة والقرار' : 'Review & Decision' }}</h3>
            <p>{{ $ar ? 'سيراجع فريق التحكيم القضية خلال 48 ساعة من تقديم الدعوى. سيتم النظر في الأدلة المقدمة من الطرفين واتخاذ قرار بناءً على سياسات المنصة.' : 'The arbitration team will review the case within 48 hours of filing. Evidence from both parties will be considered and a decision will be made based on platform policies.' }}</p>

            <h3 style="font-weight: 700; color: #14532D; margin: 0;">{{ $ar ? 'النتائج المحتملة' : 'Possible Outcomes' }}</h3>
            <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 8px;">
                <li>{{ $ar ? 'الحكم لصالح الطالب: يسترد الطالب العملات، ويتم خصم المبلغ من رصيد المعلم' : 'In favor of the student: Student gets full coin refund, amount deducted from tutor balance' }}</li>
                <li>{{ $ar ? 'الحكم لصالح المعلم: يُطلق المبلغ المجمد للمعلم، ويدفع الطالب رسوم التحكيم' : 'In favor of the tutor: Frozen amount released to tutor, student pays arbitration fee' }}</li>
                <li>{{ $ar ? 'رفض الدعوى: يُطلق المبلغ للمعلم مع احتفاظه برسوم التحكيم' : 'Claim rejected: Amount released to tutor, arbitration fee retained' }}</li>
            </ul>

            <p style="font-size: 14px; color: #9CA3AF; margin-top: 8px;">
                {{ $ar ? 'جميع قرارات التحكيم نهائية وملزمة للطرفين.' : 'All arbitration decisions are final and binding on both parties.' }}
            </p>
        </div>
    </div>
</div>
@endsection
