<?php

return [
    'title'     =>  'required|max:10',
    'content'   =>  'required',
    'phone'     =>  'required|regex:/^1[3-8]\d{9}$/'
];