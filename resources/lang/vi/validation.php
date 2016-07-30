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

  "accepted"             => "Trường :attribute phải được chấp nhận.",
  "active_url"           => "Trường :attribute không hợp lệ.",
  "after"                => "Trường :attribute phải sau ngày :date.",
  "alpha"                => "Trường :attribute chỉ bao gồm các ký tự là chữ.",
  "alpha_dash"           => "Trường :attribute chỉ bao gồm chữ, số, và dấu gạch ngang.",
  "alpha_num"            => "Trường :attribute chỉ bao gồm chữ và số.",
  "array"                => "Trường :attribute phải là một mảng.",
  "before"               => "Trường :attribute phải là một ngày trước ngày :date.",
  "between"              => [
    "numeric" => "Trường :attribute phải ở trong khoảng :min và :max.",
    "file"    => "Trường :attribute phải ở trong khoảng :min và :max kilobytes.",
    "string"  => "Trường :attribute phải ở trong khoảng :min và :max characters.",
    "array"   => "Trường :attribute phải ở trong khoảng :min và :max items.",
  ],
  "boolean"              => "Trường :attribute phải là đúng hoặc sai.",
  "confirmed"            => "Trường :attribute xác nhận không khớp.",
  "date"                 => "Trường :attribute không hợp lệ kiểu ngày.",
  "date_format"          => "Trường :attribute không đúng với định dạng :format.",
  "different"            => "Trường :attribute và :other phải khác nhau.",
  "digits"               => "Trường :attribute phải :digits chữ số.",
  "digits_between"       => "Trường :attribute phải trong khoảng :min và :max chữ số.",
  "email"                => "Trường :attribute phải đúng định dạng email.",
  "filled"               => "Trường :attribute không được bỏ trống.",
  "exists"               => "Trường đã chọn :attribute không hợp lệ.",
  "image"                => "Trường :attribute phải là ảnh.",
  "in"                   => "Trường đã chọn :attribute không hợp lệ.",
  "integer"              => "Trường :attribute phải là số.",
  "ip"                   => "Trường :attribute phải là địa chỉ IP hợp lệ.",
  "max"                  => [
    "numeric" => "Trường :attribute không được lớn hơn :max.",
    "file"    => "Trường :attribute không được lớn hơn :max kilobytes.",
    "string"  => "Trường :attribute không được lớn hơn :max characters.",
    "array"   => "Trường :attribute không được lớn hơn :max items.",
  ],
  "mimes"                => "Trường :attribute phải là file kiểu: :values.",
  "min"                  => [
    "numeric" => "Trường :attribute phải có ít nhất :min.",
    "file"    => "Trường :attribute phải có ít nhất :min kilobytes.",
    "string"  => "Trường :attribute phải có ít nhất :min characters.",
    "array"   => "Trường :attribute phải có ít nhất :min items.",
  ],
  "not_in"               => "Trường được chọn :attribute không hợp lệ.",
  "numeric"              => "Trường :attribute phải là số.",
  "regex"                => "Trường :attribute không đúng định dạng.",
  "required"             => "Trường :attribute không được bỏ trống.",
  "required_if"          => "Trường :attribute không được bỏ trống khi :other là :value.",
  "required_with"        => "Trường :attribute không được bỏ trống khi :values là present.",
  "required_with_all"    => "Trường :attribute không được bỏ trống khi :values là present.",
  "required_without"     => "Trường :attribute không được bỏ trống khi :values là not present.",
  "required_without_all" => "Trường :attribute field is required when none of :values are present.",
  "same"                 => "Trường :attribute và :other phải phù hợp với nhau.",
  "size"                 => [
    "numeric" => "Trường :attribute phải :size.",
    "file"    => "Trường :attribute phải :size kilobytes.",
    "string"  => "Trường :attribute phải :size characters.",
    "array"   => "Trường :attribute phải bao gồm :size items.",
  ],
  "unique"               => "Trường :attribute đã tồn tại.",
  "url"                  => "Trường :attribute không đúng định dạng.",
    "tags"                 => "tags, separated by commas (no spaces), should have a maximum of 50 characters.",
  "timezone"             => "Trường :attribute phải là vùng hợp lệ.",

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
      'name'      => 'Tên'
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

  'attributes' => [
    "log"          => "Email or Password",
    'name'         => 'Tên',   
    'address'      => 'Địa chỉ',
    'ticketroom '  => 'Kênh bán vé',
    'ticket_price' => 'Giá vé',
    'ticket_total' => 'Tổng số vé',
    'payment'      => 'Phương thức thanh toán',
    'email'        => 'Email',
    'telephone'    => 'Số điện thoại',
    'g-recaptcha-response' => 'Captcha',
    'captcha'      => 'Capcha'
  ],

];
