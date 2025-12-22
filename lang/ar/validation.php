<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | تحتوي خطوط اللغة التالية على رسائل الخطأ الافتراضية التي يستخدمها
    | كلاس المصدق (Validator). بعض هذه القواعد لها نسخ متعددة مثل قواعد الحجم.
    | لا تتردد في تعديل كل رسالة حسب حاجتك.
    |
    */

    'accepted'             => 'يجب قبول حقل :attribute.',
    'accepted_if'          => 'يجب قبول حقل :attribute عندما يكون :other هو :value.',
    'active_url'           => 'يجب أن يكون حقل :attribute رابطًا صحيحًا.',
    'after'                => 'يجب أن يكون حقل :attribute تاريخًا بعد :date.',
    'after_or_equal'       => 'يجب أن يكون حقل :attribute تاريخًا بعد أو يساوي :date.',
    'alpha'                => 'يجب أن يحتوي حقل :attribute على حروف فقط.',
    'alpha_dash'           => 'يجب أن يحتوي حقل :attribute على حروف، أرقام، شرطات وشرطات سفلية فقط.',
    'alpha_num'            => 'يجب أن يحتوي حقل :attribute على حروف وأرقام فقط.',
    'any_of'               => 'حقل :attribute غير صالح.',
    'array'                => 'يجب أن يكون حقل :attribute مصفوفة.',
    'ascii'                => 'يجب أن يحتوي حقل :attribute على حروف أبجدية رقمية أحادية البايت ورموز فقط.',
    'before'               => 'يجب أن يكون حقل :attribute تاريخًا قبل :date.',
    'before_or_equal'      => 'يجب أن يكون حقل :attribute تاريخًا قبل أو يساوي :date.',
    'between'              => [
        'array'   => 'يجب أن يحتوي حقل :attribute على عدد من العناصر بين :min و :max.',
        'file'    => 'يجب أن يكون حجم ملف حقل :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute بين :min و :max.',
        'string'  => 'يجب أن يكون طول نص حقل :attribute بين :min و :max حروف.',
    ],
    'boolean'              => 'يجب أن تكون قيمة حقل :attribute صحيحة أو خاطئة.',
    'can'                  => 'يحتوي حقل :attribute على قيمة غير مصرح بها.',
    'confirmed'            => 'تأكيد حقل :attribute غير متطابق.',
    'contains'             => 'حقل :attribute يفتقد قيمة مطلوبة.',
    'current_password'     => 'كلمة المرور غير صحيحة.',
    'date'                 => 'يجب أن يكون حقل :attribute تاريخًا صحيحًا.',
    'date_equals'          => 'يجب أن يكون حقل :attribute تاريخًا يساوي :date.',
    'date_format'          => 'يجب أن يتطابق حقل :attribute مع التنسيق :format.',
    'decimal'              => 'يجب أن يحتوي حقل :attribute على :decimal أرقام عشرية.',
    'declined'             => 'يجب رفض حقل :attribute.',
    'declined_if'          => 'يجب رفض حقل :attribute عندما يكون :other هو :value.',
    'different'            => 'يجب أن يكون حقل :attribute و :other مختلفين.',
    'digits'               => 'يجب أن يحتوي حقل :attribute على :digits أرقام.',
    'digits_between'       => 'يجب أن يحتوي حقل :attribute على عدد من الأرقام بين :min و :max.',
    'dimensions'           => 'حقل :attribute يحتوي على أبعاد صورة غير صحيحة.',
    'distinct'             => 'يحتوي حقل :attribute على قيمة مكررة.',
    'doesnt_contain'       => 'يجب ألا يحتوي حقل :attribute على أي من القيم التالية: :values.',
    'doesnt_end_with'      => 'يجب ألا ينتهي حقل :attribute بأي من القيم التالية: :values.',
    'doesnt_start_with'    => 'يجب ألا يبدأ حقل :attribute بأي من القيم التالية: :values.',
    'email'                => 'يجب أن يكون حقل :attribute بريدًا إلكترونيًا صحيحًا.',
    'encoding'             => 'يجب أن يكون حقل :attribute مشفرًا بـ :encoding.',
    'ends_with'            => 'يجب أن ينتهي حقل :attribute بأي من القيم التالية: :values.',
    'enum'                 => 'القيمة المختارة في حقل :attribute غير صحيحة.',
    'exists'               => 'القيمة المختارة في حقل :attribute غير صحيحة.',
    'extensions'           => 'يجب أن يكون حقل :attribute ملفًا من نوع: :values.',
    'file'                 => 'يجب أن يكون حقل :attribute ملفًا.',
    'filled'               => 'يجب أن يحتوي حقل :attribute على قيمة.',
    'gt'                   => [
        'array'   => 'يجب أن يحتوي حقل :attribute على أكثر من :value عنصرًا.',
        'file'    => 'يجب أن يكون حجم ملف حقل :attribute أكبر من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أكبر من :value.',
        'string'  => 'يجب أن يكون طول نص حقل :attribute أكثر من :value حروف.',
    ],
    'gte'                  => [
        'array'   => 'يجب أن يحتوي حقل :attribute على :value عنصرًا أو أكثر.',
        'file'    => 'يجب أن يكون حجم ملف حقل :attribute أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أكبر من أو تساوي :value.',
        'string'  => 'يجب أن يكون طول نص حقل :attribute أكبر من أو يساوي :value حروف.',
    ],
    'hex_color'            => 'يجب أن يكون حقل :attribute لونًا سداسيًا صحيحًا.',
    'image'                => 'يجب أن يكون حقل :attribute صورة.',
    'in'                   => 'القيمة المختارة في حقل :attribute غير صحيحة.',
    'in_array'             => 'يجب أن يكون حقل :attribute موجودًا في :other.',
    'in_array_keys'        => 'يجب أن يحتوي حقل :attribute على مفتاح واحد على الأقل من :values.',
    'integer'              => 'يجب أن يكون حقل :attribute عددًا صحيحًا.',
    'ip'                   => 'يجب أن يكون حقل :attribute عنوان IP صحيحًا.',
    'ipv4'                 => 'يجب أن يكون حقل :attribute عنوان IPv4 صحيحًا.',
    'ipv6'                 => 'يجب أن يكون حقل :attribute عنوان IPv6 صحيحًا.',
    'json'                 => 'يجب أن يكون حقل :attribute نص JSON صحيحًا.',
    'list'                 => 'يجب أن يكون حقل :attribute قائمة.',
    'lowercase'            => 'يجب أن يكون حقل :attribute بحروف صغيرة.',
    'lt'                   => [
        'array'   => 'يجب أن يحتوي حقل :attribute على أقل من :value عنصرًا.',
        'file'    => 'يجب أن يكون حجم ملف حقل :attribute أقل من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أقل من :value.',
        'string'  => 'يجب أن يكون طول نص حقل :attribute أقل من :value حروف.',
    ],
    'lte'                  => [
        'array'   => 'يجب ألا يحتوي حقل :attribute على أكثر من :value عنصرًا.',
        'file'    => 'يجب أن يكون حجم ملف حقل :attribute أقل من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أقل من أو تساوي :value.',
        'string'  => 'يجب أن يكون طول نص حقل :attribute أقل من أو يساوي :value حروف.',
    ],
    'mac_address'          => 'يجب أن يكون حقل :attribute عنوان MAC صحيحًا.',
    'max'                  => [
        'array'   => 'يجب ألا يحتوي حقل :attribute على أكثر من :max عنصرًا.',
        'file'    => 'يجب ألا يتجاوز حجم ملف حقل :attribute :max كيلوبايت.',
        'numeric' => 'يجب ألا تكون قيمة حقل :attribute أكبر من :max.',
        'string'  => 'يجب ألا يكون طول نص حقل :attribute أكبر من :max حروف.',
    ],
    'max_digits'           => 'يجب ألا يحتوي حقل :attribute على أكثر من :max أرقام.',
    'mimes'                => 'يجب أن يكون حقل :attribute ملفًا من النوع: :values.',
    'mimetypes'            => 'يجب أن يكون حقل :attribute ملفًا من النوع: :values.',
    'min'                  => [
        'array'   => 'يجب أن يحتوي حقل :attribute على الأقل على :min عنصرًا.',
        'file'    => 'يجب أن يكون حجم ملف حقل :attribute على الأقل :min كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute على الأقل :min.',
        'string'  => 'يجب أن يكون طول نص حقل :attribute على الأقل :min حروف.',
    ],
    'min_digits'           => 'يجب أن يحتوي حقل :attribute على الأقل على :min أرقام.',
    'missing'              => 'يجب أن يكون حقل :attribute مفقودًا.',
    'missing_if'           => 'يجب أن يكون حقل :attribute مفقودًا عندما يكون :other هو :value.',
    'missing_unless'       => 'يجب أن يكون حقل :attribute مفقودًا إلا إذا كان :other هو :value.',
    'missing_with'         => 'يجب أن يكون حقل :attribute مفقودًا عندما يكون :values موجودًا.',
    'missing_with_all'     => 'يجب أن يكون حقل :attribute مفقودًا عندما تكون :values موجودة.',
    'multiple_of'          => 'يجب أن يكون حقل :attribute من مضاعفات :value.',
    'not_in'               => 'القيمة المختارة في حقل :attribute غير صحيحة.',
    'not_regex'            => 'صيغة حقل :attribute غير صحيحة.',
    'numeric'              => 'يجب أن يكون حقل :attribute رقمًا.',
    'password'             => [
        'letters'       => 'يجب أن يحتوي حقل :attribute على حرف واحد على الأقل.',
        'mixed'         => 'يجب أن يحتوي حقل :attribute على حرف كبير واحد وصغير واحد على الأقل.',
        'numbers'       => 'يجب أن يحتوي حقل :attribute على رقم واحد على الأقل.',
        'symbols'       => 'يجب أن يحتوي حقل :attribute على رمز واحد على الأقل.',
        'uncompromised' => 'قيمة :attribute المعطاة ظهرت في تسريب بيانات. الرجاء اختيار قيمة مختلفة.',
    ],
    'present'              => 'يجب أن يكون حقل :attribute موجودًا.',
    'present_if'           => 'يجب أن يكون حقل :attribute موجودًا عندما يكون :other هو :value.',
    'present_unless'       => 'يجب أن يكون حقل :attribute موجودًا إلا إذا كان :other هو :value.',
    'present_with'         => 'يجب أن يكون حقل :attribute موجودًا عندما تكون :values موجودة.',
    'present_with_all'     => 'يجب أن يكون حقل :attribute موجودًا عندما تكون :values موجودة.',
    'prohibited'           => 'حقل :attribute محظور.',
    'prohibited_if'        => 'حقل :attribute محظور عندما يكون :other هو :value.',
    'prohibited_if_accepted' => 'حقل :attribute محظور عندما يتم قبول :other.',
    'prohibited_if_declined' => 'حقل :attribute محظور عندما يتم رفض :other.',
    'prohibited_unless'    => 'حقل :attribute محظور إلا إذا كان :other ضمن :values.',
    'prohibits'            => 'حقل :attribute يمنع وجود :other.',
    'regex'                => 'صيغة حقل :attribute غير صحيحة.',
    'required'             => 'حقل :attribute مطلوب.',
    'required_array_keys'  => 'يجب أن يحتوي حقل :attribute على إدخالات لـ :values.',
    'required_if'          => 'حقل :attribute مطلوب عندما يكون :other هو :value.',
    'required_if_accepted' => 'حقل :attribute مطلوب عندما يتم قبول :other.',
    'required_if_declined' => 'حقل :attribute مطلوب عندما يتم رفض :other.',
    'required_unless'      => 'حقل :attribute مطلوب إلا إذا كان :other ضمن :values.',
    'required_with'        => 'حقل :attribute مطلوب عندما تكون :values موجودة.',
    'required_with_all'    => 'حقل :attribute مطلوب عندما تكون :values كلها موجودة.',
    'required_without'     => 'حقل :attribute مطلوب عندما لا تكون :values موجودة.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا تكون أي من :values موجودة.',
    'same'                 => 'يجب أن يتطابق حقل :attribute مع :other.',
    'size'                 => [
        'array'   => 'يجب أن يحتوي حقل :attribute على :size عنصرًا.',
        'file'    => 'يجب أن يكون حجم ملف حقل :attribute :size كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute :size.',
        'string'  => 'يجب أن يكون طول نص حقل :attribute :size حروف.',
    ],
    'starts_with'          => 'يجب أن يبدأ حقل :attribute بأي من القيم التالية: :values.',
    'string'               => 'يجب أن يكون حقل :attribute نصًا.',
    'timezone'             => 'يجب أن يكون حقل :attribute منطقة زمنية صحيحة.',
    'unique'               => 'قيمة :attribute مستخدمة من قبل.',
    'uploaded'             => 'فشل في رفع حقل :attribute.',
    'uppercase'            => 'يجب أن يكون حقل :attribute بحروف كبيرة.',
    'url'                  => 'يجب أن يكون حقل :attribute رابطًا صحيحًا.',
    'ulid'                 => 'يجب أن يكون حقل :attribute ULID صالحًا.',
    'uuid'                 => 'يجب أن يكون حقل :attribute UUID صالحًا.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | هنا يمكنك تحديد رسائل التحقق المخصصة للسمات باستخدام التسمية
    | "attribute.rule". هذا يسهل تخصيص رسائل تحقق معينة لسمة معينة.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'رسالة مخصصة',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | تستخدم هذه الخطوط لتبديل العنصر النائب الخاص بسماتنا
    | إلى شيء أكثر ودية مثل "البريد الإلكتروني" بدلاً من "email".
    | هذا يساعد على جعل رسائلنا أكثر تعبيرًا.
    |
    */

    'attributes' => [
        'date'                  => 'التاريخ',
        'time'                  => 'الوقت',
        'type'                  => 'نوع الطلب',
        'additional_service_id' => 'الخدمة الإضافية',
        'notes'                 => 'الملاحظات',
    ],

];
