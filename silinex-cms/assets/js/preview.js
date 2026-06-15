// preview.js – Handles device preview toggles in the CMS preview page

(() => {
  // Helper to set active button styles and aria attributes
  const setActive = (btn) => {
    document.querySelectorAll('.preview-toolbar button').forEach((b) => {
      b.classList.toggle('active', b === btn);
      b.setAttribute('aria-pressed', b === btn ? 'true' : 'false');
    });
  };

  // Adjust iframe size based on selected device
  const setIframeSize = (width) => {
    const iframe = document.getElementById('pf');
    if (!iframe) return;
    iframe.style.width = width;
  };

  // Tablet view – medium width (e.g., 768px)
  const tabletBtn = document.getElementById('preview-tablet');
  if (tabletBtn) {
    tabletBtn.addEventListener('click', () => {
      setActive(tabletBtn);
      // Use a responsive width with a max to emulate tablet
      setIframeSize('768px');
    });
  }

  // Desktop view – full width (100% of container)
  const desktopBtn = document.getElementById('preview-desktop');
  if (desktopBtn) {
    desktopBtn.addEventListener('click', () => {
      setActive(desktopBtn);
      setIframeSize('100%');
    });
  }

  // Initialize to desktop on page load for consistency
  if (desktopBtn) {
    desktopBtn.click();
  }
})();
