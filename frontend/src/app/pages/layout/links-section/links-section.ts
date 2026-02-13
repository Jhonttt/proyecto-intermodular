import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common'; 


@Component({
  selector: 'app-links-section',
  imports: [CommonModule],
  templateUrl: './links-section.html',
  styleUrl: './links-section.css',
})

//@Input() necesario para recibir datos del padre
export class LinksSection {
  @Input() titulo = 'Enlaces';
  @Input() links: { label: string; url: string }[] = [];
}
