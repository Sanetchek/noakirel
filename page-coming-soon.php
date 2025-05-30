<?php
/* Template Name: Coming Soon */
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0;padding:0;height:100vh;width:100vw;overflow:hidden;background:#460a09;display:flex;align-items:center;justify-content:center;flex-direction:column">

<img src="https://noakirel.co/wp-content/uploads/2025/05/coming-soon-facebook.jpg" alt="Coming Soon" style="max-width:100%;max-height:100%;height:auto;width:auto;position: absolute;">


<div id="countdown" class="countdown">
  <div class="time-box">
    <div class="time-value" id="days">00</div>
    <div class="time-label">DAYS</div>
  </div>
  <div class="separator">:</div>
  <div class="time-box">
    <div class="time-value" id="hours">00</div>
    <div class="time-label">HOURS</div>
  </div>
  <div class="separator">:</div>
  <div class="time-box">
    <div class="time-value" id="minutes">00</div>
    <div class="time-label">MINUTES</div>
  </div>
  <div class="separator">:</div>
  <div class="time-box">
    <div class="time-value" id="seconds">00</div>
    <div class="time-label">SECONDS</div>
  </div>
</div>


<style media="screen">
.countdown {
  display:flex;gap:20px;color:#d8cfcf;font-family:sans-serif;text-align:center;margin-top:20px;position: relative;"
}

.separator {
  color: rgba(255, 255, 255, 0.80);
  text-align: right;
  font-family: Helvetica;
  font-size: 100px;
  font-style: normal;
  font-weight: 700;
  line-height: 30px; /* 30% */
}

.time-box {
  display: flex;
  flex-direction:column;
  gap: 30px;
  align-items: center;
}

.time-value {
font-size: 100px;
font-weight: 700;
font-style: normal;
line-height: 30px; /* 30% */
color: rgba(255, 255, 255, 0.8);
}

.time-label {
margin-top: 30px;
font-size: 30px;
font-weight: 300;
font-style: normal;
line-height: 30px; /* 100% */
color: rgba(255, 255, 255, 0.8);
}

@media (max-width: 768px) {
  .separator {
    font-size: 40px;
  }

  .time-value {
    font-size: 50px;
  }

  .time-label {
    font-size: 14px;
  }

  .countdown {
    gap: 10px;
    margin-top: 10px;
  }

  .time-box {
    min-width: 60px;
    gap: 0px;
  }
}

</style>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-7D0LZ9X9CS');
</script>



<script>
  const targetDate = new Date("2025-05-15T00:00:00").getTime();

  function updateCountdown() {
    const now = new Date().getTime();
    const distance = targetDate - now;

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("days").innerText = String(days).padStart(2, '0');
    document.getElementById("hours").innerText = String(hours).padStart(2, '0');
    document.getElementById("minutes").innerText = String(minutes).padStart(2, '0');
    document.getElementById("seconds").innerText = String(seconds).padStart(2, '0');
  }

  setInterval(updateCountdown, 1000);
  updateCountdown();
</script>



</body>
</html>
