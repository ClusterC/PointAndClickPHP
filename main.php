<!DOCTYPE html>
<html>
<head>
<title>PointAndClickPHP - Interactive Scene</title>
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

      // Player 1
      $musicSrc1 = 'Shut up My Moms Calling.mp3';
      $playerImageSrc1 = 'Shut up My Moms Calling.jpg';
      $playerTitle1 = 'SHUT UP MY MOMS CALLING';
      $playerArtist1 = 'HOTEL UGLY';

      // Player 2
      $musicSrc2 = 'Another Song.mp3';
      $playerImageSrc2 = 'Another Album Art.jpg';
      $playerTitle2 = 'ANOTHER SONG TITLE';
      $playerArtist2 = 'ANOTHER ARTIST';

      // Player 3
      $musicSrc3 = 'Third Song.mp3'; // <-- Example: Use a different song
      $playerImageSrc3 = 'Third Album Art.jpg'; // <-- Example: Use a different image
      $playerTitle3 = 'THIRD SONG TITLE';
      $playerArtist3 = 'THIRD ARTIST';
    ?>

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

  /* .debug-area-overlay {
    position: absolute;
    border: 2px dashed red;
    border-radius: 50%;  
    pointer-events: none; 
    box-sizing: border-box; 
    z-index: 999;
    background-color: rgba(255, 0, 0, 0.1); สีแดงโปร่งๆ
  } */


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

    <!-- Add more <area> tags here if needed -->
  </map>

  <!-- Audio Elements -->
  <audio id="lightSound" src="<?php echo htmlspecialchars($lightSoundSrc); ?>" preload="auto"></audio>
  <audio id="bubbleSound" src="<?php echo htmlspecialchars($bubbleSoundSrc); ?>" preload="auto"></audio>
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

    // Get all music players and hotspots using the common class
    const musicPlayerElements = document.querySelectorAll('.music-player');
    const musicHotspotAreas = document.querySelectorAll('.music-hotspot-area[data-player-id]'); // Select only music hotspots

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
    Object.values(audioElements).forEach(audio => {
        if (audio) audio.volume = 0.5; // Set volume for all music tracks
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
  
//   // --- Function to Visualize Image Map Areas (for Debugging) ---
// function visualizeMapAreas(mapName, imageElement) {
//     const map = document.querySelector(`map[name="${mapName}"]`);
//     const areas = map ? map.querySelectorAll('area[shape="circle"]') : []; // ตอนนี้รองรับแค่วงกลม
//     const imageRect = imageElement.getBoundingClientRect();
//     const container = imageElement.parentNode; // หา parent ที่จะใส่กรอบ

//     // ลบกรอบเก่า (ถ้ามี)
//     document.querySelectorAll('.debug-area-overlay').forEach(el => el.remove());

//     areas.forEach(area => {
//         const coords = area.coords.split(',').map(Number); // แปลง coords เป็นตัวเลข
//         if (coords.length === 3) { // ต้องมี 3 ค่า: x, y, radius
//             const [x, y, radius] = coords;

//             const overlay = document.createElement('div');
//             overlay.className = 'debug-area-overlay';

//             // คำนวณตำแหน่งและขนาดเทียบกับรูปภาพ
//             // ตำแหน่ง left/top คือมุมบนซ้ายของกรอบสี่เหลี่ยมที่ครอบวงกลม
//             overlay.style.left = `${imageRect.left + window.scrollX + x - radius}px`;
//             overlay.style.top = `${imageRect.top + window.scrollY + y - radius}px`;
//             overlay.style.width = `${radius * 2}px`;
//             overlay.style.height = `${radius * 2}px`;

//             document.body.appendChild(overlay); // เพิ่มกรอบเข้าไปใน body
//         }
//     });
// }

//   // --- เรียกใช้ฟังก์ชันเมื่อรูปภาพโหลดเสร็จ หรือเมื่อต้องการ ---
//   lightSwitchImage.addEventListener('load', () => {
//       visualizeMapAreas('sceneHotspots', lightSwitchImage);
//       // อาจจะต้องเรียกอีกครั้งหลัง resize ถ้าตำแหน่งรูปเปลี่ยน
//   });

//   // เรียกใช้เผื่อรูปโหลดเสร็จแล้ว (จาก cache)
//   if (lightSwitchImage.complete && lightSwitchImage.naturalHeight !== 0) {
//       visualizeMapAreas('sceneHotspots', lightSwitchImage);
//   }

//   // เรียกใช้ซ้ำเมื่อมีการ resize หน้าจอ
//   let resizeTimer;
//   window.addEventListener('resize', () => {
//       clearTimeout(resizeTimer);
//       resizeTimer = setTimeout(() => {
//           visualizeMapAreas('sceneHotspots', lightSwitchImage);
//       }, 250); // หน่วงเวลาเล็กน้อยเพื่อประสิทธิภาพ
//   });

//   // --- สิ้นสุดส่วน Visualize ---

  </script>

</body>
</html>