<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute harus diterima.',
    'active_url'           => ':attribute bukan URL yang valid.',
    'after'                => ':attribute harus tanggal setelah :date.',
    'after_or_equal'       => ':attribute harus tanggal setelah atau sama dengan :date.',
    'alpha'                => ':attribute hanya boleh berisi huruf.',
    'alpha_dash'           => ':attribute hanya boleh berisi huruf, angka, dan tanda hubung.',
    'alpha_num'            => ':attribute hanya boleh berisi huru dan angka.',
    'array'                => ':attribute hanya boleh berisi array.',
    'before'               => ':attribute harus tanggal sebelum :date.',
    'before_or_equal'      => ':attribute harus tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'numeric' => ':attribute harus di antara :min dan :max.',
        'file'    => ':attribute harus di antara :min dan :max kilobytes.',
        'string'  => ':attribute harus di antara :min dan :max karakter.',
        'array'   => ':attribute harus ada di antara :min dan :max item.',
    ],
    'boolean'              => 'bidang :attribute harus berisi true atau false.',
    'confirmed'            => ':attribute konfirmasi tidak cocok.',
    'date'                 => ':attribute bukan tanggal yang valid.',
    'date_format'          => ':attribute tidak sesuai dengan format :format.',
    'different'            => ':attribute dan :other harus berbeda.',
    'digits'               => ':attribute harus :digits digit.',
    'digits_between'       => ':attribute harus diantara :min dan :max digit.',
    'dimensions'           => ':attribute memiliki jenis gambar yang tidak valid.',
    'distinct'             => 'bidang :attribute memiliki nilai duplikat.',
    'email'                => ':attribute Harus alamat e-mail yang valid.',
    'exists'               => ':attribute yang dipilih tidak valid.',
    'file'                 => ':attribute harus berupa file.',
    'filled'               => 'bidang :attribute harus memiliki nilai.',
    'gt'                   => [
        'numeric' => ':attribute harus lebih besar dari :value.',
        'file'    => ':attribute harus lebih besar dari :value kilobytes.',
        'string'  => ':attribute harus lebih besar dari :value karakter.',
        'array'   => ':attribute harus memiliki lebih dari :value item.',
    ],
    'gte'                  => [
        'numeric' => ':attribute harus lebih besar atau sama dengan :value.',
        'file'    => ':attribute harus lebih besar atau sama dengan :value kilobytes.',
        'string'  => ':attribute harus lebih besar atau sama dengan :value characters.',
        'array'   => ':attribute harus mempunyai :value item atau lebih.',
    ],
    'image'                => ':attribute harus gambar.',
    'in'                   => ':attribute yang dipilih tidak valid.',
    'in_array'             => 'bidang :attribute tidak ada di :other.',
    'integer'              => ':attribute harus berupa integer.',
    'ip'                   => ':attribute harus alamat IP yang valid.',
    'ipv4'                 => ':attribute harus alamat IPv4 yang valid.',
    'ipv6'                 => ':attribute harus alamat IPv6 yang valid.',
    'json'                 => ':attribute harus memiliki format JSON yang valid.',
    'lt'                   => [
        'numeric' => ':attribute harus kurang dari :value.',
        'file'    => ':attribute harus kurang dari :value kilobytes.',
        'string'  => ':attribute harus kurang dari :value karakter.',
        'array'   => ':attribute harus memiliki kurang dari :value item.',
    ],
    'lte'                  => [
        'numeric' => ':attribute harus kurang dari atau sama dengan :value.',
        'file'    => ':attribute harus kurang dari atau sama dengan :value kilobytes.',
        'string'  => ':attribute harus kurang dari atau sama dengan :value karakter.',
        'array'   => ':attribute tidak boleh lebih dari :value item.',
    ],
    'max'                  => [
        'numeric' => ':attribute mungkin tidak lebih besar dari :max.',
        'file'    => ':attribute mungkin tidak lebih besar dari :max kilobytes.',
        'string'  => ':attribute mungkin tidak lebih besar dari :max karakter.',
        'array'   => ':attribute mungkin tidak lebih dari :max item.',
    ],
    'mimes'                => ':attribute harus berupa file type: :values.',
    'mimetypes'            => ':attribute harus berupa file type: :values.',
    'min'                  => [
        'numeric' => ':attribute setidaknya harus :min.',
        'file'    => ':attribute setidaknya harus :min kilobytes.',
        'string'  => ':attribute setidaknya harus :min karakter.',
        'array'   => ':attribute setidaknya harus memiliki :min item.',
    ],
    'not_in'               => ':attribute yang dipilih tidak valid.',
    'not_regex'            => ':attribute bukan format yang valid.',
    'numeric'              => ':attribute harus berupa angka.',
    'present'              => 'bidang :attribute harus ada.',
    'regex'                => ':attribute bukan format yang valid.',
    'required'             => 'Bidang :attribute harus diisi.',
    'required_if'          => 'Bidang :attribute harus diisi ketika :other adalah :value.',
    'required_unless'      => 'Bidang :attribute harus diisi kecuali :other ada di :values.',
    'required_with'        => 'Bidang :attribute harus diisi ketika :values ada.',
    'required_with_all'    => 'Bidang :attribute harus diisi ketika :values ada.',
    'required_without'     => 'Bidang :attribute harus diisi ketika :values tidak ada.',
    'required_without_all' => 'Bidang :attribute harus diisi jika tidak ada :values telah ada.',
    'same'                 => ':attribute dan :other harus sesuai.',
    'size'                 => [
        'numeric' => ':attribute harus :size.',
        'file'    => ':attribute harus :size kilobytes.',
        'string'  => ':attribute harus :size character.',
        'array'   => ':attribute harus mengandung :size item.',
    ],
    'string'               => ':attribute harus berupa string.',
    'timezone'             => ':attribute harus menjadi zona yang valid.',
    'unique'               => ':attribute sudah diambil.',
    'uploaded'             => ':attribute gagal diunggah.',
    'url'                  => ':attribute format tidak valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
