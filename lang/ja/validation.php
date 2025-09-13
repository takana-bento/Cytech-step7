<?php

return [
    'required' => ':attribute は必須です。',
    'email'    => ':attribute の形式が正しくありません。',
    'unique'   => ':attribute は既に使用されています。',
    'min'      => [
        'string' => ':attribute は :min 文字以上で入力してください。',
    ],
    'max'      => [
        'string' => ':attribute は :max 文字以下で入力してください。',
    ],
    'confirmed' => ':attribute が確認用と一致しません。',
    
    // 属性名を日本語化
    'attributes' => [
        'email' => 'メールアドレス',
        'password' => 'パスワード',
    ],
];