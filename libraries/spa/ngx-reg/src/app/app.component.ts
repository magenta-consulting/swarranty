import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'app';
  data = ['item 1', 'item 2', 'item 3'];

  addData():void{
    this.data.push('new data');
  }

}
