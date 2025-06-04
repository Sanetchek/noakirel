<?php
/* Template Name: Front - Home */
get_header(); ?>

  <?php
  $section = get_field('section_hero');

  if ( $section ) :
    $images = $section['slider_image'];
    $title = $section['title'];
    $logo = $section['logo'];
    $description = $section['description'];
  ?>
  <section class="signature_wrapper">
    <div class="signature" data-aos="fade-right">
      <div class="swiper signature-swiper">
        <div class="swiper-wrapper">
          <?php if ( $images ) :
            foreach ( $images as $img ) : ?>
              <div class="swiper-slide">
                <img src="<?= esc_url( $img['url'] ) ?>" alt="<?= esc_attr( $img['alt'] ) ?>">
              </div>
          <?php endforeach; endif; ?>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>

    <div class="signature_info" data-aos="fade-left">
      <div class="signature_info_wrapper">
        <div class="signature_info_wrapper_block">
          <?php if ( $title ) : ?>
            <h1><?= esc_html( $title ) ?></h1>
          <?php endif; ?>

          <?php if ( $logo ) : ?>
            <img src="<?= esc_url( $logo ) ?>" alt="logo" />
          <?php endif; ?>
        </div>


        <?php if ( $description ) : ?>
          <p><?= esc_html( $description ) ?></p>
        <?php endif; ?>

        <?php
        $product_id = 77;
        $product = wc_get_product($product_id);
        ?>

        <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
           data-quantity="1"
           class="btn_add add_to_cart_button ajax_add_to_cart"
           data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
           data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
           aria-label="<?php echo esc_html( $product->add_to_cart_description() ); ?>"
           rel="nofollow">

           <span class="btn-text">קנו עכשיו</span>
           <span class="btn-icon">
             <span class="icon-cart"><img src="https://noakirel.co/wp-content/uploads/2025/04/Link.svg" alt="asd"></span>
             <span class="icon-check" style="display:none;">✔️</span>
           </span>
        </a>

      </div>
    </div>
  </section>
  <?php endif; ?>



  <?php
  $video_group = get_field('section_video');
  $video_url = $video_group['video'] ?? '';

  if ( $video_url ) :
  ?>
  <section class="video">
    <div class="video-wrapper">
      <video autoplay muted loop playsinline>
        <source src="<?= esc_url( $video_url ) ?>" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
  </section>
  <?php endif; ?>


  <?php
  $perfume = get_field('section_perfume');

  $cust_img = get_field('custom_image_for_test');
  echo wp_get_attachment_image($cust_img);

  if ( $perfume ) :
    $image = $perfume['main_image'];
    $image_url = is_array($image) ? $image['url'] : $image;
    $image_alt = is_array($image) && isset($image['alt']) ? $image['alt'] : 'perfume_wrapper';

    $title = $perfume['title'];
    $description = $perfume['description'];
    $sub_description = $perfume['sub_description'];
    $sub_title = $perfume['sub_title'];
    $blocks = $perfume['block_info'];
  ?>
  <section class="perfume"  id="SIGNATURE" data-aos="fade-right">
    <div class="perfume_wrapper">
      <?php if ( $image_url ) : ?>
        <img src="<?= esc_url( $image_url ) ?>" alt="<?= esc_attr( $image_alt ) ?>">
      <?php endif; ?>

      <div class="perfume_wrapper_info">
        <?php if ( $title ) : ?>
          <h2><?= esc_html( $title ) ?></h2>
        <?php endif; ?>

        <?php if ( $description ) : ?>
          <p><?= esc_html( $description ) ?></p>
        <?php endif; ?>

        <?php if ( $sub_description ) : ?>
          <span><?= esc_html( $sub_description ) ?></span>
        <?php endif; ?>

        <?php
        $product_id = 77;
        $product = wc_get_product($product_id);
        ?>

        <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
           data-quantity="1"
           class="btn_add add_to_cart_button ajax_add_to_cart"
           data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
           data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
           aria-label="<?php echo esc_html( $product->add_to_cart_description() ); ?>"
           rel="nofollow">

           <span class="btn-text">קנו עכשיו</span>
           <span class="btn-icon">
             <span class="icon-cart"><img src="https://noakirel.co/wp-content/uploads/2025/04/Link.svg" alt="asd"></span>
             <span class="icon-check" style="display:none;">✔️</span>
           </span>
        </a>
      </div>
    </div>

    <?php if ( $sub_title || ! empty( $blocks ) ) : ?>
      <div class="notes" data-aos="fade-left">
        <?php if ( $sub_title ) : ?>
          <h2><?= esc_html( $sub_title ) ?></h2>
        <?php endif; ?>

        <?php if ( $blocks ) : ?>
          <div class="notes_blocks">
            <?php foreach ( $blocks as $block ) : ?>
              <div class="notes_blocks_block">
                <?php if ( !empty($block['title']) ) : ?>
                  <h3><?= esc_html( $block['title'] ) ?></h3>
                <?php endif; ?>
                <?php if ( !empty($block['description']) ) : ?>
                  <p><?= esc_html( $block['description'] ) ?></p>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </section>
  <?php endif; ?>



  <?php
  $banner_field = get_field('section_banner');
  $banner_image = $banner_field['banner'] ?? '';

  $banner_url = is_array($banner_image) ? $banner_image['url'] : $banner_image;
  $banner_alt = is_array($banner_image) && !empty($banner_image['alt']) ? $banner_image['alt'] : 'banner';

  if ( $banner_url ) :
  ?>
  <section class="banner">
    <img src="<?= esc_url( $banner_url ) ?>" alt="<?= esc_attr( $banner_alt ) ?>">
  </section>
  <?php endif; ?>


  <?php
$about = get_field('section_about');

if ( $about ) :
  $main_image = $about['main_image'];
  $main_image_url = is_array($main_image) ? $main_image['url'] : $main_image;

  $title = $about['title'];
  $description = $about['description'];
  $sub_description = $about['sub_description'];
  $sub_title = $about['sub_title'];
  $logo = $about['logo'];
  $logo_url = is_array($logo) ? $logo['url'] : $logo;

  $items = $about['item_blocks'];
?>
<section class="about" id="second" data-aos="fade-right">
  <div class="about_wrapper">
    <div class="about_info">
      <?php if ( $title ) : ?>
        <h2><?= esc_html( $title ) ?></h2>
      <?php endif; ?>

      <?php if ( $description ) : ?>
        <p><?= esc_html( $description ) ?></p>
      <?php endif; ?>

      <?php if ( $items ) : ?>
        <div class="about_info_blocks">
          <?php foreach ( $items as $item ) :
            $item_image = $item['image'];
            $item_image_url = is_array($item_image) ? $item_image['url'] : $item_image;
            ?>
            <div class="about_info_blocks_item">
              <?php if ( $item_image_url ) : ?>
                <img src="<?= esc_url( $item_image_url ) ?>" alt="img">
              <?php endif; ?>
              <?php if ( $item['title'] ) : ?>
                <p><?= esc_html( $item['title'] ) ?></p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if ( $sub_description ) : ?>
        <p class="about_info_desc"><?= esc_html( $sub_description ) ?></p>
      <?php endif; ?>
    </div>

    <div class="about_image">
      <?php if ( $main_image_url ) : ?>
        <img src="<?= esc_url( $main_image_url ) ?>" alt="img">
      <?php endif; ?>
    </div>
  </div>

  <?php if ( $sub_title || $logo_url ) : ?>
    <div class="about_link">
      <?php if ( $sub_title ) : ?>
        <p><?= esc_html( $sub_title ) ?></p>
      <?php endif; ?>
      <?php if ( $logo_url ) : ?>
        <img src="<?= esc_url( $logo_url ) ?>" alt="image">
      <?php endif; ?>
    </div>
  <?php endif; ?>
</section>
<?php endif; ?>



<?php
$reviews = get_field('section_reviews');

if ( $reviews ) :
  $title = $reviews['title'];
  $blocks = $reviews['reviews_block'];
?>
<section class="reviews" id="third" data-aos="fade-left">
  <?php if ( $title ) : ?>
    <h2><?= esc_html( $title ) ?></h2>
  <?php endif; ?>

  <?php if ( $blocks ) : ?>
    <div class="swiper reviews-swiper">
      <div class="swiper-wrapper">
        <?php foreach ( $blocks as $block ) :
          $description = $block['description'] ?? '';
          $date_string = $block['date'] ?? '';
          $date = '';

          if ( $date_string ) {
            // Подставь нужный формат, если отличается
            $dt = DateTime::createFromFormat('d/m/Y', $date_string);
            if ( $dt ) {
              $date = date_i18n('j בF Y', $dt->getTimestamp());
            }
          }

          $stars = intval($block['star'] ?? 0);
          $name = $block['name'] ?? '';
        ?>
          <div class="swiper-slide reviews_wrapper_block">
            <?php if ( $stars > 0 ) : ?>
              <div class="review-stars" style="display: flex; gap: 4px; margin-bottom: 8px;">
                <?php for ( $i = 0; $i < $stars; $i++ ) : ?>
                  <img src="https://noakirel.co/wp-content/uploads/2025/05/Vector.svg" alt="star" width="20" height="20">
                <?php endfor; ?>
              </div>
            <?php endif; ?>

            <?php if ( $description ) : ?>
              <p><?= esc_html( $description ) ?></p>
            <?php endif; ?>

            <?php if ( $name || $date ) : ?>
              <span style="direction: rtl; display: block; text-align: right; unicode-bidi: plaintext;">
                <?= esc_html( $date ) ?><?= $name && $date ? ', ' : '' ?><?= esc_html( $name ) ?>
              </span>

            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  <?php endif; ?>
</section>
<?php endif; ?>





<?php
$subscribe = get_field('section_subscribe');

if ( $subscribe ) :
  $title = $subscribe['title'];
  $form_shortcode = $subscribe['form'];
?>
<section class="subscribe" id="four" data-aos="fade-right">
  <?php if ( $title ) : ?>
    <h2><?= esc_html( $title ) ?></h2>
  <?php endif; ?>

  <?php if ( $form_shortcode ) : ?>
    <?= do_shortcode( $form_shortcode ) ?>
  <?php endif; ?>
</section>
<?php endif; ?>

<?php get_footer(); ?>
