<!DOCTYPE html>
<html>
<head>
<title>MyRoom</title>
  <!-- เพิ่มบรรทัดนี้เพื่อกำหนด Favicon -->
  <link rel="icon" type="image/png" href="icon.png">
  <!-- หรือถ้าใช้ไฟล์ .ico -->
  <!-- <link rel="icon" type="image/x-icon" href="path/to/your/favicon.ico"> -->
  <!-- หรือถ้าใช้ไฟล์ .svg -->
  <!-- <link rel="icon" type="image/svg+xml" href="path/to/your/myicon.svg"> -->
<style>
  body, html {
    height: 100%;
    margin: 0;
    overflow: hidden; /* Prevents potential scrollbars */
  }

  body {
    position: relative; /* Needed for absolute positioning of children */
    display: flex;
    justify-content: center;
    align-items: center;
  }

  body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;

    <?php
      // Define PHP variables at the top for better organization
      $backgroundImageSrc = 'image4.jpg';
      $foregroundImageSrc = 'image4.jpg';
      $overlayImageSrc = 'onlights.png';
      $lightSoundSrc = 'onlights.wav';
      $bubbleSoundSrc = 'bubble.wav'; // Define bubble sound source
      $leafSoundSrc = 'leaf.wav'; // <-- *** เพิ่ม: กำหนดไฟล์เสียงใบไม้ ***
      // *** เพิ่ม: กำหนดไฟล์เสียงสำหรับจุดใหม่ ***
      $mirrorSoundSrc = 'glassknocking.wav'; // เสียงกระจก
      $screenSoundSrc = 'kockingonglasswindow.wav';   // เสียงจอ
      $keyboardSoundSrc = 'keyboard.ogg'; // เสียงคีย์บอร์ด
      $paperSoundSrc = 'book.wav'; // เสียงกระดาษ

      // Player 1
      $musicSrc1 = 'Shut up My Moms Calling.mp3';
      $playerImageSrc1 = 'Shut up My Moms Calling.jpg';
      $playerTitle1 = 'SHUT UP MY MOMS CALLING';
      $playerArtist1 = 'HOTEL UGLY';

      // Player 2
      $musicSrc2 = 'See You Again.mp3';
      $playerImageSrc2 = 'See You Again.jpg';
      $playerTitle2 = 'SEE YOU AGAIN';
      $playerArtist2 = 'TYLER';

      // Player 3
      $musicSrc3 = 'heaven sent.mp3'; // <-- Example: Use a different song
      $playerImageSrc3 = 'heaven sent.jpg'; // <-- Example: Use a different image
      $playerTitle3 = 'HEAVEN SENT';
      $playerArtist3 = 'TEVOMXNTANA';
    ?>

    /* debug */
    background-image: url('<?php echo htmlspecialchars($backgroundImageSrc); ?>');
    background-size: cover;
    background-position: center;
    filter: blur(10px);
    transform: scale(1.02);
  }

  @keyframes waveIn {
    from {
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

  .centered-image {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    z-index: 1;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    border-radius: 3%;
    opacity: 0;
    animation-name: waveIn;
    animation-duration: 1.5s;
    animation-timing-function: ease-out;
    animation-fill-mode: forwards;
    animation-delay: 0.3s;
  }

  .overlay-image {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    z-index: 2;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
  }

  .overlay-image.is-visible {
    opacity: 1;
  }

  map area {
      cursor: pointer;
  }
  /* *** ADDED: Cursor for leaf areas (optional) *** */
  .leaf-hotspot-area {
      cursor: pointer;
  }
  /* เพิ่ม cursor สำหรับ hotspot เสียงใหม่ (ถ้าต้องการ) */
  .sound-hotspot-area {
      cursor: pointer;
  }


  /* --- Style for ALL Music Players (Bubble Effect) --- */
  .music-player { /* <-- Common class */
    position: absolute;
    width: 300px;
    background-color: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 20px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    border-radius: 30px;
    z-index: 10;
    opacity: 0;
    pointer-events: none;
    transform: translateY(100vh);
    transition: opacity 0.4s ease-out, transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
    /* backdrop-filter: blur(8px); */
  }

  /* --- Class to make ANY music player visible --- */
  .music-player.is-visible { /* <-- Common class */
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0);
  }

  /* --- Styles for elements INSIDE the player --- */
  .music-player img {
      max-width: 100%;
      height: auto;
      display: block;
      margin-bottom: 15px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  .music-player .player-title {
      margin: 0 0 5px 0; /* Adjusted margins */
      padding-top: 5px; /* Add some space if needed */
      color: #eee;
      font-size: 1.1em; /* Slightly smaller */
      font-weight: bold;
      font-family: system-ui, sans-serif;
  }

  .music-player .player-artist {
      margin: 0;
      padding-top: -10px; /* Add some space if needed */
      font-size: 0.9em;
      color: #eee;
      font-weight: bold;
      font-family: system-ui, sans-serif;
      opacity: 0.8;
  }

  /* Hide default audio controls if not needed */
  .audio-controls-hidden {
      display: none;
  }

  .debug-area-overlay {
    position: absolute;
    border: 2px dashed red;
    border-radius: 50%;  
    pointer-events: none; 
    box-sizing: border-box; 
    z-index: 999;
    background-color: rgba(255, 0, 0, 0.1);
  }


</style>
</head>
<body>

  <!-- Centered Image -->
  <img
    id="lightSwitchImage"
    src="<?php echo htmlspecialchars($foregroundImageSrc); ?>"
    alt="Interactive Image - Click hotspots"
    class="centered-image"
    usemap="#sceneHotspots"
  >

  <!-- Overlay Image -->
  <img
    id="lightOverlay"
    src="<?php echo htmlspecialchars($overlayImageSrc); ?>"
    alt="Overlay Effect"
    class="overlay-image"
  >

    <!-- Define the Image Map -->
    <map name="sceneHotspots">
    <!-- Hotspot for the Light -->
    <area
      shape="circle"
      coords="530,350,50"
      href="#"
      alt="Toggle Light Hotspot"
      title="Toggle Light"
      class="light-hotspot-area"
    >

    <!-- Hotspot for the Music Player 1 -->
    <area
      shape="circle"
      coords="810,370,45"
      href="#"
      alt="Toggle Music Player 1 Hotspot"
      title="<?php echo htmlspecialchars($playerTitle1); ?>"
      class="music-hotspot-area"
      data-player-id="playMusic"
      data-audio-id="backgroundMusic"
    >

    <!-- Hotspot for the Music Player 2 -->
    <area
      shape="circle"
      coords="840,270,45"
      href="#"
      alt="Toggle Music Player 2 Hotspot"
      title="<?php echo htmlspecialchars($playerTitle2); ?>"
      class="music-hotspot-area"
      data-player-id="playMusic2"
      data-audio-id="backgroundMusic2" 
    >

    <!-- Hotspot for the Music Player 3 -->
    <area
      shape="circle"
      coords="290,830,50" 
      href="#"
      alt="Toggle Music Player 3 Hotspot"
      title="<?php echo htmlspecialchars($playerTitle3); ?>"
      class="music-hotspot-area"
      data-player-id="playMusic3" 
      data-audio-id="backgroundMusic3" 
    >
 <!-- *** ADDED: Hotspots for leaf sounds (5 points) *** -->
    <!-- (Adjust coords based on your image) -->
    <area
      shape="circle"
      coords="110,270,50"
      href="#"
      alt="Leaf Sound Hotspot 1"
      title="Rustle Leaves"
      class="leaf-hotspot-area"
    >
    <area
      shape="circle"
      coords="220,325,25"
      href="#"
      alt="Leaf Sound Hotspot 2"
      title="Rustle Leaves"
      class="leaf-hotspot-area"
    >
     <area
      shape="circle"
      coords="0,480,100"
      href="#"
      alt="Leaf Sound Hotspot 3"
      title="Rustle Leaves"
      class="leaf-hotspot-area"
    >
     <area
      shape="circle"
      coords="700,500,40"
      href="#"
      alt="Leaf Sound Hotspot 4"
      title="Rustle Leaves"
      class="leaf-hotspot-area"
    >
     <area
      shape="circle"
      coords="600,440,25"
      href="#"
      alt="Leaf Sound Hotspot 5"
      title="Rustle Leaves"
      class="leaf-hotspot-area"
    >
    <!-- *** ADDED: Hotspots for new sounds *** -->
    <area
      shape="poly"
      coords="18,27,139,45,144,351,31,355"
      href="#"
      alt="Mirror Sound Hotspot 1"
      title="Tap Mirror 1"
      class="sound-hotspot-area"
      data-sound-id="mirrorSound"
    >
    <area
      shape="poly"
      coords="175,36,322,59,320,357,179,366" 
      href="#"
      alt="Mirror Sound Hotspot 2"
      title="Tap Mirror 2"
      class="sound-hotspot-area"
      data-sound-id="mirrorSound"
    >
    <area
      shape="poly"
      coords="338,362,429,354,439,435,345,445" 
      href="#"
      alt="Screen Sound Hotspot"
      title="Screen Hum"
      class="sound-hotspot-area"
      data-sound-id="screenSound"
    >
    <area
      shape="poly"
      coords="338,486,455,468,491,483,378,501" 
      href="#"
      alt="Keyboard Sound Hotspot"
      title="Keyboard Click"
      class="sound-hotspot-area"
      data-sound-id="keyboardSound"
    >
    <area
      shape="poly"
      coords="579,125,680,109,721,126,750,154,749,202,686,208,683,287,653,287,649,339,576,284"
      href="#"
      alt="Paper Sound Hotspot 1"
      title="Rustle Paper 1"
      class="sound-hotspot-area"
      data-sound-id="paperSound"
    >
    <area
      shape="poly"
      coords="409,153,463,155,462,275,440,274,437,250,413,246" 
      href="#"
      alt="Paper Sound Hotspot 2"
      title="Rustle Paper 2"
      class="sound-hotspot-area"
      data-sound-id="paperSound"
    >
    <!-- *** End of added leaf hotspots *** -->

    <!-- Add more <area> tags here if needed -->
  </map>

  <!-- Audio Elements -->
  <audio id="lightSound" src="<?php echo htmlspecialchars($lightSoundSrc); ?>" preload="auto"></audio>
  <audio id="bubbleSound" src="<?php echo htmlspecialchars($bubbleSoundSrc); ?>" preload="auto"></audio>
  <audio id="leafSound" src="<?php echo htmlspecialchars($leafSoundSrc); ?>" preload="auto"></audio> <!-- *** ADD THIS LINE BACK *** -->
  <!-- *** ADDED: Audio elements for new sounds *** -->
  <audio id="mirrorSound" src="<?php echo htmlspecialchars($mirrorSoundSrc); ?>" preload="auto"></audio>
  <audio id="screenSound" src="<?php echo htmlspecialchars($screenSoundSrc); ?>" preload="auto"></audio>
  <audio id="keyboardSound" src="<?php echo htmlspecialchars($keyboardSoundSrc); ?>" preload="auto"></audio>
  <audio id="paperSound" src="<?php echo htmlspecialchars($paperSoundSrc); ?>" preload="auto"></audio>
  <!-- Add class to hide default controls if desired -->
  <audio id="backgroundMusic" class="audio-controls-hidden" src="<?php echo htmlspecialchars($musicSrc1); ?>" loop></audio>
  <audio id="backgroundMusic2" class="audio-controls-hidden" src="<?php echo htmlspecialchars($musicSrc2); ?>" loop></audio>
  <audio id="backgroundMusic3" class="audio-controls-hidden" src="<?php echo htmlspecialchars($musicSrc3); ?>" loop></audio> <!-- Corrected src -->

  <!-- Music Player Element 1 (Initially Hidden) -->
  <div id="playMusic" class="music-player"> <!-- Added common class -->
    <img src="<?php echo htmlspecialchars($playerImageSrc1); ?>" alt="Album Art for <?php echo htmlspecialchars($playerTitle1); ?>"> <!-- Removed inline style -->
    <p class="player-title"><?php echo htmlspecialchars($playerTitle1); ?></p> <!-- Added class, removed inline style -->
    <p class="player-artist"><?php echo htmlspecialchars($playerArtist1); ?></p> <!-- Added class, removed inline style -->
  </div>

  <!-- Music Player Element 2 (Initially Hidden) -->
  <div id="playMusic2" class="music-player"> <!-- Added common class -->
    <img src="<?php echo htmlspecialchars($playerImageSrc2); ?>" alt="Album Art for <?php echo htmlspecialchars($playerTitle2); ?>"> <!-- Removed inline style -->
    <p class="player-title"><?php echo htmlspecialchars($playerTitle2); ?></p> <!-- Added class, removed inline style -->
    <p class="player-artist"><?php echo htmlspecialchars($playerArtist2); ?></p> <!-- Added class, removed inline style -->
  </div>

  <!-- Music Player Element 3 (Initially Hidden) -->
  <div id="playMusic3" class="music-player"> <!-- Added common class -->
    <img src="<?php echo htmlspecialchars($playerImageSrc3); ?>" alt="Album Art for <?php echo htmlspecialchars($playerTitle3); ?>"> <!-- Corrected src, removed inline style -->
    <p class="player-title"><?php echo htmlspecialchars($playerTitle3); ?></p> <!-- Added class, removed inline style -->
    <p class="player-artist"><?php echo htmlspecialchars($playerArtist3); ?></p> <!-- Added class, removed inline style -->
  </div>

  <!-- JavaScript for the toggle functionality -->
  <script>
    // Get references to elements
    const lightSwitchImage = document.getElementById('lightSwitchImage');
    const lightOverlay = document.getElementById('lightOverlay');
    const lightHotspotAreas = document.querySelectorAll('.light-hotspot-area');
    const lightSound = document.getElementById('lightSound');
    const bubbleSound = document.getElementById('bubbleSound');
    const leafSound = document.getElementById('leafSound'); // <-- *** ADDED: Get leaf sound element ***
    // *** ADDED: Get new sound elements ***
    const mirrorSound = document.getElementById('mirrorSound');
    const screenSound = document.getElementById('screenSound');
    const keyboardSound = document.getElementById('keyboardSound');
    const paperSound = document.getElementById('paperSound');

    // Get all music players and hotspots using the common class
    const musicPlayerElements = document.querySelectorAll('.music-player');
    const musicHotspotAreas = document.querySelectorAll('.music-hotspot-area[data-player-id]'); // Select only music hotspots

    // *** ADDED: Get leaf hotspot elements ***
    const leafHotspotAreas = document.querySelectorAll('.leaf-hotspot-area');

    // *** ADDED: Get new sound hotspot elements *** <--- ใส่บรรทัดนี้เพิ่ม
    const soundHotspotAreas = document.querySelectorAll('.sound-hotspot-area');

    // Store audio elements and playing state
    const audioElements = {};
    const musicPlayingState = {};

    musicPlayerElements.forEach(player => {
        const audioId = player.id.replace('playMusic', 'backgroundMusic');
        const audioElement = document.getElementById(audioId);
        if (audioElement) {
            audioElements[player.id] = audioElement;
            musicPlayingState[player.id] = false; // Initialize playing state
        } else {
            console.error(`Could not find audio element with ID: ${audioId} for player ${player.id}`);
        }
    });


    // --- Set Initial Volume ---
    if (bubbleSound) bubbleSound.volume = 0.7;
    if (lightSound) lightSound.volume = 1.0; // Example: Full volume for light
    if (leafSound) leafSound.volume = 0.6; // <-- *** ADDED: Set initial leaf sound volume ***
    if (mirrorSound) mirrorSound.volume = 0.5;
    if (screenSound) screenSound.volume = 0.5;
    if (keyboardSound) keyboardSound.volume = 0.5;
    if (paperSound) paperSound.volume = 0.5;
    Object.values(audioElements).forEach(audio => {
        if (audio) audio.volume = 0.4; // Set volume for all music tracks
    });

    // --- Function to Update Music Player Position ---
    function updateMusicPlayerPosition(playerElement, imageElement) {
        if (!imageElement || !playerElement) return;

        // Ensure player is visible to get correct dimensions (or calculate based on CSS)
        const wasHidden = playerElement.style.display === 'none' || playerElement.style.opacity === '0';
        if (wasHidden) {
            playerElement.style.visibility = 'hidden'; // Keep it in layout flow but invisible
            playerElement.style.display = ''; // Or 'block'/'flex' depending on CSS
            playerElement.style.opacity = '0'; // Ensure opacity is 0 if using opacity transition
        }

        const imageRect = imageElement.getBoundingClientRect();
        const playerHeight = playerElement.offsetHeight;
        const playerWidth = playerElement.offsetWidth;
        const margin = 20;
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight; // Get viewport height
        
        // Restore visibility if it was temporarily changed
        if (wasHidden) {
            playerElement.style.visibility = '';
            playerElement.style.display = ''; // Let CSS handle display
        }

        let topPosition = imageRect.bottom - playerHeight + window.scrollY;
        let leftPosition = imageRect.right + margin;

        // // Default position: Right of the image
        // let leftPosition = imageRect.right + margin;
        // let topPosition = imageRect.top + (imageRect.height / 2) - (playerHeight / 2) + window.scrollY; // Center vertically relative to image

        // Check right boundary
        if (leftPosition + playerWidth > viewportWidth - margin) {
            // Move to the left of the image
            leftPosition = imageRect.left - playerWidth - margin;
        }

        // Check left boundary (if moved to the left)
        if (leftPosition < margin) {
             // If still too far left, center below image as fallback
             leftPosition = imageRect.left + (imageRect.width / 2) - (playerWidth / 2);
             topPosition = imageRect.bottom + margin + window.scrollY;
        }

         // Check top/bottom boundaries
         if (topPosition < window.scrollY + margin) {
             topPosition = window.scrollY + margin; // Align to top margin
         } else if (topPosition + playerHeight > window.scrollY + viewportHeight - margin) {
             topPosition = window.scrollY + viewportHeight - playerHeight - margin; // Align to bottom margin
         }

        playerElement.style.top = `${topPosition}px`;
        playerElement.style.left = `${leftPosition}px`;
    }

    // --- Light Toggle Logic ---
    if (lightOverlay && lightHotspotAreas.length > 0 && lightSound) {
      lightHotspotAreas.forEach(area => {
        // Check if this area is specifically for the light (not a music player)
        if (!area.hasAttribute('data-player-id')) {
            area.addEventListener('click', function(event) {
              event.preventDefault();
              lightOverlay.classList.toggle('is-visible');
              lightSound.play().catch(e => console.error("Light sound play failed:", e));
              // Play sound only when turning ON
              if (lightOverlay.classList.contains('is-visible')) {
                  lightSound.currentTime = 0;
                  lightSound.play().catch(e => console.error("Light sound play failed:", e));
              }
            });
        }
      });
    } else {
      if (!lightOverlay) console.error("Could not find 'lightOverlay'!");
      if (lightHotspotAreas.length === 0) console.error("Could not find '.light-hotspot-area' elements!");
      if (!lightSound) console.error("Could not find 'lightSound'!");
    }

    // --- Music Player Toggle Logic (Refactored) ---
    musicHotspotAreas.forEach(hotspot => {
        const targetPlayerId = hotspot.dataset.playerId;
        const targetAudioId = hotspot.dataset.audioId; // Get audio ID from data attribute
        const targetPlayer = document.getElementById(targetPlayerId);
        const targetAudio = document.getElementById(targetAudioId); // Get specific audio element

        if (targetPlayer && targetAudio && bubbleSound && lightSwitchImage) {
            hotspot.addEventListener('click', function(event) {
                event.preventDefault();
                bubbleSound.currentTime = 0;
                bubbleSound.play().catch(e => console.error("Bubble sound play failed:", e));

                const isCurrentlyVisible = targetPlayer.classList.contains('is-visible');

                // Hide all other players first
                musicPlayerElements.forEach(player => {
                    if (player.id !== targetPlayerId) {
                        player.classList.remove('is-visible');
                        // Optional: Pause other music
                        const otherAudio = audioElements[player.id];
                        if (otherAudio && !otherAudio.paused) {
                             otherAudio.pause();
                             musicPlayingState[player.id] = false;
                        }
                    }
                });

                // Toggle the target player
                if (!isCurrentlyVisible) {
                    updateMusicPlayerPosition(targetPlayer, lightSwitchImage); // Calculate position *before* making visible
                    targetPlayer.classList.add('is-visible');
                    // Play music only if it wasn't already playing for this player
                    if (!musicPlayingState[targetPlayerId]) {
                        targetAudio.play().catch(e => console.error(`Music play failed for ${targetAudioId}:`, e));
                        musicPlayingState[targetPlayerId] = true;
                    }
                } else {
                    // If clicking the hotspot of an already visible player, hide it
                    targetPlayer.classList.remove('is-visible');
                    // Optional: Pause music when hiding explicitly via its hotspot
                    if (!targetAudio.paused) {
                        targetAudio.pause();
                        musicPlayingState[targetPlayerId] = false;
                    }
                }
            });
        } else {
            // Log specific errors for this hotspot/player setup
            if (!targetPlayer) console.error(`Could not find player element with ID: ${targetPlayerId}`);
            if (!targetAudio) console.error(`Could not find audio element with ID: ${targetAudioId}`);
            if (!hotspot.dataset.playerId) console.error("Hotspot missing data-player-id:", hotspot);
            if (!hotspot.dataset.audioId) console.error("Hotspot missing data-audio-id:", hotspot);
        }
    });

    // --- *** ADDED: Leaf Sound Logic *** ---
    if (leafSound && leafHotspotAreas.length > 0) {
        leafHotspotAreas.forEach(area => {
            // Check if it's specifically a leaf area (not the main light switch area if it also has the class)
            if (!area.hasAttribute('data-player-id') && area.title.toLowerCase().includes('rustle')) { // Added extra check on title just in case
                area.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent default link behavior

                    // Randomize playbackRate for pitch variation
                    // Value 1.0 is normal speed, > 1 faster (higher pitch), < 1 slower (lower pitch)
                    // Random between 0.8 and 1.2 (adjust range as needed)
                    const randomPlaybackRate = 0.8 + Math.random() * 0.4;
                    leafSound.playbackRate = randomPlaybackRate;

                    leafSound.currentTime = 0; // Restart sound from the beginning
                    leafSound.play().catch(e => console.error("Leaf sound play failed:", e));
                });
            }
        });
    } else {
        if (!leafSound) console.error("Could not find 'leafSound' audio element!");
        if (leafHotspotAreas.length === 0) console.error("Could not find '.leaf-hotspot-area' elements!");
    }
    // --- *** End of added leaf sound logic *** ---

    // --- *** ADDED: New Sound Hotspot Logic *** ---
    soundHotspotAreas.forEach(area => {
        const soundId = area.dataset.soundId;
        const soundElement = document.getElementById(soundId);

        if (soundElement) {
            area.addEventListener('click', function(event) {
                event.preventDefault(); // ป้องกันการเปลี่ยนหน้า

                // Optional: Randomize playback rate like leaf sound
                // const randomPlaybackRate = 0.9 + Math.random() * 0.2; // Adjust range if needed
                // soundElement.playbackRate = randomPlaybackRate;

                soundElement.currentTime = 0; // เริ่มเล่นเสียงใหม่ทุกครั้ง
                soundElement.play().catch(e => console.error(`Sound play failed for ${soundId}:`, e));
            });
        } else {
            console.error(`Could not find sound element with ID: ${soundId} for hotspot:`, area);
            if (!soundId) console.error("Hotspot missing data-sound-id:", area);
        }
    });
    // --- *** End of added new sound logic *** ---

    // --- Update position on window resize ---

    window.addEventListener('resize', () => {
        musicPlayerElements.forEach(player => {
            if (player.classList.contains('is-visible')) {
                updateMusicPlayerPosition(player, lightSwitchImage);
            }
        });
    });

    // --- Initial position calculation consideration ---
    // Recalculate position if the main image loads after the script runs
    lightSwitchImage.addEventListener('load', () => {
         musicPlayerElements.forEach(player => {
            if (player.classList.contains('is-visible')) {
                updateMusicPlayerPosition(player, lightSwitchImage);
            }
        });
    });
    // Also handle cases where the image might already be cached/loaded
    if (lightSwitchImage.complete && lightSwitchImage.naturalHeight !== 0) {
         musicPlayerElements.forEach(player => {
            if (player.classList.contains('is-visible')) {
                updateMusicPlayerPosition(player, lightSwitchImage);
            }
        });
    }
  
// // --- Function to Visualize Image Map Areas (for Debugging) ---
// function visualizeMapAreas(mapName, imageElement) {
//     const map = document.querySelector(`map[name="${mapName}"]`);
//     // *** UPDATED: Select both circle and poly shapes ***
//     const areas = map ? map.querySelectorAll('area[shape="circle"], area[shape="poly"]') : [];
//     const imageRect = imageElement.getBoundingClientRect();

//     // --- Cleanup previous overlays ---
//     // Remove old div overlays (if any were created by previous versions)
//     document.querySelectorAll('.debug-area-overlay').forEach(el => el.remove());
//     // Remove the main SVG overlay if it exists
//     const existingSvgOverlay = document.getElementById('debug-svg-overlay');
//     if (existingSvgOverlay) {
//         existingSvgOverlay.remove();
//     }

//     // --- Create a single SVG overlay ---
//     const svgNS = "http://www.w3.org/2000/svg"; // SVG Namespace
//     const svgOverlay = document.createElementNS(svgNS, "svg");
//     svgOverlay.setAttribute('id', 'debug-svg-overlay'); // ID for easy removal
//     svgOverlay.style.position = 'absolute';
//     svgOverlay.style.left = `${imageRect.left + window.scrollX}px`;
//     svgOverlay.style.top = `${imageRect.top + window.scrollY}px`;
//     svgOverlay.style.width = `${imageRect.width}px`; // Match image dimensions
//     svgOverlay.style.height = `${imageRect.height}px`;
//     svgOverlay.style.pointerEvents = 'none'; // Allow clicks to pass through
//     svgOverlay.style.zIndex = 999; // Keep on top

//     // --- Process each area ---
//     areas.forEach(area => {
//         const coords = area.coords.split(',').map(Number); // Convert coords to numbers
//         const shape = area.getAttribute('shape').toLowerCase(); // Get shape type

//         if (shape === 'circle' && coords.length === 3) {
//             const [cx, cy, r] = coords;

//             const circle = document.createElementNS(svgNS, "circle");
//             circle.setAttribute('cx', cx);
//             circle.setAttribute('cy', cy);
//             circle.setAttribute('r', r);
//             circle.setAttribute('fill', 'rgba(255, 0, 0, 0.2)'); // Semi-transparent red fill
//             circle.setAttribute('stroke', 'red');             // Red border
//             circle.setAttribute('stroke-width', '2');         // Border width

//             svgOverlay.appendChild(circle); // Add circle to the SVG

//         } else if (shape === 'poly' && coords.length >= 6 && coords.length % 2 === 0) {
//             // Must have at least 3 points (6 coordinates) and an even number of coordinates
//             let pointsString = '';
//             for (let i = 0; i < coords.length; i += 2) {
//                 pointsString += `${coords[i]},${coords[i+1]} `; // Format as "x1,y1 x2,y2 ..."
//             }

//             const polygon = document.createElementNS(svgNS, "polygon");
//             polygon.setAttribute('points', pointsString.trim());
//             polygon.setAttribute('fill', 'rgba(0, 0, 255, 0.2)'); // Semi-transparent blue fill for polys
//             polygon.setAttribute('stroke', 'blue');            // Blue border for polys
//             polygon.setAttribute('stroke-width', '2');        // Border width

//             svgOverlay.appendChild(polygon); // Add polygon to the SVG
//         }
//         // else: Handle 'rect' or invalid coords if needed in the future
//     });

//     // --- Append the SVG overlay to the body ---
//     if (svgOverlay.children.length > 0) { // Only append if shapes were added
//        document.body.appendChild(svgOverlay);
//     }
// }

// // --- เรียกใช้ฟังก์ชันเมื่อรูปภาพโหลดเสร็จ หรือเมื่อต้องการ ---
// lightSwitchImage.addEventListener('load', () => {
//     visualizeMapAreas('sceneHotspots', lightSwitchImage);
// });

// // เรียกใช้เผื่อรูปโหลดเสร็จแล้ว (จาก cache)
// if (lightSwitchImage.complete && lightSwitchImage.naturalHeight !== 0) {
//     visualizeMapAreas('sceneHotspots', lightSwitchImage);
// }

// // เรียกใช้ซ้ำเมื่อมีการ resize หน้าจอ
// let resizeTimer;
// window.addEventListener('resize', () => {
//     clearTimeout(resizeTimer);
//     resizeTimer = setTimeout(() => {
//         visualizeMapAreas('sceneHotspots', lightSwitchImage);
//     }, 250); // หน่วงเวลาเล็กน้อยเพื่อประสิทธิภาพ
// });

// //   // --- สิ้นสุดส่วน Visualize ---

  </script>

</body>
</html>