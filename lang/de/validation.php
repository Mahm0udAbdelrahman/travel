<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validierung Sprachzeilen
    |--------------------------------------------------------------------------
    |
    | Die folgenden Sprachzeilen enthalten die Standard-Fehlermeldungen, die
    | vom Validator verwendet werden. Einige dieser Regeln haben mehrere
    | Versionen, wie z.B. die Größenregeln. Passen Sie jede dieser Meldungen
    | hier gerne an.
    |
    */

    'accepted'             => 'Das Feld :attribute muss akzeptiert werden.',
    'accepted_if'          => 'Das Feld :attribute muss akzeptiert werden, wenn :other den Wert :value hat.',
    'active_url'           => 'Das Feld :attribute ist keine gültige URL.',
    'after'                => 'Das Feld :attribute muss ein Datum nach dem :date sein.',
    'after_or_equal'       => 'Das Feld :attribute muss ein Datum nach oder gleich dem :date sein.',
    'alpha'                => 'Das Feld :attribute darf nur Buchstaben enthalten.',
    'alpha_dash'           => 'Das Feld :attribute darf nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten.',
    'alpha_num'            => 'Das Feld :attribute darf nur Buchstaben und Zahlen enthalten.',
    'array'                => 'Das Feld :attribute muss ein Array sein.',
    'before'               => 'Das Feld :attribute muss ein Datum vor dem :date sein.',
    'before_or_equal'      => 'Das Feld :attribute muss ein Datum vor oder gleich dem :date sein.',
    'between'              => [
        'array'   => 'Das Feld :attribute muss zwischen :min und :max Elemente enthalten.',
        'file'    => 'Das Feld :attribute muss zwischen :min und :max Kilobyte groß sein.',
        'numeric' => 'Das Feld :attribute muss zwischen :min und :max liegen.',
        'string'  => 'Das Feld :attribute muss zwischen :min und :max Zeichen lang sein.',
    ],
    'boolean'              => 'Das Feld :attribute muss true oder false sein.',
    'confirmed'            => 'Die Bestätigung für :attribute stimmt nicht überein.',
    'current_password'     => 'Das Passwort ist inkorrekt.',
    'date'                 => 'Das Feld :attribute ist kein gültiges Datum.',
    'date_equals'          => 'Das Feld :attribute muss ein Datum gleich :date sein.',
    'date_format'          => 'Das Feld :attribute entspricht nicht dem Format :format.',
    'declined'             => 'Das Feld :attribute muss abgelehnt werden.',
    'declined_if'          => 'Das Feld :attribute muss abgelehnt werden, wenn :other den Wert :value hat.',
    'different'            => 'Die Felder :attribute und :other müssen unterschiedlich sein.',
    'digits'               => 'Das Feld :attribute muss :digits Ziffern enthalten.',
    'digits_between'       => 'Das Feld :attribute muss zwischen :min und :max Ziffern enthalten.',
    'dimensions'           => 'Das Feld :attribute hat ungültige Bildmaße.',
    'distinct'             => 'Das Feld :attribute enthält einen doppelten Wert.',
    'doesnt_end_with'      => 'Das Feld :attribute darf nicht mit einem der folgenden Werte enden: :values.',
    'doesnt_start_with'    => 'Das Feld :attribute darf nicht mit einem der folgenden Werte beginnen: :values.',
    'email'                => 'Das Feld :attribute muss eine gültige E-Mail-Adresse sein.',
    'ends_with'            => 'Das Feld :attribute muss mit einem der folgenden Werte enden: :values.',
    'enum'                 => 'Der ausgewählte Wert für :attribute ist ungültig.',
    'exists'               => 'Der ausgewählte Wert für :attribute ist ungültig.',
    'file'                 => 'Das Feld :attribute muss eine Datei sein.',
    'filled'               => 'Das Feld :attribute muss einen Wert haben.',
    'gt'                   => [
        'array'   => 'Das Feld :attribute muss mehr als :value Elemente enthalten.',
        'file'    => 'Das Feld :attribute muss größer als :value Kilobyte sein.',
        'numeric' => 'Das Feld :attribute muss größer als :value sein.',
        'string'  => 'Das Feld :attribute muss länger als :value Zeichen sein.',
    ],
    'gte'                  => [
        'array'   => 'Das Feld :attribute muss :value oder mehr Elemente enthalten.',
        'file'    => 'Das Feld :attribute muss größer oder gleich :value Kilobyte sein.',
        'numeric' => 'Das Feld :attribute muss größer oder gleich :value sein.',
        'string'  => 'Das Feld :attribute muss mindestens :value Zeichen lang sein.',
    ],
    'image'                => 'Das Feld :attribute muss ein Bild sein.',
    'in'                   => 'Der ausgewählte Wert für :attribute ist ungültig.',
    'in_array'             => 'Das Feld :attribute muss in :other enthalten sein.',
    'integer'              => 'Das Feld :attribute muss eine ganze Zahl sein.',
    'ip'                   => 'Das Feld :attribute muss eine gültige IP-Adresse sein.',
    'ipv4'                 => 'Das Feld :attribute muss eine gültige IPv4-Adresse sein.',
    'ipv6'                 => 'Das Feld :attribute muss eine gültige IPv6-Adresse sein.',
    'json'                 => 'Das Feld :attribute muss ein gültiger JSON-String sein.',
    'lt'                   => [
        'array'   => 'Das Feld :attribute darf nicht mehr als :value Elemente enthalten.',
        'file'    => 'Das Feld :attribute muss kleiner als :value Kilobyte sein.',
        'numeric' => 'Das Feld :attribute muss kleiner als :value sein.',
        'string'  => 'Das Feld :attribute muss kürzer als :value Zeichen sein.',
    ],
    'lte'                  => [
        'array'   => 'Das Feld :attribute darf nicht mehr als :value Elemente enthalten.',
        'file'    => 'Das Feld :attribute muss kleiner oder gleich :value Kilobyte sein.',
        'numeric' => 'Das Feld :attribute muss kleiner oder gleich :value sein.',
        'string'  => 'Das Feld :attribute muss kürzer oder gleich :value Zeichen sein.',
    ],
    'max'                  => [
        'array'   => 'Das Feld :attribute darf nicht mehr als :max Elemente enthalten.',
        'file'    => 'Das Feld :attribute darf nicht größer als :max Kilobyte sein.',
        'numeric' => 'Das Feld :attribute darf nicht größer als :max sein.',
        'string'  => 'Das Feld :attribute darf nicht länger als :max Zeichen sein.',
    ],
    'mimes'                => 'Das Feld :attribute muss eine Datei vom Typ: :values sein.',
    'mimetypes'            => 'Das Feld :attribute muss eine Datei vom Typ: :values sein.',
    'min'                  => [
        'array'   => 'Das Feld :attribute muss mindestens :min Elemente enthalten.',
        'file'    => 'Das Feld :attribute muss mindestens :min Kilobyte groß sein.',
        'numeric' => 'Das Feld :attribute muss mindestens :min sein.',
        'string'  => 'Das Feld :attribute muss mindestens :min Zeichen lang sein.',
    ],
    'not_in'               => 'Der ausgewählte Wert für :attribute ist ungültig.',
    'not_regex'            => 'Das Format des Feldes :attribute ist ungültig.',
    'numeric'              => 'Das Feld :attribute muss eine Zahl sein.',
    'password'             => [
        'letters'       => 'Das Feld :attribute muss mindestens einen Buchstaben enthalten.',
        'mixed'         => 'Das Feld :attribute muss mindestens einen Groß- und einen Kleinbuchstaben enthalten.',
        'numbers'       => 'Das Feld :attribute muss mindestens eine Zahl enthalten.',
        'symbols'       => 'Das Feld :attribute muss mindestens ein Sonderzeichen enthalten.',
        'uncompromised' => 'Das angegebene :attribute wurde in einem Datenleck gefunden. Bitte wählen Sie ein anderes :attribute.',
    ],
    'present'              => 'Das Feld :attribute muss vorhanden sein.',
    'prohibited'           => 'Das Feld :attribute ist verboten.',
    'prohibited_if'        => 'Das Feld :attribute ist verboten, wenn :other den Wert :value hat.',
    'prohibited_unless'    => 'Das Feld :attribute ist verboten, außer :other hat einen der Werte :values.',
    'regex'                => 'Das Format des Feldes :attribute ist ungültig.',
    'required'             => 'Das Feld :attribute ist erforderlich.',
    'required_array_keys'   => 'Das Feld :attribute muss Einträge für: :values enthalten.',
    'required_if'          => 'Das Feld :attribute ist erforderlich, wenn :other den Wert :value hat.',
    'required_unless'      => 'Das Feld :attribute ist erforderlich, außer :other hat einen der Werte :values.',
    'required_with'        => 'Das Feld :attribute ist erforderlich, wenn :values vorhanden ist.',
    'required_with_all'    => 'Das Feld :attribute ist erforderlich, wenn :values vorhanden sind.',
    'required_without'     => 'Das Feld :attribute ist erforderlich, wenn :values nicht vorhanden ist.',
    'required_without_all' => 'Das Feld :attribute ist erforderlich, wenn keiner der Werte :values vorhanden ist.',
    'same'                 => 'Das Feld :attribute und :other müssen übereinstimmen.',
    'size'                 => [
        'array'   => 'Das Feld :attribute muss :size Elemente enthalten.',
        'file'    => 'Das Feld :attribute muss :size Kilobyte groß sein.',
        'numeric' => 'Das Feld :attribute muss :size sein.',
        'string'  => 'Das Feld :attribute muss :size Zeichen lang sein.',
    ],
    'starts_with'          => 'Das Feld :attribute muss mit einem der folgenden Werte beginnen: :values.',
    'string'               => 'Das Feld :attribute muss ein String sein.',
    'timezone'             => 'Das Feld :attribute muss eine gültige Zeitzone sein.',
    'unique'               => 'Das :attribute wurde bereits vergeben.',
    'uploaded'             => 'Das Hochladen des Feldes :attribute ist fehlgeschlagen.',
    'url'                  => 'Das Format des Feldes :attribute ist ungültig.',
    'uuid'                 => 'Das Feld :attribute muss eine gültige UUID sein.',

    /*
    |--------------------------------------------------------------------------
    | Benutzerdefinierte Validierungsnachrichten
    |--------------------------------------------------------------------------
    |
    | Hier können Sie benutzerdefinierte Validierungsnachrichten für Attribute mit
    | der Konvention "attribute.rule" angeben. Dies erleichtert die schnelle
    | Angabe einer spezifischen benutzerdefinierten Nachricht für eine Regel.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'benutzerdefinierte Nachricht',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Benutzerdefinierte Attributnamen
    |--------------------------------------------------------------------------
    |
    | Die folgenden Sprachzeilen werden verwendet, um Platzhalter für Attribute
    | durch etwas leserfreundlicheres wie "E-Mail Adresse" zu ersetzen.
    |
    */

    'attributes' => [
        'date'                  => 'Datum',
        'time'                  => 'Uhrzeit',
        'type'                  => 'Typ',
        'additional_service_id' => 'Zusatzdienstleistung',
        'notes'                 => 'Notizen',
    ],

];
