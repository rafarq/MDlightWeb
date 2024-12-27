export class LightboxElement {
  static instance = null;

  constructor() {
    // Singleton pattern
    if (LightboxElement.instance) {
      return LightboxElement.instance;
    }
    LightboxElement.instance = this;

    this.element = this.createElement();
    this.contentWrapper = this.element.querySelector('.lightbox-content');
    this.closeButton = this.element.querySelector('.lightbox-close');
    this.image = this.element.querySelector('img');
  }

  createElement() {
    const lightbox = document.createElement('div');
    lightbox.className = 'lightbox';
    lightbox.innerHTML = `
      <div class="lightbox-content">
        <img alt="Lightbox image">
      </div>
      <div class="lightbox-close" role="button" aria-label="Close lightbox">×</div>
    `;
    return lightbox;
  }

  show(imageSrc) {
    this.image.src = imageSrc;
    requestAnimationFrame(() => {
      this.element.classList.add('active');
      document.body.style.overflow = 'hidden';
    });
  }

  hide() {
    this.element.classList.remove('active');
    document.body.style.overflow = '';
  }

  mount() {
    // Remove any existing lightbox before mounting
    const existing = document.querySelector('.lightbox');
    if (existing) {
      existing.remove();
    }
    document.body.appendChild(this.element);
  }
}