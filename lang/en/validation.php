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

  'accepted' => 'Поле :attribute должно быть принято.',
  'accepted_if' => 'Поле :attribute должно быть принято, если :other равно :value.',
  'active_url' => 'Поле :attribute должно быть действительным URL-адресом.',
  'after' => 'Поле :attribute должно быть датой после :date.',
  'after_or_equal' => 'Поле :attribute должно быть датой после или равной :date.',
  'alpha' => 'Поле :attribute должно содержать только буквы.',
  'alpha_dash' => 'Поле :attribute должно содержать только буквы, цифры, дефисы и подчеркивания.',
  'alpha_num' => 'Поле :attribute должно содержать только буквы и цифры.',
  'array' => 'Поле :attribute должно быть массивом.',
  'ascii' => 'Поле :attribute должно содержать только однобайтовые буквенно-цифровые символы и символы.',
  'before' => 'Поле :attribute должно быть датой до :date.',
  'before_or_equal' => 'Поле :attribute должно быть датой до или равной :date.',
  'between' => [
    'array' => 'Поле :attribute должно иметь от :min до :max элементов.',
    'file' => 'Поле :attribute должно иметь размер от :min до :max килобайт.',
    'numeric' => 'Поле :attribute должно быть в диапазоне от :min до :max.',
    'string' => 'Поле :attribute должно иметь от :min до :max символов.',
  ],
  'boolean' => 'Поле :attribute должно быть истинным или ложным.',
  'can' => 'Поле :attribute содержит несанкционированное значение.',
  'confirmed' => 'Подтверждение поля :attribute не совпадает.',
  'current_password' => 'Неверный пароль.',
  'date' => 'Поле :attribute должно быть действительной датой.',
  'date_equals' => 'Поле :attribute должно быть датой, равной :date.',
  'date_format' => 'Поле :attribute должно соответствовать формату :format.',
  'decimal' => 'Поле :attribute должно иметь :decimal десятичных знаков.',
  'declined' => 'Поле :attribute должно быть отклонено.',
  'declined_if' => 'Поле :attribute должно быть отклонено, если :other равно :value.',
  'different' => 'Поле :attribute и :other должны быть различными.',
  'digits' => 'Поле :attribute должно содержать :digits цифр.',
  'digits_between' => 'Поле :attribute должно содержать от :min до :max цифр.',
  'dimensions' => 'Поле :attribute имеет недопустимые размеры изображения.',
  'distinct' => 'Поле :attribute содержит повторяющееся значение.',
  'doesnt_end_with' => 'Поле :attribute не должно заканчиваться одним из следующих значений: :values.',
  'doesnt_start_with' => 'Поле :attribute не должно начинаться с одного из следующих значений: :values.',
  'email' => 'Поле :attribute должно быть действительным адресом электронной почты.',
  'ends_with' => 'Поле :attribute должно заканчиваться одним из следующих значений: :values.',
  'enum' => 'Выбранное значение :attribute недействительно.',
  'exists' => 'Выбранное значение :attribute недействительно.',
  'extensions' => 'Поле :attribute должно иметь одно из следующих расширений: :values.',
  'file' => 'Поле :attribute должно быть файлом.',
  'filled' => 'Поле :attribute должно иметь значение.',
  'gt' => [
    'array' => 'Поле :attribute должно иметь более :value элементов.',
    'file' => 'Поле :attribute должно быть больше :value килобайт.',
    'numeric' => "Поле :attribute должно быть больше :value.",
    'string' =>  "Поле :attribute должно быть больше :value символов.",
  ],
  'gte' => [
    'array' => "Поле :attribute должно иметь не менее :value элементов.",
    'file' => "Поле :attribute должно быть больше или равно :value килобайт.",
    'numeric' => "Поле :attribute должно быть больше или равно :value.",
    'string' => "Поле :attribute должно быть больше или равно :value символов.",
  ],
  'hex_color' => "Поле :attribute должно быть корректным шестнадцатеричным цветом.",
  'image' => "Поле :attribute должно быть изображением.",
  'in' => "Выбранное значение :attribute некорректно.",
  'in_array' => "Поле :attribute должно быть в :other.",
  'integer' => "Поле :attribute должно быть целым числом.",
  'ip' => "Поле :attribute должно быть корректным IP-адресом.",
  'ipv4' => "Поле :attribute должно быть корректным IPv4-адресом.",
  'ipv6' => "Поле :attribute должно быть корректным IPv6-адресом.",
  'json' => "Поле :attribute должно быть корректной JSON-строкой.",
  'lowercase' => "Поле :attribute должно быть в нижнем регистре.",
  'lt' => [
    'array' => "Поле :attribute должно иметь менее :value элементов.",
    'file' => "Поле :attribute должно быть меньше :value килобайт.",
    'numeric' => "Поле :attribute должно быть меньше :value.",
    'string' => "Поле :attribute должно быть меньше :value символов.",
  ],
  'lte' => [
    'array' => "Поле :attribute не должно иметь более :value элементов.",
    'file' => "Поле :attribute должно быть меньше или равно :value килобайт.",
    'numeric' => "Поле :attribute должно быть меньше или равно :value.",
    'string' => "Поле :attribute должно быть меньше или равно :value символов.",
  ],
  'mac_address' => "Поле :attribute должно быть корректным MAC-адресом.",
  'max' => [
    'array' => "Поле :attribute не должно иметь более :max элементов.",
    'file' => "Поле :attribute не должно быть больше :max килобайт.",
    'numeric' => "Поле :attribute не должно быть больше :max.",
    'string' => "Поле :attribute не должно быть больше :max символов.",
  ],
  'max_digits' => 'Поле :attribute не должно содержать более :max цифр.',
  'mimes' => "Поле :attribute должно быть файлом типа: :values.",
  'mimetypes' => "Поле :attribute должно быть файлом типа: :values.",
  'min' => [
    'array' => "Поле :attribute должно иметь не менее :min элементов.",
    'file' => "Поле :attribute должно быть не менее :min килобайт.",
    'numeric' => "Поле :attribute должно быть не менее :min.",
    'string' => "Поле :attribute должно быть не менее :min символов.",
  ],
  'min_digits' => 'Поле :attribute должно содержать не менее :min цифр.',
  'missing' => 'Поле :attribute должно отсутствовать.',
  'missing_if' => 'Поле :attribute должно отсутствовать, если :other равно :value.',
  'missing_unless' => 'Поле :attribute должно отсутствовать, если :other равно :value.',
  'missing_with' => 'Поле :attribute должно отсутствовать, если присутствует :values.',
  'missing_with_all' => 'Поле :attribute должно отсутствовать, если присутствует :values.',
  'multiple_of' => 'Поле :attribute должно быть кратно :value.',
  'not_in' => 'Выбранный :attribute недопустим.',
  'not_regex' => 'Недопустимый формат поля :attribute.',
  'numeric' => 'Поле :attribute должно быть числом.',
  'password' => [
    'letters' => 'Поле :attribute должно содержать хотя бы одну букву.',
    'mixed' => 'Поле :attribute должно содержать хотя бы одну заглавную и одну строчную букву.',
    'numbers' => 'Поле :attribute должно содержать хотя бы одну цифру.',
    'symbols' => 'Поле :attribute должно содержать хотя бы один символ.',
    'uncompromised' => 'Данный :attribute появился в утечке данных. Выберите другой :attribute.',
  ],
  'present' => 'Поле :attribute должно присутствовать.',
  'present_if' => 'Поле :attribute должно присутствовать, когда :other равно :value.',
  'present_unless' => 'Поле :attribute должно присутствовать, если :other равно :value.',
  'present_with' => 'Поле :attribute должно присутствовать, если :values ​​равно :values.',
  'present_with_all' => 'Поле :attribute должно присутствовать, если :values ​​равно :values.',
  'prohibited' => 'Поле :attribute запрещено.',
  'prohibited_if' => 'Поле :attribute запрещено, когда :other равно :value.',
  'prohibited_unless' => 'Поле :attribute запрещено, если :other находится в :values.',
  'prohibits' => 'Поле :attribute запрещает присутствие :other.',
  'regex' => 'Формат поля :attribute недействителен.',
  'required' => 'Поле :attribute является обязательным.',
  'required_array_keys' => 'Поле :attribute должно содержать записи для: :values.',
  'required_if' => 'Поле :attribute является обязательным, когда :other является :value.',
  'required_if_accepted' => 'Поле :attribute является обязательным, когда :other принимается.',
  'required_unless' => 'Поле :attribute является обязательным, если :other не находится в :values.',
  'required_with' => 'Поле :attribute является обязательным, когда :values ​​присутствует.',
  'required_with_all' => 'Поле :attribute обязательно, когда присутствуют :values.',
  'required_without' => 'Поле :attribute обязательно, когда нет :values.',
  'required_without_all' => 'Поле :attribute обязательно, когда нет ни одного из :values.',
  'same' => 'Поле :attribute должно соответствовать :other.',
  'size' => [
    'array' => 'Поле :attribute должно содержать элементы :size.',
    'file' => 'Поле :attribute должно быть :size килобайт.',
    'numeric' => 'Поле :attribute должно быть :size.',
    'string' => 'Поле :attribute должно быть :size символы.',
  ],
  'starts_with' => 'Поле :attribute должно начинаться с одного из следующих символов: :values.',
  'string' => 'Поле :attribute должно быть строкой.',
  'timezone' => 'Поле :attribute должно быть допустимым часовым поясом.',
  'unique' => 'Поле :attribute уже занято.',
  'uploaded' => 'Поле :attribute не удалось загрузить.',
  'uppercase' => 'Поле :attribute должно быть в верхнем регистре.',
  'url' => 'Поле :attribute должно быть допустимым URL.',
  'ulid' => 'Поле :attribute должно быть допустимым ULID.',
  'uuid' => 'Поле :attribute должно быть допустимым UUID.',

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
  | The following language lines are used to swap our attribute placeholder
  | with something more reader friendly such as "E-Mail Address" instead
  | of "email". This simply helps us make our message more expressive.
  |
  */

  'attributes' => [],

];
