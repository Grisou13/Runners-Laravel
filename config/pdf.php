<?php
return [
  'mode'                 => '',
  'format'               => 'A3',
  'default_font_size'    => '26',
  'default_font'         => 'sans-serif',
  'margin_left'          => 10,
  'margin_right'         => 10,
  'margin_top'           => 10,
  'margin_bottom'        => 10,
  'margin_header'        => 0,
  'margin_footer'        => 0,
  'orientation'          => 'P',
  'title'                => 'Runners pdf',
  'author'               => '',
  'watermark'            => '',
  'show_watermark'       => false,
  'watermark_font'       => 'sans-serif',
  'display_mode'         => 'fullpage',
  'watermark_text_alpha' => 0.1,
  'custom_font_path' => base_path('/resources/fonts/'), // don't forget the trailing slash!
  'custom_font_data' => [
    'Droid Serif' => [
      'R'  => 'DroidSerif.ttf',    // regular font
      'B'  => 'DroidSerif-Bold.ttf',       // optional: bold font
      'I'  => 'DroidSerif-Italic.ttf',     // optional: italic font
      'BI' => 'DroidSerif-BoldItalic.ttf' // optional: bold-italic font
    ]
    // ...add as many as you want.
  ]
];