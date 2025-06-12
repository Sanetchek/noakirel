<?php
/**
 * Preloads font files for the theme by generating <link> tags.
 *
 * This function scans the specified font directory for font files with extensions
 * ttf, otf, woff, and woff2. It groups the fonts by their base name and generates
 * HTML <link> tags to preload each font file. The tags are printed to the output
 * with attributes set for the appropriate font type and cross-origin configuration.
 */

function noakirel_preload_fonts() {
  $fontPath = '/assets/fonts/theme/';
  $fontDir = get_template_directory() . $fontPath;
  $fonts = [];
  $fontFiles = glob($fontDir . '*.{ttf,otf,woff,woff2}', GLOB_BRACE);

  foreach ($fontFiles as $file) {
    $fileName = basename($file);
    $baseName = pathinfo($file, PATHINFO_FILENAME);
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if (!isset($fonts[$baseName])) {
        $fonts[$baseName] = [];
    }
    $fonts[$baseName][] = $fileName;
  }

  foreach ($fonts as $baseName => $files) {
    foreach ($files as $file) {
      $ext = pathinfo($file, PATHINFO_EXTENSION);
      $asAttr = $ext === 'woff2' ? 'font' : 'font';
      $url = get_template_directory_uri() . $fontPath . $file;
      printf(
        '<link rel="preload" href="%s" as="%s" type="font/%s" crossorigin>',
        esc_url($url),
        esc_attr($asAttr),
        esc_attr($ext)
      );
    }
  }
}
add_action('wp_head', 'noakirel_preload_fonts');