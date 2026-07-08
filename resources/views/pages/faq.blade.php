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
                'a' => $ar ? 'أستاذ أون هي منصة تعليمية تربط الطلاب بأفضل المعلمين المعتمدين. يمكن للطلاب البحث عن معلمين في مختلف المواد الدراسية، حجز حصص خصوصية أونلاين أو حضوري، ومشاهدة فيديوهات تعريفية للمعلمين قبل الاختيار. توفر المنصة نظام ضمان لتجميد قيمة الحصة حتى اكتمالها بنجاح، ونظام تحكيم لحل أي نزاعات. يمكن للمعلمين المسجلين عرض خدماتهم، وتحديد أوقاتهم، وأسعارهم، وإدارة حجوزاتهم بسهولة.' : 'OstazON is an educational platform connecting students with verified tutors. Students can search for tutors across various subjects, book private lessons online or in-person, and watch tutor intro videos before choosing. The platform offers a guarantee system to freeze lesson fees until successful completion, plus an arbitration system to resolve any disputes. Registered tutors can showcase their services, set their own schedules and rates, and manage bookings easily.',
            ],
            [
                'q' => $ar ? 'كيف يمكنني التسجيل كطالب؟' : 'How do I sign up as a student?',
                'a' => $ar ? 'يمكنك التسجيل بسهولة بالضغط على زر "تسجيل" في أعلى الصفحة. ستقوم بإدخال اسمك وبريدك الإلكتروني وكلمة المرور، وسيتم تفعيل حسابك فوراً.' : 'Click the "Register" button at the top of the page. Enter your name, email, and password, and your account will be activated immediately.',
            ],
            [
                'q' => $ar ? 'كيف أصبح معلماً على المنصة؟' : 'How do I become a tutor?',
                'a' => $ar ? 'بعد التسجيل، اذهب إلى لوحة التحكم واختر "التسجيل كمعلم". ستحتاج إلى تقديم مؤهلاتك ورفع فيديو تعريفي وصورة هوية وشهادة للتحقق من هويتك.' : 'After registering, go to your dashboard and select "Become a Tutor". You will need to provide your qualifications, upload an intro video, ID, and certificate for verification.',
            ],
            [
                'q' => $ar ? 'ما هي رسوم المنصة؟' : 'What are the platform fees?',
                'a' => $ar ? 'OstazON تحتفظ بـ 15% من قيمة كل حصة دراسية كمقابل لخدمات المنصة. الـ 85% المتبقية تذهب للمعلم فور اكتمال الحصة بنجاح.' : 'OstazON retains 15% of each lesson fee as a platform service fee. The remaining 85% goes to the tutor upon successful lesson completion.',
            ],
            [
                'q' => $ar ? 'كيف تعمل عملات المنصة (Coins)؟' : 'How do platform coins work?',
                'a' => $ar ? 'العملات تستخدم لشراء خدمات متميزة مثل نشر طلبات التدريس (10 عملات لكل طلب) والكشف عن معلومات الاتصال بالمعلمين (10 عملات). يمكنك شراء العملات من صفحة العملات في لوحة التحكم.' : 'Coins are used for premium features like posting tutoring requests (10 coins per request) and revealing tutor contact information (10 coins). You can purchase coins from the Coins page in your dashboard.',
            ],
            [
                'q' => $ar ? 'كيف يمكنني شحن العملات؟' : 'How do I recharge coins?',
                'a' => $ar ? '١- اذهب إلى لوحة التحكم ← "اشترِ عملات". ٢- اختر كمية العملات التي تريدها (50 إلى 1000 عملة). ٣- اختر طريقة الدفع (فودافون كاش، إنستاباي، أو تحويل بنكي). ٤- حول المبلغ إلى حساب المنصة الموضح في الصفحة. ٥- أدخل رقم المرجع وأرفع صورة الإثبات (اختياري). ٦- اضغط "إرسال طلب الشراء". سيقوم فريق الإدارة بالتحقق من الدفع وإضافة العملات إلى حسابك يدوياً خلال 24 ساعة.' : '1. Go to your dashboard → "Buy Coins". 2. Choose the amount (50 to 1000 coins). 3. Select payment method (Vodafone Cash, InstaPay, or Bank Transfer). 4. Transfer the amount to the platform account shown on the page. 5. Enter the transaction reference and upload proof screenshot (optional). 6. Click "Submit Purchase Request". Our admin team will verify the payment and credit the coins to your account within 24 hours.',
            ],
            [
                'q' => $ar ? 'كيف يمكنني نشر طلب تدريس؟' : 'How do I post a tutoring request?',
                'a' => $ar ? 'إذا لم تجد معلماً مناسباً، يمكنك نشر طلب تدريس! اذهب إلى لوحة التحكم، اضغط على "قدم طلباً"، ثم اختر المادة الدراسية وأضف وصفاً مفصلاً لمتطلباتك. بعد النشر، سيتمكن المعلمون المسجلون من رؤية طلبك وتقديم عروضهم. يمكنك مراجعة العروض في صفحة "طلباتي" وقبول العرض المناسب. تكلفة نشر الطلب هي 10 عملات فقط.' : "If you can't find a suitable tutor, you can post a tutoring request! Go to your dashboard, click \"Post a Request\", then choose the subject and add a detailed description of your requirements. Once posted, registered tutors will be able to see your request and submit their proposals. You can review proposals in the \"My Requests\" page and accept the best fit. Posting a request costs only 10 coins.",
            ],
            [
                'q' => $ar ? 'كيف يمكنني حجز حصة دراسية؟' : 'How do I book a lesson?',
                'a' => $ar ? 'تصفح صفحة المعلمين، اختر المعلم المناسب، ثم اضغط على "حجز حصة". اختر الوقت المناسب ويمكنك اختيار ضمان المنصة لتجميد المبلغ حتى اكتمال الحصة.' : 'Browse the tutors page, select your preferred tutor, and click "Book a Lesson". Choose a suitable time and optionally select platform guarantee to freeze the amount until lesson completion.',
            ],
            [
                'q' => $ar ? 'ماذا يحدث إذا ألغيت الحصة؟' : 'What happens if I cancel a lesson?',
                'a' => $ar ? 'يمكنك إلغاء الحصة قبل بدايتها. إذا تم الإلغاء قبل 24 ساعة من موعد الحصة، تسترد المبلغ كاملاً. إذا كان الإلغاء خلال 24 ساعة، قد يتم تطبيق رسوم إلغاء حسب سياسة المعلم.' : 'You can cancel a lesson before it starts. If cancelled 24+ hours before the scheduled time, you get a full refund. Cancellations within 24 hours may incur a fee depending on the tutor\'s policy.',
            ],
            [
                'q' => $ar ? 'كيف يتم حل النزاعات؟' : 'How are disputes resolved?',
                'a' => $ar ? 'إذا اخترت ضمان المنصة عند الحجز، يمكنك تقديم دعوى تحكيم خلال 7 أيام من اكتمال الحصة. سيقوم فريق التحكيم بمراجعة القضية خلال 48 ساعة. رسوم التحكيم هي 20% من قيمة الحصة.' : 'If you selected platform guarantee at booking, you can file an arbitration claim within 7 days of lesson completion. The arbitration team will review the case within 48 hours. The arbitration fee is 20% of the lesson value.',
            ],
            [
                'q' => $ar ? 'كيف يمكنني التواصل مع المعلم قبل الحجز؟' : 'How can I contact a tutor before booking?',
                'a' => $ar ? 'يمكنك استخدام نظام المحادثة المدمج بعد تسجيل الدخول. اذهب إلى صفحة المعلم واضغط على "إرسال رسالة" لبدء محادثة. إذا كنت تريد رقم الهاتف أو البريد الإلكتروني، يمكنك استخدام خاصية الكشف عن جهة الاتصال مقابل 10 عملات.' : 'You can use the built-in chat system after logging in. Go to the tutor\'s page and click "Send Message" to start a conversation. For phone or email, use the contact reveal feature for 10 coins.',
            ],
            [
                'q' => $ar ? 'هل يمكنني شراء وبيع المحتوى التعليمي؟' : 'Can I buy and sell educational content?',
                'a' => $ar ? 'نعم! يمكن للمعلمين رفع وبيع المواد التعليمية مثل الكتب الإلكترونية، وملفات PDF، ومقاطع الفيديو المسجلة في سوق المحتوى. يمكن للطلاب شراء المحتوى باستخدام طرق الدفع المتاحة.' : 'Yes! Tutors can upload and sell educational materials like e-books, PDFs, and recorded videos in the Content Marketplace. Students can purchase content using available payment methods.',
            ],
            [
                'q' => $ar ? 'كيف أسحب أرباحي كمعلم؟' : 'How do I withdraw my earnings as a tutor?',
                'a' => $ar ? 'اذهب إلى صفحة الأرباح في لوحة تحكم المعلم واضغط على "سحب الأرباح". سيتم تحويل المبلغ إلى حسابك البنكي خلال 3-5 أيام عمل. الحد الأدنى للسحب هو 20 دولاراً.' : 'Go to the Earnings page in your tutor dashboard and click "Withdraw". The amount will be transferred to your bank account within 3-5 business days. The minimum withdrawal amount is $20.',
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
