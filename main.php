<!DOCTYPE html>
<html>
<head>
<title>PointAndClickPHP - Animated Centered Image</title>
<style>
  body, html {
    height: 100%;
    margin: 0;
    overflow: hidden; /* Prevents potential scrollbars caused by animation/blur */
  }

  body {
    position: relative; /* Needed for the ::before pseudo-element positioning */
    /* Flexbox centers the direct child (the img tag in this case) */
    display: flex;
    justify-content: center;
    align-items: center;
  }

  body::before {
    content: ''; /* Required for pseudo-elements */
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1; /* Place the pseudo-element behind the body's content */

    <?php
      $backgroundImageSrc = 'image4.jpg';
    ?>
    background-image: url('<?php echo htmlspecialchars($backgroundImageSrc); ?>');
    background-size: cover;
    background-position: center;
    filter: blur(10px);
    transform: scale(1.02);
  }

  /* --- Define the wave-in animation (without stretching) --- */
  @keyframes waveIn {
    from {
      /* Start below the viewport and invisible */
      transform: translateY(100vh) ; /* Removed scaleY(1.3) */
      opacity: 0;
    }
    50% {
        transform:translateY(-15px) scaleX(0.95); /* Overshoot slightly (e.g., -15px) - Removed scaleY(1.05) */
        opacity: 1; /* Become fully visible */
    } 
    /* Move past the center point */
    75% {
      transform:translateY(5px); /* Overshoot slightly (e.g., -15px) - Removed scaleY(1.05) */
      opacity: 1; /* Become fully visible */
    }

    /* Settle back to the final position */
    to {
      transform: translateY(0); /* Final resting position - Removed scaleY(1) */
      opacity: 1;
    }
  }


  /* Style for the centered image */
  .centered-image {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    z-index: 1;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    border-radius: 3%; /* Keep the rounded corners */

    /* --- Apply the updated animation --- */
    opacity: 0; /* Start invisible before animation begins */
    animation-name: waveIn; /* Use the new animation name */
    animation-duration: 1.5s; /* Maybe slightly longer for the wave effect */
    animation-timing-function: ease-out; /* ease-out often works well for this settle effect */
    animation-fill-mode: forwards; /* Keep the final state */
    /* Optional: Add a delay before the animation starts */
    animation-delay: 0.5s;
  }

</style>
</head>
<body>

  <?php
    $foregroundImageSrc = 'image4.jpg';
  ?>
  <img
    src="<?php echo htmlspecialchars($foregroundImageSrc); ?>"
    alt="Centered Image"
    class="centered-image"
  >
</body>
</html>
