import { Component, EventEmitter, Output } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Input } from '@angular/core';

@Component({
  selector: 'app-section',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './section.html',
  styleUrl: './section.css',

})

export class Section {

  searchTerm: string = '';
  selectedTag: string = '';

  @Input() tagsUnicos: string[] = [];
  @Output() searchChange = new EventEmitter<string>();
  @Output() tagChange = new EventEmitter<string>();

  onSearchChange() {
    this.searchChange.emit(this.searchTerm);
  }

  onTagChange() {
    this.tagChange.emit(this.selectedTag);
  }
}

