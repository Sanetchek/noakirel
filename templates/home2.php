<?php
/**
 * Template Name: Home 2
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package storefront
 */

get_header(); ?>

<div id="home2">
  <h1 class="hidden-for-users sr-only"><?= __('Noakirel home page', 'noakirel') ?></h1>
  <section id="home2_hero" class="home2-hero two-columns" role="region" aria-labelledby="hero-heading">
    <div class="home2-hero-side column-side home2-hero-content">
      <h2 class="hidden-for-users sr-only"><?= __('Hero', 'noakirel') ?></h2>
      <?php $title_image = get_field('title_image'); ?>
      <?php if ($title_image) : ?>
        <div class="hero2-title-image">
          <?php
            echo liteimage($title_image, [
              'thumb' => [407, 0],
              'args' => ['alt' => esc_attr(get_post_meta($title_image, '_wp_attachment_image_alt', true) ?: __('Title image', 'noakirel'))]
            ]);
          ?>
        </div>
      <?php endif ?>

      <?php $gallery = get_field('gallery'); ?>
      <?php if ($gallery) : ?>
        <div id="hero2_gallery" class="hero2-gallery side swiper-container" role="region" aria-label="<?= __('Image gallery', 'noakirel') ?>">
          <div class="swiper-wrapper">
            <?php foreach ($gallery as $image_id) : ?>
              <div class="swiper-slide">
                <div class="hero2-gallery-item">
                  <?php
                    echo liteimage($image_id, [
                      'thumb' => [528, 528],
                      'max' => [
                        '1600' => [480, 480],
                        '420' => [420, 420]
                      ],
                      'args' => [
                        'loading' => 'eager',
                      ]
                    ]);
                  ?>
                </div>
              </div>
            <?php endforeach ?>
          </div>
          <div class="swiper-pagination" aria-label="<?= __('Gallery navigation', 'noakirel') ?>"></div>
        </div>
      <?php endif ?>

      <?php $link = get_field('link'); ?>
      <?php if ($link) : ?>
        <a class="btn-link hero2-link" href="<?= esc_url($link['url']) ?>"
          <?= $link['target'] ? 'target="' . esc_attr($link['target']) . '" rel="noopener noreferrer"' : '' ?>
          aria-label="<?= esc_attr($link['title'] . __(' link', 'noakirel')) ?>">
          <?= esc_html($link['title']) ?>
        </a>
      <?php endif ?>
    </div>

    <div class="home2-hero-side column-side home2-hero-media">
      <?php $video = get_field('video'); ?>
      <?php if ($video) : ?>
        <div class="video-wrapper">
          <video autoplay muted loop playsinline aria-label="<?= __('Hero video', 'noakirel') ?>">
            <source src="<?= esc_url($video['url']) ?>" type="<?= esc_attr($video['mime_type']) ?>">
            <?= __('Your browser does not support the video tag.', 'noakirel') ?>
          </video>
        </div>
      <?php endif ?>
    </div>

  </section>

  <section id="home2_flavor" class="home2-flavor">
    <h2 class="hidden-for-users sr-only"><?= __('Flavors', 'noakirel') ?></h2>
    <?php $flavors = get_field('flavors'); ?>
    <?php if ($flavors) : ?>
      <div class="home2-flavor-list three-columns">
      <?php foreach ($flavors as $flavor) : ?>
        <div class="home2-flavor-item column-side">
          <?php $image_id = $flavor['image']; ?>
          <?php if ($image_id) : ?>
          <div class="home2-flavor-image">
            <?php echo liteimage($image_id, [
              'thumb' => [0, 147],
            ]); ?>
          </div>
          <?php endif; ?>

          <p class="home2-flavor-description">
            <?= esc_html( $flavor['text'] ) ?>
          </p>
        </div>
      <?php endforeach ?>
      </div>
    <?php endif ?>
  </section>

  <section id="home2_banner" class="home2-banner">
    <h2 class="hidden-for-users sr-only"><?= __('Banner', 'noakirel') ?></h2>

    <?php $link = get_field('banner_link'); ?>
    <?php if ($link) : ?>
      <a class="home2-banner-link" href="<?= esc_url($link['url']) ?>" aria-label="<?= _e('Banner link', 'noakirel') ?>">
    <?php endif ?>

    <?php $image_id = get_field('banner_image'); ?>
    <?php if ($image_id) : ?>
      <?php $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: __('Image', 'noakirel'); ?>
      <?php echo liteimage($image_id, [
        'thumb' => [1920, 0],
        'max' => [
          '1440' => [1440, 0],
          '1280' => [1280, 0],
          '1024' => [1024, 0],
          '768' => [768, 0],
          '480' => [480, 0],
          '320' => [320, 0],
        ],
        'args' => ['alt' => $alt]
      ]); ?>
    <?php endif; ?>

    <?php if ($link) : ?>
      </a>
    <?php endif ?>
  </section>

  <section id="home2_our_products" class="home2-our-products">
    <?php $title = get_field('our_prod_title'); ?>
    <?php if ($title) : ?>
      <h2 class="home2-title home2-our-products-title"><?= esc_html($title) ?></h2>
    <?php endif ?>

    <?php $description = get_field('our_prod_description'); ?>
    <?php if ($description) : ?>
      <p class="home2-our-products-description"><?= esc_html($description) ?></p>
    <?php endif ?>

    <?php $link = get_field('our_prod_link'); ?>
    <?php if ($link) : ?>
      <a class="btn-link home2-our-products-link" href="<?= esc_url($link['url']) ?>"
        <?= $link['target'] ? 'target="' . esc_attr($link['target']) . '" rel="noopener noreferrer"' : '' ?>
        aria-label="<?= esc_attr($link['title'] . __(' link', 'noakirel')) ?>">
        <?= esc_html($link['title']) ?>
      </a>
    <?php endif ?>

    <?php $field = get_field('products_list'); ?>
    <?php if ($field) : ?>
      <div class="home2-product-list three-columns">
        <?php foreach ($field as $product_id) : ?>
          <div class="column-side">
            <?php echo render_home2_product_item( $product_id ) ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>

  <section id="home2_collection" class="home2-collection">
    <?php $title = get_field('collection_title'); ?>
    <?php if ($title) : ?>
      <h2 class="home2-title home2-collections-title"><?= esc_html($title) ?></h2>
    <?php endif ?>

    <?php $link = get_field('collection_link'); ?>
    <?php if ($link) : ?>
      <a class="btn-link home2-collection-link" href="<?= esc_url($link['url']) ?>"
        <?= $link['target'] ? 'target="' . esc_attr($link['target']) . '" rel="noopener noreferrer"' : '' ?>
        aria-label="<?= esc_attr($link['title'] . __(' link', 'noakirel')) ?>">
        <?= esc_html($link['title']) ?>
      </a>
    <?php endif ?>

    <?php $field = get_field('collection_list'); ?>
    <?php if ($field) : ?>
      <div class="home2-collection-list swiper-container">
        <div class="swiper-wrapper">
          <?php foreach ($field as $product_id) : ?>
            <div class="swiper-slide">
              <?php echo render_home2_product_item($product_id, [425, 425]); ?>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    <?php endif; ?>
  </section>

  <section id="home2_subscription" class="home2-subscription container">
    <?php $title = get_field('subscription_title', 'option'); ?>
    <?php if ($title) : ?>
      <h2 class="home2-subscription-title home2-title"><?= esc_html($title) ?></h2>
    <?php else : ?>
      <h2 class="hidden-for-users sr-only"><?= __('Subscribe', 'noakirel') ?></h2>
    <?php endif ?>

    <?php $form_subscription = get_field('subscription_form_short_code', 'option'); ?>
    <?php if ($form_subscription) : ?>
      <div class="home2-subscription-form">
        <?php echo do_shortcode($form_subscription); ?>
      </div>
    <?php endif ?>
  </section>
</div>

<?php get_footer(); ?>