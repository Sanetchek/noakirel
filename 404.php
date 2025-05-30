<?php
/**
 * Custom 404 Template
 * @package storefront
 */

get_header(); ?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

  .custom-404 {
    text-align: center;
    padding: 100px 20px;
    font-family: 'Roboto', sans-serif;
    direction: rtl;
    background-color: #f9f9f9;
  }
  .custom-404 img {
		max-width: 200px;
    text-align: center;
    margin: 20px auto;
  }
  .custom-404 h1 {
    font-size: 48px;
    margin-bottom: 20px;
    color: #222;
    font-weight: 700;
  }
  .custom-404 p {
    font-size: 20px;
    color: #666;
    margin-bottom: 40px;
    font-weight: 400;
  }
  .custom-404 a {
    display: inline-block;
    padding: 12px 24px;
    background-color: #000;
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    border-radius: 8px;
    transition: background-color 0.3s;
    font-weight: 400;
  }
  .custom-404 a:hover {
    background-color: #333;
  }
</style>

<div class="custom-404">
  <img src="https://noakirel.co/wp-content/uploads/2025/05/Isolation_Mode-2.svg" alt="לוגו נועה קירל">
  <h1>אופס! הדף לא נמצא</h1>
  <p>הדף שחיפשת לא קיים או הועבר למקום אחר.</p>
  <a href="<?= home_url(); ?>">חזרה לדף הבית</a>
</div>

<?php
get_footer();
