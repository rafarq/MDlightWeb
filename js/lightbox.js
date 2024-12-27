import { LightboxElement } from './lightbox/LightboxElement.js';
import { LightboxController } from './lightbox/LightboxController.js';

export function initializeLightbox() {
  const lightboxElement = new LightboxElement();
  lightboxElement.mount();
  
  new LightboxController(lightboxElement);
}