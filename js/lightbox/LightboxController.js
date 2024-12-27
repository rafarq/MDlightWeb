export class LightboxController {
  constructor(lightboxElement) {
    this.lightbox = lightboxElement;
    this.bindEvents();
  }

  bindEvents() {
    // Handle image clicks
    document.addEventListener('click', this.handleImageClick.bind(this));

    // Handle close button
    this.lightbox.closeButton.addEventListener('click', this.handleClose.bind(this), true);

    // Handle click outside
    this.lightbox.element.addEventListener('click', this.handleOutsideClick.bind(this));

    // Handle escape key
    document.addEventListener('keydown', this.handleKeyPress.bind(this));
  }

  handleImageClick(event) {
    const target = event.target;
    if (target.tagName === 'IMG' && target.closest('.markdown-content')) {
      event.preventDefault();
      this.lightbox.show(target.src);
    }
  }

  handleClose(event) {
    event.preventDefault();
    event.stopPropagation();
    this.lightbox.hide();
  }

  handleOutsideClick(event) {
    if (event.target === this.lightbox.element) {
      this.handleClose(event);
    }
  }

  handleKeyPress(event) {
    if (event.key === 'Escape' && this.lightbox.element.classList.contains('active')) {
      this.handleClose(event);
    }
  }
}