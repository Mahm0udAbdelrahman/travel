<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Linee di lingua di validazione
    |--------------------------------------------------------------------------
    |
    | Le seguenti linee contengono i messaggi di errore predefiniti usati dalla
    | classe di validazione. Alcune di queste regole hanno più versioni,
    | come le regole di dimensione. Sentiti libero di modificare ogni messaggio.
    |
    */

    'accepted'             => 'Il campo :attribute deve essere accettato.',
    'accepted_if'          => 'Il campo :attribute deve essere accettato quando :other è :value.',
    'active_url'           => 'Il campo :attribute non è un URL valido.',
    'after'                => 'Il campo :attribute deve essere una data successiva a :date.',
    'after_or_equal'       => 'Il campo :attribute deve essere una data successiva o uguale a :date.',
    'alpha'                => 'Il campo :attribute può contenere solo lettere.',
    'alpha_dash'           => 'Il campo :attribute può contenere solo lettere, numeri, trattini e underscore.',
    'alpha_num'            => 'Il campo :attribute può contenere solo lettere e numeri.',
    'array'                => 'Il campo :attribute deve essere un array.',
    'before'               => 'Il campo :attribute deve essere una data precedente a :date.',
    'before_or_equal'      => 'Il campo :attribute deve essere una data precedente o uguale a :date.',
    'between'              => [
        'array'   => 'Il campo :attribute deve contenere tra :min e :max elementi.',
        'file'    => 'Il file :attribute deve essere tra :min e :max kilobyte.',
        'numeric' => 'Il campo :attribute deve essere tra :min e :max.',
        'string'  => 'Il campo :attribute deve contenere tra :min e :max caratteri.',
    ],
    'boolean'              => 'Il campo :attribute deve essere vero o falso.',
    'confirmed'            => 'La conferma del campo :attribute non corrisponde.',
    'current_password'     => 'La password è errata.',
    'date'                 => 'Il campo :attribute non è una data valida.',
    'date_equals'          => 'Il campo :attribute deve essere una data uguale a :date.',
    'date_format'          => 'Il campo :attribute non corrisponde al formato :format.',
    'declined'             => 'Il campo :attribute deve essere rifiutato.',
    'declined_if'          => 'Il campo :attribute deve essere rifiutato quando :other è :value.',
    'different'            => 'Il campo :attribute e :other devono essere diversi.',
    'digits'               => 'Il campo :attribute deve contenere :digits cifre.',
    'digits_between'       => 'Il campo :attribute deve contenere tra :min e :max cifre.',
    'dimensions'           => 'Il campo :attribute ha dimensioni immagine non valide.',
    'distinct'             => 'Il campo :attribute contiene un valore duplicato.',
    'doesnt_end_with'      => 'Il campo :attribute non deve terminare con uno dei seguenti: :values.',
    'doesnt_start_with'    => 'Il campo :attribute non deve iniziare con uno dei seguenti: :values.',
    'email'                => 'Il campo :attribute deve essere un indirizzo email valido.',
    'ends_with'            => 'Il campo :attribute deve terminare con uno dei seguenti: :values.',
    'enum'                 => 'La selezione del campo :attribute non è valida.',
    'exists'               => 'La selezione del campo :attribute non è valida.',
    'file'                 => 'Il campo :attribute deve essere un file.',
    'filled'               => 'Il campo :attribute deve avere un valore.',
    'gt'                   => [
        'array'   => 'Il campo :attribute deve contenere più di :value elementi.',
        'file'    => 'Il file :attribute deve essere più grande di :value kilobyte.',
        'numeric' => 'Il campo :attribute deve essere maggiore di :value.',
        'string'  => 'Il campo :attribute deve contenere più di :value caratteri.',
    ],
    'gte'                  => [
        'array'   => 'Il campo :attribute deve contenere almeno :value elementi.',
        'file'    => 'Il file :attribute deve essere più grande o uguale a :value kilobyte.',
        'numeric' => 'Il campo :attribute deve essere maggiore o uguale a :value.',
        'string'  => 'Il campo :attribute deve contenere almeno :value caratteri.',
    ],
    'image'                => 'Il campo :attribute deve essere un\'immagine.',
    'in'                   => 'La selezione del campo :attribute non è valida.',
    'in_array'             => 'Il campo :attribute deve esistere in :other.',
    'integer'              => 'Il campo :attribute deve essere un numero intero.',
    'ip'                   => 'Il campo :attribute deve essere un indirizzo IP valido.',
    'ipv4'                 => 'Il campo :attribute deve essere un indirizzo IPv4 valido.',
    'ipv6'                 => 'Il campo :attribute deve essere un indirizzo IPv6 valido.',
    'json'                 => 'Il campo :attribute deve essere una stringa JSON valida.',
    'lt'                   => [
        'array'   => 'Il campo :attribute deve contenere meno di :value elementi.',
        'file'    => 'Il file :attribute deve essere più piccolo di :value kilobyte.',
        'numeric' => 'Il campo :attribute deve essere inferiore a :value.',
        'string'  => 'Il campo :attribute deve contenere meno di :value caratteri.',
    ],
    'lte'                  => [
        'array'   => 'Il campo :attribute non deve contenere più di :value elementi.',
        'file'    => 'Il file :attribute deve essere più piccolo o uguale a :value kilobyte.',
        'numeric' => 'Il campo :attribute deve essere inferiore o uguale a :value.',
        'string'  => 'Il campo :attribute deve contenere al massimo :value caratteri.',
    ],
    'max'                  => [
        'array'   => 'Il campo :attribute non deve contenere più di :max elementi.',
        'file'    => 'Il file :attribute non deve essere più grande di :max kilobyte.',
        'numeric' => 'Il campo :attribute non deve essere maggiore di :max.',
        'string'  => 'Il campo :attribute non deve contenere più di :max caratteri.',
    ],
    'mimes'                => 'Il campo :attribute deve essere un file di tipo: :values.',
    'mimetypes'            => 'Il campo :attribute deve essere un file di tipo: :values.',
    'min'                  => [
        'array'   => 'Il campo :attribute deve contenere almeno :min elementi.',
        'file'    => 'Il file :attribute deve essere almeno :min kilobyte.',
        'numeric' => 'Il campo :attribute deve essere almeno :min.',
        'string'  => 'Il campo :attribute deve contenere almeno :min caratteri.',
    ],
    'not_in'               => 'La selezione del campo :attribute non è valida.',
    'not_regex'            => 'Il formato del campo :attribute non è valido.',
    'numeric'              => 'Il campo :attribute deve essere un numero.',
    'password'             => [
        'letters'       => 'Il campo :attribute deve contenere almeno una lettera.',
        'mixed'         => 'Il campo :attribute deve contenere almeno una lettera maiuscola e una minuscola.',
        'numbers'       => 'Il campo :attribute deve contenere almeno un numero.',
        'symbols'       => 'Il campo :attribute deve contenere almeno un simbolo.',
        'uncompromised' => 'Il :attribute fornito è apparso in una fuga di dati. Scegli un altro :attribute.',
    ],
    'present'              => 'Il campo :attribute deve essere presente.',
    'prohibited'           => 'Il campo :attribute è proibito.',
    'prohibited_if'        => 'Il campo :attribute è proibito quando :other è :value.',
    'prohibited_unless'    => 'Il campo :attribute è proibito a meno che :other non sia in :values.',
    'regex'                => 'Il formato del campo :attribute non è valido.',
    'required'             => 'Il campo :attribute è obbligatorio.',
    'required_array_keys'   => 'Il campo :attribute deve contenere voci per: :values.',
    'required_if'          => 'Il campo :attribute è obbligatorio quando :other è :value.',
    'required_unless'      => 'Il campo :attribute è obbligatorio a meno che :other non sia in :values.',
    'required_with'        => 'Il campo :attribute è obbligatorio quando :values è presente.',
    'required_with_all'    => 'Il campo :attribute è obbligatorio quando :values sono presenti.',
    'required_without'     => 'Il campo :attribute è obbligatorio quando :values non è presente.',
    'required_without_all' => 'Il campo :attribute è obbligatorio quando nessuno di :values è presente.',
    'same'                 => 'Il campo :attribute e :other devono corrispondere.',
    'size'                 => [
        'array'   => 'Il campo :attribute deve contenere :size elementi.',
        'file'    => 'Il file :attribute deve essere :size kilobyte.',
        'numeric' => 'Il campo :attribute deve essere :size.',
        'string'  => 'Il campo :attribute deve contenere :size caratteri.',
    ],
    'starts_with'          => 'Il campo :attribute deve iniziare con uno dei seguenti: :values.',
    'string'               => 'Il campo :attribute deve essere una stringa.',
    'timezone'             => 'Il campo :attribute deve essere un fuso orario valido.',
    'unique'               => 'Il campo :attribute è già stato preso.',
    'uploaded'             => 'Il caricamento del campo :attribute è fallito.',
    'url'                  => 'Il formato del campo :attribute non è valido.',
    'uuid'                 => 'Il campo :attribute deve essere un UUID valido.',

    /*
    |--------------------------------------------------------------------------
    | Messaggi di validazione personalizzati
    |--------------------------------------------------------------------------
    |
    | Qui puoi specificare messaggi di validazione personalizzati per attributi
    | usando la convenzione "attribute.rule" per nominare le linee. Questo rende
    | rapido specificare un messaggio personalizzato per una regola specifica.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'messaggio-personalizzato',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Attributi di validazione personalizzati
    |--------------------------------------------------------------------------
    |
    | Le seguenti linee sono usate per scambiare il placeholder dell'attributo
    | con qualcosa di più leggibile come "Indirizzo Email" invece di "email".
    |
    */

    'attributes' => [
        'date'                  => 'data',
        'time'                  => 'ora',
        'type'                  => 'tipo',
        'additional_service_id' => 'servizio aggiuntivo',
        'notes'                 => 'note',
    ],

];
