import { Component } from '@angular/core';
import { LinksSection } from "../links-section/links-section";

@Component({
  selector: 'app-footer',
  imports: [LinksSection],
  templateUrl: './footer.html',
  styleUrl: './footer.css',
})

export class Footer {
 footerLinks1 = [
    { label: 'Privacidad', url: '#' },
    { label: 'Términos', url: '#' },
    { label: 'Contacto', url: '#' }
  ];
 footerLinks2 = [
    { label: 'Términos de uso', url: '#' },
    { label: 'Privacidad', url: '#' },
    { label: 'Cookies', url: '#' }
  ];
}
