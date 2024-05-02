import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class DataService {

  private jsonData = {
    "CATEGORIES": [
        {
            "ID": "1",
            "name": "Communication"
        },
        {
            "ID": "2",
            "name": "Culture"
        },
        {
            "ID": "3",
            "name": "Développement personnel"
        }
      // ... autres catégories
    ]
    // ... autres tables
  };

  constructor() { }

  getCategories(): Observable<any[]> {
    return of(this.jsonData.CATEGORIES);
  }

  // ... autres méthodes pour accéder aux différentes tables
}
