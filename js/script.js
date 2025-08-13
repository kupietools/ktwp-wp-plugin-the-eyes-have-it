(function() {
    'use strict';

 
 // --- Blinking Logic ---
        let blinkTimeoutId; // Variable to hold the timeout ID

    document.addEventListener('DOMContentLoaded', function() {
            // Get references to the DOM elements
        const openLink = document.getElementById('open-eyes-link');
     //NO LONGER USED   const eyesContainer = document.getElementById('ktwp-wp-eyes-eyes-container');
        const closeBtn = document.getElementById('ktwp-wp-eyes-close-btn');
        const pupils = document.querySelectorAll('.ktwp-wp-eyes-pupil');
        const eyes = document.querySelectorAll('.ktwp-wp-eyes-eye');
       
function oncePanelOpen(panel) {
	
	  document.addEventListener('mousemove', ktwp_wp_eyes_moveThem);
             scheduleNextBlink();
}
       
        /* make sure panel starts hidden... plugins such as KTWP Draggable Elements may make it visible at page load even if the css file in this plugin sets it to be hidden. You can remove this if you're not using the panel in this plugin*/
        //const panel = document.querySelector('.ktwp_eyesHaveIt-panel');
        //if (panel) {panel.style.display="none !important";}
        /* end make sure panel starts hidden */
    
       /* Show/hide panel by clicking tab icon, if desired. Remove this section if you don't want that. */
        const icon = document.querySelector('.ktwp_eyesHaveIt-icon');
        if (icon) {
            icon.addEventListener('click', function(e) {
                e.preventDefault();
                const panel = document.querySelector('.ktwp_eyesHaveIt-panel');
                if (panel) {
                    panel.style.display = getComputedStyle(panel).display === 'none' ? 'block' : 'none';
                }
				const button = document.getElementById("ktwp_eyesHaveIt-control")
				if (!panel.classList.contains("ktwp-de-beenDragged")) {
					panel.style.top = parseInt(getComputedStyle(button).top)+20+"px";
					 panel.style.left = "20px";}
               oncePanelOpen(panel);
            });
    
        }
        /* end Show/hide panel by clicking tab icon */

        /* hide panel by clicking panel close icon, if desired. Remove this section if you don't want that. */
        const closeButton = document.querySelector('.ktwp_eyesHaveIt-close-button');
        if (closeButton) {
            closeButton.addEventListener('click', function(e) {
                e.stopPropagation();
                ktwp_closePanelScript(e);
            });
			
        }
        /* End panel by clicking panel close icon. */

        /* Hide panel by clicking outside it, if desired. Remove this section if you don't want that. */
      /* DISABLING FOR EYES PLUGIN, let's let them keep it open as they click around.   document.addEventListener('click', function(e) {
            const control = document.querySelector('.ktwp_eyesHaveIt-control');
            const panel = document.querySelector('.ktwp_eyesHaveIt-panel');

            // Check if the click occurred outside the control area AND the panel is visible
            if ( ((control  && !control.contains(e.target)) || !control) && panel && getComputedStyle(panel).display !== 'none') {
                ktwp_closePanelScript(e);
            }
        }); */
        /* End hide panel by clicking outside it, if desired. */

        /* Functionality for tab panel reset button, if desired. Remove this if you don't need that. */
        const resetButton = document.getElementById('ktwp_eyesHaveIt-reset-button');
        if (resetButton) {
            resetButton.addEventListener('click', function(e) {
                /* whatever the reset button should do goes here */
                // Example: console.log('Reset button clicked!');
            });
        }
        /* End functionality for tab panel reset button */

        function ktwp_closePanelScript(e) {
            /* put any steps here that need to run when the panel closes */
            const panel = document.querySelector('.ktwp_eyesHaveIt-panel');
            if (panel) {
                panel.style.display = 'none';
            }
        }
        
        // This function performs the blink animation
        function blink() {
            // Close the eyes by scaling them vertically
            eyes.forEach(eye => {
                eye.style.transform = 'scaleY(0.1)';
            });
 /* setTimeout(() => {
                eyes.forEach(eye => {
                    eye.style.transform = 'scaleY(.25)';
                });
                // After the blink is complete, schedule the next one
                scheduleNextBlink();
            }, 35); 
            
            setTimeout(() => {
                eyes.forEach(eye => {
                    eye.style.transform = 'scaleY(.1)';
                });
                // After the blink is complete, schedule the next one
                scheduleNextBlink();
            }, 50); */
            // After a short delay, open them again
            setTimeout(() => {
                eyes.forEach(eye => {
                    eye.style.transform = 'scaleY(1)';
                });
                // After the blink is complete, schedule the next one
                scheduleNextBlink();
            }, 65); // Duration of the blink (how long the eye stays closed)
        }

        // This function schedules the next blink at a random interval
        function scheduleNextBlink() {
            // Clear any existing timeout to prevent conflicts
            clearTimeout(blinkTimeoutId);
            // Set a random time for the next blink (e.g., between 2 and 10 seconds)
            const randomInterval = Math.random() * 5000 + 8000;
            blinkTimeoutId = setTimeout(blink, randomInterval);
        }
        
                function ktwp_wp_eyes_moveThem(e)  {
           /* Don't need this, relic of technique on original web page
            *  // If the container is ktwp-wp-eyes-hidden, do nothing.
            if (eyesContainer.classList.contains('ktwp-wp-eyes-hidden')) {
                return;
            } */

            // Get mouse coordinates
            const mouseX = e.clientX;
            const mouseY = e.clientY;

            // Iterate over each pupil to move it individually
            pupils.forEach(pupil => {
                // Get the position and size of the parent eye
                const eye = pupil.parentElement;
                const eyeRect = eye.getBoundingClientRect();

                // Calculate the center of the eye
                const eyeCenterX = eyeRect.left + eyeRect.width / 2;
                const eyeCenterY = eyeRect.top + eyeRect.height / 2;

                // Calculate the angle between the eye's center and the mouse position
                const deltaX = mouseX - eyeCenterX;
                const deltaY = mouseY - eyeCenterY;
                const angle = Math.atan2(deltaY, deltaX);

                // Define the maximum distance the pupil can move from the center.
                // This keeps the pupil within the eye's boundaries.
                const maxMoveX = (eye.clientWidth / 2) - (pupil.clientWidth / 2) - 2; // -2 for a small buffer
                const maxMoveY = (eye.clientHeight / 2) - (pupil.clientHeight / 2) - 2;

                // Calculate the new position for the pupil using trigonometry.
                // The pupil will move along the edge of an ellipse defined by maxMoveX and maxMoveY.
                const pupilX = Math.cos(angle) * maxMoveX;
                const pupilY = Math.sin(angle) * maxMoveY;

                // Apply the new position using CSS transform for smooth animation
                pupil.style.transform = `translate(${pupilX}px, ${pupilY}px)`;
            });
        }
    });
})();