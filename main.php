<!DOCTYPE html>
<html>
<head>
<title>PointAndClickPHP - Hotspots with Overlay</title>
<style>
  body, html {
    height: 100%;
    margin: 0;
    overflow: hidden; /* Prevents potential scrollbars caused by animation/blur */
  }

  body {
    position: relative; /* Needed for pseudo-element and overlay positioning */
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
      // Define background image source *once*
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
      transform: translateY(100vh) ;
      opacity: 0;
    }
    50% {
        transform:translateY(-15px) scaleX(0.95);
        opacity: 1;
    }
    75% {
      transform:translateY(5px);
      opacity: 1;
    }
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }


  /* Style for the centered image */
  .centered-image {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    z-index: 1; /* Keep centered image above background, below overlay */
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    border-radius: 3%; /* Keep the rounded corners */
    /* cursor: pointer; /* REMOVED - Clicks handled by map areas */ */

    /* --- Apply the updated animation --- */
    opacity: 0; /* Start invisible before animation begins */
    animation-name: waveIn;
    animation-duration: 1.5s;
    animation-timing-function: ease-out;
    animation-fill-mode: forwards;
    animation-delay: 0.3s;
  }

  /* --- Style for the overlay image --- */
  .overlay-image {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    z-index: 2; /* Place overlay above the centered image */
    pointer-events: none; /* Allows clicks to pass through */
    opacity: 0; /* Hidden by default */
    transition: opacity 0.3s ease-in-out; /* Smooth fade effect */
  }

  /* --- Class to make the overlay visible --- */
  .overlay-image.is-visible {
    opacity: 1; /* Make it visible */
  }

  /* --- Style for map areas (optional, for cursor) --- */
  map area {
      cursor: pointer; /* Show pointer cursor over clickable areas */
  }


</style>
</head>
<body>

  <?php
    // Define image sources
    $foregroundImageSrc = 'image4.jpg';
    $overlayImageSrc = 'onlights.png';
  ?>

  <!-- Centered Image -->
  <img
    id="lightSwitchImage"
    src="<?php echo htmlspecialchars($foregroundImageSrc); ?>"
    alt="Interactive Image - Click hotspots to toggle light"
    class="centered-image"
    usemap="#lightHotspots"
  >

  <!-- Overlay Image -->
  <img
    id="lightOverlay"
    src="<?php echo htmlspecialchars($overlayImageSrc); ?>"
    alt="Overlay Effect"
    class="overlay-image"
  >

  <!-- Define the Image Map -->
  <!-- IMPORTANT: You MUST replace the example 'coords' below -->
  <!-- with actual pixel coordinates from your image4.jpg. -->
  <!-- Use an online image map generator or image editor to find them. -->
  <map name="lightHotspots">
    <!-- Example 2: Circular hotspot -->
    <!-- coords="center-x, center-y, radius" -->
    <area
      shape="circle"
      coords="520,350,50"
      href="#"
      alt="Hotspot 2"
      title="Toggle Light"
      class="light-hotspot-area" 
    >

    <!-- Add more <area> tags here for other hotspots -->
    <!-- Example 3: Polygonal hotspot -->
    <!-- coords="x1,y1,x2,y2,x3,y3,..." -->
    <!--
    <area
      shape="poly"
      coords="300,100,350,200,250,200" <-- *** ADJUST THESE COORDINATES *** ->
      href="#"
      alt="Hotspot 3"
      title="Toggle Light"
      class="light-hotspot-area"
    >
    -->
  </map>


  <!-- JavaScript for the toggle functionality -->
  <script>
    // Get reference to the overlay image
    const lightOverlay = document.getElementById('lightOverlay');
    // Get all the clickable areas within the map using the class
    const hotspotAreas = document.querySelectorAll('.light-hotspot-area');

    // Check if overlay and areas were found
    if (lightOverlay && hotspotAreas.length > 0) {

      // Add an event listener to EACH hotspot area
      hotspotAreas.forEach(area => {
        area.addEventListener('click', function(event) {
          event.preventDefault(); // Prevent the default link behavior (#)
          // Toggle the 'is-visible' class on the overlay image
          lightOverlay.classList.toggle('is-visible');
        });
      });

    } else {
      // Log specific errors if elements are missing
      if (!lightOverlay) {
          console.error("Could not find the overlay element with ID 'lightOverlay'!");
      }
      if (hotspotAreas.length === 0) {
          console.error("Could not find any hotspot area elements with class 'light-hotspot-area'!");
      }
    }
  </script>

</body>
</html>
