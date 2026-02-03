import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-details-form',
  imports: [],
  templateUrl: './details-form.html',
  styleUrl: './details-form.css',
})
export class DetailsForm implements OnInit{

  projectID!: number;

  constructor(private route: ActivatedRoute) {}

   ngOnInit(): void {
    // Leer el parámetro :id de la URL
    this.projectID = Number(this.route.snapshot.paramMap.get('id'));
  }

}
