<?php
if (!defined('ABSPATH')) { exit; }

function baraem_setup() {
  load_theme_textdomain('baraem-nursery', get_template_directory() . '/languages');
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo', array('height' => 120, 'width' => 320, 'flex-height' => true, 'flex-width' => true));
  add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
  register_nav_menus(array('primary' => 'القائمة الرئيسية'));
}
add_action('after_setup_theme', 'baraem_setup');

function baraem_assets() {
  wp_enqueue_style('baraem-fonts', 'https://fonts.googleapis.com/css2?family=Alexandria:wght@400;500;600;700;800&family=Cairo:wght@400;500;600;700;800&display=swap', array(), null);
  wp_enqueue_style('baraem-style', get_stylesheet_uri(), array(), '1.0.0');
  wp_enqueue_style('baraem-layout', get_template_directory_uri() . '/assets/css/site.css', array('baraem-style', 'baraem-fonts'), '1.0.0');
  wp_enqueue_script('baraem-script', get_template_directory_uri() . '/assets/js/site.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'baraem_assets');

function baraem_default($key, $fallback = '') { return get_theme_mod($key, $fallback); }
function baraem_customizer($wp_customize) {
  $wp_customize->add_section('baraem_content', array('title' => 'محتوى موقع براعم', 'priority' => 30, 'description' => 'عدّلي النصوص والصور وبيانات التواصل من هنا.'));
  $fields = array(
    'hero_title' => array('عنوان البانر', 'بداية حلوة لكل حكاية.'),
    'hero_text' => array('نص البانر', 'في براعم، كل يوم مغامرة جديدة. بنوفّر لطفلك مساحة آمنة مليانة لعب واكتشاف، ونساعده يكبر واثق وسعيد.'),
    'hero_image' => array('صورة البانر', ''),
    'program_image' => array('صورة قسم البرنامج', ''),
    'phone' => array('رقم الهاتف', '0100 000 0000'),
    'whatsapp' => array('رقم واتساب مع كود الدولة', '201000000000'),
    'address' => array('العنوان', 'أضيفي عنوان الحضانة هنا'),
    'email' => array('البريد الإلكتروني', 'hello@baraem.example'),
    'review' => array('رأي أحد الأهالي', 'ابني بقى يحب يروح كل يوم، وأنا مطمنة إنه في مكان بيهتم بيه وبيفرح بكل حاجة جديدة بيتعلمها.'),
    'review_name' => array('اسم صاحب/ة الرأي', 'ماما ياسين'),
  );
  foreach ($fields as $id => $info) {
    $wp_customize->add_setting('baraem_' . $id, array('default' => $info[1], 'sanitize_callback' => 'sanitize_text_field'));
    if (in_array($id, array('hero_image', 'program_image'), true)) {
      $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'baraem_' . $id, array('label' => $info[0], 'section' => 'baraem_content', 'settings' => 'baraem_' . $id)));
    } else {
      $wp_customize->add_control('baraem_' . $id, array('label' => $info[0], 'section' => 'baraem_content', 'type' => 'text'));
    }
  }
}
add_action('customize_register', 'baraem_customizer');

function baraem_logo() {
  if (has_custom_logo()) { the_custom_logo(); }
  else { echo '<a class="brand" href="' . esc_url(home_url('/')) . '"><span class="logo">🌱</span><span>' . esc_html(get_bloginfo('name') ?: 'براعم') . '<small>حضانة · لعب · اكتشاف</small></span></a>'; }
}
