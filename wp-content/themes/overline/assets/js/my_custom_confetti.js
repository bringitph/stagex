  /* confetti cannon effect made with: https://www.kirilv.com/canvas-confetti/ */

  const sound = document.getElementById("sound");
  const triggers = document.querySelectorAll(".seller-quote-accept-status");
  const defaults = {
    disableForReducedMotion: true
  };
  
  function fire(particleRatio, opts) {
    confetti(
      Object.assign({}, defaults, opts, {
        particleCount: Math.floor(200 * particleRatio)
      })
    );
  }
  
  function confettiExplosion(origin) {
    fire(0.25, {
      spread: 26,
      startVelocity: 55,
      origin
    });
    fire(0.2, {
      spread: 60,
      origin
    });
    fire(0.35, {
      spread: 100,
      decay: 0.91,
      origin
    });
    fire(0.1, {
      spread: 120,
      startVelocity: 25,
      decay: 0.92,
      origin
    });
    fire(0.1, {
      spread: 120,
      startVelocity: 45,
      origin
    });
  }
  
  Array.from(triggers).forEach((trigger) => {
    trigger.addEventListener("click", () => {
        if (trigger.checked == true){
            const rect = trigger.getBoundingClientRect();
            const center = {
                x: rect.left + rect.width / 2,
                y: rect.top + rect.height / 2
            };
            const origin = {
                x: center.x / window.innerWidth,
                y: center.y / window.innerHeight
            };
        
            
            confettiExplosion(origin);
        }
    });
  });
  