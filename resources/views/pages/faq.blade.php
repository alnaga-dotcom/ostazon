@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'الأسئلة الشائعة' : 'FAQ')

@section('content')
<!-- Hero -->
<section style="background: linear-gradient(135deg, #166534 0%, #15803D 100%); padding: 48px 24px; text-align: center;">
    <div style="max-width: 800px; margin: 0 auto;">
        <h1 style="font-size: 36px; font-weight: 800; color: #FFFFFF; margin-bottom: 12px;">
            {{ app()->getLocale() == 'ar' ? 'الأسئلة الشائعة' : 'Frequently Asked Questions' }}
        </h1>
        <p style="color: #DCFCE7; font-size: 18px;">
            {{ app()->getLocale() == 'ar' ? 'إجابات على أكثر الأسئلة شيوعاً' : 'Answers to the most common questions' }}
        </p>
    </div>
</section>

<div style="max-width: 800px; margin: 0 auto; padding: 40px 24px;">
    @php
        $ar = app()->getLocale() == 'ar';
        $faqs = [
            [
                'q' => $ar ? 'ما هي منصة أستاذ أون؟' : 'What is OstazON?',
                'a' => $ar ? 'أستاذ أون هي منصة تعليمية تربط الطلاب بأفضل المعلمين المعتمدين. يمكن للطلاب البحث عن معلمين في مختلف المواد الدراسية، حجز حصص خصوصية أونلاين أو حضوري، ومشاهدة فيديوهات تعريفية للمعلمين قبل الاختيار. توفر المنصة نظام ضمان لحجز الحصص عبر العملات، ونظام تحكيم لحل أي نزاعات. يمكن للمعلمين المسجلين عرض خدماتهم، وتحديد أوقاتهم، وأسعارهم، وإدارة حجوزاتهم بسهولة.' : 'OstazON is an educational platform connecting students with verified tutors. Students can search for tutors across various subjects, book private lessons online or in-person, and watch tutor intro videos before choosing. The platform offers a coin-based booking system with full guarantee, plus an arbitration system to resolve any disputes. Registered tutors can showcase their services, set their own schedules and rates, and manage bookings easily.',
            ],
            [
                'q' => $ar ? 'كيف يمكنني التسجيل كطالب؟' : 'How do I sign up as a student?',
                'a' => $ar ? 'يمكنك التسجيل بسهولة بالضغط على زر "تسجيل" في أعلى الصفحة. ستقوم بإدخال اسمك وبريدك الإلكتروني وكلمة المرور، وسيتم تفعيل حسابك فوراً. تحصل الطلاب الجدد على 40 عملة مجانية كهدية ترحيبية!' : 'Click the "Register" button at the top of the page. Enter your name, email, and password, and your account will be activated immediately. New students get 40 free coins as a welcome bonus!',
            ],
            [
                'q' => $ar ? 'كيف أصبح معلماً على المنصة؟' : 'How do I become a tutor?',
                'a' => $ar ? 'بعد التسجيل، اذهب إلى لوحة التحكم واختر "التسجيل كمعلم". ستحتاج إلى تقديم مؤهلاتك ورفع فيديو تعريفي وصورة هوية وشهادة للتحقق من هويتك. بعد التحقق، يمكنك البدء في استقبال الحجوزات.' : 'After registering, go to your dashboard and select "Become a Tutor". You will need to provide your qualifications, upload an intro video, ID, and certificate for verification. Once verified, you can start receiving bookings.',
            ],
            [
                'q' => $ar ? 'ما هي رسوم المنصة؟' : 'What are the platform fees?',
                'a' => $ar ? 'OstazON تحتفظ بنسبة 5% من قيمة كل حصة دراسية كمقابل لخدمات المنصة. الـ 95% المتبقية تذهب للمعلم فور اكتمال الحصة بنجاح. يمكن للمعلم سحب أرباحه عندما يصل رصيده إلى 500 جنيه أو أكثر.' : 'OstazON retains 5% of each lesson fee as a platform service fee. The remaining 95% goes to the tutor immediately upon successful lesson completion. Tutors can withdraw their earnings once their balance reaches 500 EGP or more.',
            ],
            [
                'q' => $ar ? 'كيف تعمل عملات المنصة (Coins)؟' : 'How do platform coins work?',
                'a' => $ar ? 'العملات تستخدم لحجز الحصص الدراسية ونشر طلبات التدريس (10 عملات لكل طلب). 1 عملة = 1 جنيه مصري. يمكنك شراء العملات من صفحة العملات في لوحة التحكم عبر فودافون كاش أو إنستاباي أو تحويل بنكي أو باي بال. يحصل الطلاب الجدد على 40 عملة مجانية.' : 'Coins are used to book lessons and post tutoring requests (10 coins per request). 1 coin = 1 EGP. You can purchase coins from the Coins page in your dashboard via Vodafone Cash, InstaPay, Bank Transfer, or PayPal. New students get 40 free coins.',
            ],
            [
                'q' => $ar ? 'كيف يمكنني شحن العملات؟' : 'How do I recharge coins?',
                'a' => $ar ? '١- اذهب إلى لوحة التحكم ← "اشترِ عملات". ٢- اختر كمية العملات (50 إلى 1000 عملة). ٣- اختر طريقة الدفع (فودافون كاش، إنستاباي، تحويل بنكي، أو باي بال). ٤- حول المبلغ إلى حساب المنصة الموضح. ٥- أدخل رقم المرجع وأرفع صورة الإثبات (اختياري). ٦- اضغط "إرسال طلب الشراء". سيتم إضافة العملات بعد التحقق من الدفع.' : '1. Go to your dashboard → "Buy Coins". 2. Choose the amount (50 to 1000 coins). 3. Select payment method (Vodafone Cash, InstaPay, Bank Transfer, or PayPal). 4. Transfer the amount to the platform account shown. 5. Enter the transaction reference and upload proof screenshot (optional). 6. Click "Submit Purchase Request". Coins will be credited after payment verification.',
            ],
            [
                'q' => $ar ? 'كيف يمكنني نشر طلب تدريس؟' : 'How do I post a tutoring request?',
                'a' => $ar ? 'إذا لم تجد معلماً مناسباً، يمكنك نشر طلب تدريس! اذهب إلى لوحة التحكم، اضغط على "قدم طلباً"، ثم اختر المادة الدراسية وأضف وصفاً مفصلاً لمتطلباتك. بعد النشر، سيتمكن المعلمون المسجلون من رؤية طلبك وتقديم عروضهم. تكلفة نشر الطلب هي 10 عملات.' : "If you can't find a suitable tutor, you can post a tutoring request! Go to your dashboard, click \"Post a Request\", then choose the subject and add a detailed description of your requirements. Posting a request costs 10 coins.",
            ],
            [
                'q' => $ar ? 'كيف يتم حجز الحصة الدراسية؟' : 'How does lesson booking work?',
                'a' => $ar ? 'تصفح صفحة المعلمين، اختر المعلم المناسب، ثم اضغط على "حجز حصة". سيتم خصم قيمة الحصة من عملاتك (1 عملة = 1 جنيه). المبلغ يذهب للمعلم فور اكتمال الحصة. جميع الحجوزات مشمولة بضمان المنصة - إذا لم تتم الحصة بنجاح، يمكنك فتح نزاع.' : 'Browse the tutors page, select your preferred tutor, and click "Book a Lesson". The lesson fee is deducted from your coins (1 coin = 1 EGP). The amount is released to the tutor upon lesson completion. All bookings include platform guarantee — if the lesson is not completed successfully, you can file a dispute.',
            ],
            [
                'q' => $ar ? 'ماذا يحدث إذا ألغيت الحصة؟' : 'What happens if I cancel a lesson?',
                'a' => $ar ? 'يمكنك إلغاء الحصة قبل بدايتها وسيتم استرداد المبلغ كاملاً إلى رصيد عملاتك.' : 'You can cancel a lesson before it starts and receive a full refund to your coin balance.',
            ],
            [
                'q' => $ar ? 'كيف يتم حل النزاعات؟' : 'How are disputes resolved?',
                'a' => $ar ? 'يمكنك تقديم نزاع خلال 7 أيام من اكتمال الحصة إذا واجهت مشكلة. سيقوم فريق التحكيم بمراجعة القضية. رسوم التحكيم هي 20% من قيمة الحصة (تخصم من مقدم النزاع). في حال الحكم لصالح الطالب، يسترد العملات كاملة.' : 'You can file a dispute within 7 days of lesson completion if you encounter an issue. The arbitration team will review the case. The arbitration fee is 20% of the lesson value (deducted from the filer). If the student wins, they receive a full refund.',
            ],
            [
                'q' => $ar ? 'كيف يمكنني التواصل مع المعلم قبل الحجز؟' : 'How can I contact a tutor before booking?',
                'a' => $ar ? 'يمكنك استخدام نظام المحادثة المدمج مجاناً. اذهب إلى صفحة المعلم واضغط على "راسلني" لبدء محادثة. يمنع منعاً باتاً مشاركة أرقام الهواتف أو البريد الإلكتروني في المحادثات - جميع التواصل يتم داخل المنصة لضمان حماية الطرفين.' : 'You can use the built-in chat system for free. Go to the tutor\'s page and click "Message" to start a conversation. Sharing phone numbers or email addresses in chat is strictly prohibited — all communication stays on the platform to protect both parties.',
            ],
            [
                'q' => $ar ? 'كيف أسحب أرباحي كمعلم؟' : 'How do I withdraw my earnings as a tutor?',
                'a' => $ar ? 'اذهب إلى صفحة السحب في لوحة تحكم المعلم. الحد الأدنى للسحب هو 500 جنيه. يمكنك السحب عبر تحويل بنكي أو فودافون كاش أو إنستاباي. سيتم معالجة طلب السحب من قبل الإدارة خلال 24-48 ساعة.' : 'Go to the Withdrawals page in your tutor dashboard. The minimum withdrawal is 500 EGP. You can withdraw via Bank Transfer, Vodafone Cash, or InstaPay. Withdrawal requests are processed by admin within 24-48 hours.',
            ],
        ];
    @endphp

    <div style="display: flex; flex-direction: column; gap: 12px;">
        @foreach($faqs as $i => $faq)
            <div style="background: white; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); overflow: hidden;">
                <button onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.icon').classList.toggle('rotate-180');" 
                        style="width: 100%; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 600; color: #14532D; text-align: {{ $ar ? 'right' : 'left' }};">
                    <span>{{ $faq['q'] }}</span>
                    <svg class="icon transition-transform duration-200 rtl-flip" style="width: 20px; height: 20px; color: #166534; flex-shrink: 0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="hidden" style="padding: 0 24px 20px; color: #4b5563; line-height: 1.8; border-top: 1px solid #E5E7EB; {{ $ar ? 'text-align: right;' : '' }}">
                    <p style="margin-top: 16px;">{{ $faq['a'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
