<?php

return [

    /*
    |--------------------------------------------------------------------------
    | バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | 以下の言語行はバリデータクラスで使用されるデフォルトのエラーメッセージを
    | 含んでいます。サイズルールのように複数のバージョンを持つルールもあります。
    | ここで各メッセージを自由に調整してください。
    |
    */

    'accepted'             => ':attribute を承認してください。',
    'accepted_if'          => ':other が :value の場合、:attribute を承認してください。',
    'active_url'           => ':attribute は有効なURLではありません。',
    'after'                => ':attribute は :date より後の日付でなければなりません。',
    'after_or_equal'       => ':attribute は :date と同日かそれ以降の日付でなければなりません。',
    'alpha'                => ':attribute は文字のみが含まれている必要があります。',
    'alpha_dash'           => ':attribute は文字、数字、ダッシュ、アンダースコアのみが含まれている必要があります。',
    'alpha_num'            => ':attribute は文字と数字のみが含まれている必要があります。',
    'any_of'               => ':attribute の値は無効です。',
    'array'                => ':attribute は配列でなければなりません。',
    'ascii'                => ':attribute はシングルバイトの英数字と記号のみが含まれている必要があります。',
    'before'               => ':attribute は :date より前の日付でなければなりません。',
    'before_or_equal'      => ':attribute は :date と同日かそれ以前の日付でなければなりません。',
    'between'              => [
        'array'   => ':attribute は :min 個から :max 個の間でなければなりません。',
        'file'    => ':attribute は :min KBから :max KBの間でなければなりません。',
        'numeric' => ':attribute は :min から :max の間でなければなりません。',
        'string'  => ':attribute は :min 文字から :max 文字の間でなければなりません。',
    ],
    'boolean'              => ':attribute は true か false でなければなりません。',
    'can'                  => ':attribute に許可されていない値が含まれています。',
    'confirmed'            => ':attribute の確認が一致しません。',
    'contains'             => ':attribute に必須の値が含まれていません。',
    'current_password'     => 'パスワードが正しくありません。',
    'date'                 => ':attribute は有効な日付でなければなりません。',
    'date_equals'          => ':attribute は :date と同じ日付でなければなりません。',
    'date_format'          => ':attribute はフォーマット :format と一致しません。',
    'decimal'              => ':attribute は小数点以下 :decimal 桁でなければなりません。',
    'declined'             => ':attribute は拒否されなければなりません。',
    'declined_if'          => ':other が :value の場合、:attribute は拒否されなければなりません。',
    'different'            => ':attribute と :other は異なる必要があります。',
    'digits'               => ':attribute は :digits 桁でなければなりません。',
    'digits_between'       => ':attribute は :min 桁から :max 桁の間でなければなりません。',
    'dimensions'           => ':attribute の画像サイズが無効です。',
    'distinct'             => ':attribute に重複した値があります。',
    'doesnt_contain'       => ':attribute に以下のいずれかの値が含まれてはいけません: :values。',
    'doesnt_end_with'      => ':attribute は以下のいずれかで終わってはいけません: :values。',
    'doesnt_start_with'    => ':attribute は以下のいずれかで始まってはいけません: :values。',
    'email'                => ':attribute は有効なメールアドレスでなければなりません。',
    'encoding'             => ':attribute は :encoding エンコードでなければなりません。',
    'ends_with'            => ':attribute は以下のいずれかで終わらなければなりません: :values。',
    'enum'                 => '選択された :attribute は無効です。',
    'exists'               => '選択された :attribute は無効です。',
    'extensions'           => ':attribute は以下のいずれかの拡張子でなければなりません: :values。',
    'file'                 => ':attribute はファイルでなければなりません。',
    'filled'               => ':attribute は値が必要です。',
    'gt'                   => [
        'array'   => ':attribute は :value 個より多くなければなりません。',
        'file'    => ':attribute は :value KBより大きくなければなりません。',
        'numeric' => ':attribute は :value より大きくなければなりません。',
        'string'  => ':attribute は :value 文字より多くなければなりません。',
    ],
    'gte'                  => [
        'array'   => ':attribute は :value 個以上でなければなりません。',
        'file'    => ':attribute は :value KB以上でなければなりません。',
        'numeric' => ':attribute は :value 以上でなければなりません。',
        'string'  => ':attribute は :value 文字以上でなければなりません。',
    ],
    'hex_color'            => ':attribute は有効な16進数カラーコードでなければなりません。',
    'image'                => ':attribute は画像でなければなりません。',
    'in'                   => '選択された :attribute は無効です。',
    'in_array'             => ':attribute は :other に存在しなければなりません。',
    'in_array_keys'        => ':attribute は少なくとも以下のキーのいずれかを含まなければなりません: :values。',
    'integer'              => ':attribute は整数でなければなりません。',
    'ip'                   => ':attribute は有効なIPアドレスでなければなりません。',
    'ipv4'                 => ':attribute は有効なIPv4アドレスでなければなりません。',
    'ipv6'                 => ':attribute は有効なIPv6アドレスでなければなりません。',
    'json'                 => ':attribute は有効なJSON文字列でなければなりません。',
    'list'                 => ':attribute はリストでなければなりません。',
    'lowercase'            => ':attribute は小文字でなければなりません。',
    'lt'                   => [
        'array'   => ':attribute は :value 個未満でなければなりません。',
        'file'    => ':attribute は :value KB未満でなければなりません。',
        'numeric' => ':attribute は :value 未満でなければなりません。',
        'string'  => ':attribute は :value 文字未満でなければなりません。',
    ],
    'lte'                  => [
        'array'   => ':attribute は :value 個以下でなければなりません。',
        'file'    => ':attribute は :value KB以下でなければなりません。',
        'numeric' => ':attribute は :value 以下でなければなりません。',
        'string'  => ':attribute は :value 文字以下でなければなりません。',
    ],
    'mac_address'          => ':attribute は有効なMACアドレスでなければなりません。',
    'max'                  => [
        'array'   => ':attribute は :max 個以下でなければなりません。',
        'file'    => ':attribute は :max KB以下でなければなりません。',
        'numeric' => ':attribute は :max 以下でなければなりません。',
        'string'  => ':attribute は :max 文字以下でなければなりません。',
    ],
    'max_digits'           => ':attribute は :max 桁以下でなければなりません。',
    'mimes'                => ':attribute は以下のタイプのファイルでなければなりません: :values。',
    'mimetypes'            => ':attribute は以下のタイプのファイルでなければなりません: :values。',
    'min'                  => [
        'array'   => ':attribute は少なくとも :min 個でなければなりません。',
        'file'    => ':attribute は少なくとも :min KBでなければなりません。',
        'numeric' => ':attribute は少なくとも :min でなければなりません。',
        'string'  => ':attribute は少なくとも :min 文字でなければなりません。',
    ],
    'min_digits'           => ':attribute は少なくとも :min 桁でなければなりません。',
    'missing'              => ':attribute は存在してはいけません。',
    'missing_if'           => ':other が :value の場合、:attribute は存在してはいけません。',
    'missing_unless'       => ':other が :value でない限り、:attribute は存在してはいけません。',
    'missing_with'         => ':values が存在する場合、:attribute は存在してはいけません。',
    'missing_with_all'     => ':values がすべて存在する場合、:attribute は存在してはいけません。',
    'multiple_of'          => ':attribute は :value の倍数でなければなりません。',
    'not_in'               => '選択された :attribute は無効です。',
    'not_regex'            => ':attribute の形式が無効です。',
    'numeric'              => ':attribute は数値でなければなりません。',
    'password'             => [
        'letters'       => ':attribute には少なくとも1つの文字が含まれている必要があります。',
        'mixed'         => ':attribute には少なくとも1つの大文字と1つの小文字が含まれている必要があります。',
        'numbers'       => ':attribute には少なくとも1つの数字が含まれている必要があります。',
        'symbols'       => ':attribute には少なくとも1つの記号が含まれている必要があります。',
        'uncompromised' => '提供された :attribute はデータ漏洩に含まれています。別の :attribute を選択してください。',
    ],
    'present'              => ':attribute は存在していなければなりません。',
    'present_if'           => ':other が :value の場合、:attribute は存在していなければなりません。',
    'present_unless'       => ':other が :value でない限り、:attribute は存在していなければなりません。',
    'present_with'         => ':values が存在する場合、:attribute は存在していなければなりません。',
    'present_with_all'     => ':values がすべて存在する場合、:attribute は存在していなければなりません。',
    'prohibited'           => ':attribute は禁止されています。',
    'prohibited_if'        => ':other が :value の場合、:attribute は禁止されています。',
    'prohibited_if_accepted' => ':other が承認されている場合、:attribute は禁止されています。',
    'prohibited_if_declined' => ':other が拒否されている場合、:attribute は禁止されています。',
    'prohibited_unless'    => ':other が :values に含まれていない限り、:attribute は禁止されています。',
    'prohibits'            => ':attribute は :other の存在を禁止しています。',
    'regex'                => ':attribute の形式が無効です。',
    'required'             => ':attribute は必須です。',
    'required_array_keys'   => ':attribute には以下のエントリが含まれている必要があります: :values。',
    'required_if'          => ':other が :value の場合、:attribute は必須です。',
    'required_if_accepted' => ':other が承認されている場合、:attribute は必須です。',
    'required_if_declined' => ':other が拒否されている場合、:attribute は必須です。',
    'required_unless'      => ':other が :values に含まれていない限り、:attribute は必須です。',
    'required_with'        => ':values が存在する場合、:attribute は必須です。',
    'required_with_all'    => ':values がすべて存在する場合、:attribute は必須です。',
    'required_without'     => ':values が存在しない場合、:attribute は必須です。',
    'required_without_all' => ':values のいずれも存在しない場合、:attribute は必須です。',
    'same'                 => ':attribute と :other は一致している必要があります。',
    'size'                 => [
        'array'   => ':attribute は :size 個でなければなりません。',
        'file'    => ':attribute は :size KBでなければなりません。',
        'numeric' => ':attribute は :size でなければなりません。',
        'string'  => ':attribute は :size 文字でなければなりません。',
    ],
    'starts_with'          => ':attribute は以下のいずれかで始まらなければなりません: :values。',
    'string'               => ':attribute は文字列でなければなりません。',
    'timezone'             => ':attribute は有効なタイムゾーンでなければなりません。',
    'unique'               => ':attribute は既に存在しています。',
    'uploaded'             => ':attribute のアップロードに失敗しました。',
    'uppercase'            => ':attribute は大文字でなければなりません。',
    'url'                  => ':attribute の形式が無効です。',
    'ulid'                 => ':attribute は有効なULIDでなければなりません。',
    'uuid'                 => ':attribute は有効なUUIDでなければなりません。',

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション言語行
    |--------------------------------------------------------------------------
    |
    | ここでは "attribute.rule" の形式を使って、属性に対するカスタム
    | バリデーションメッセージを指定できます。これにより特定のルールに対して
    | カスタムメッセージを簡単に指定できます。
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'カスタムメッセージ',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション属性
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は、プレースホルダー :attribute をより読みやすい名称に置き換えます。
    | 例えば "email" の代わりに "メールアドレス" のようにします。
    |
    */

    'attributes' => [
        'date'                  => '日付',
        'time'                  => '時間',
        'type'                  => '種類',
        'additional_service_id' => '追加サービス',
        'notes'                 => 'メモ',
    ],

];
