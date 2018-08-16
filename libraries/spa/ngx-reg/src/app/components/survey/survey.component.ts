import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Survey, Option } from '../../model/survey';

@Component({
  selector: 'app-survey',
  templateUrl: './survey.component.html',
  styleUrls: ['./survey.component.scss']
})
export class SurveyComponent implements OnInit {
  survey: Survey = new Survey();

  constructor(
    private router: Router
  ) { }

  ngOnInit() {
    this.survey.ageGroup = [
      {
        name: '1-10',
        value: 'young',
        selected: false
      },
      {
        name: '11-50',
        value: 'adult',
        selected: false
      },
      {
        name: '51-100',
        value: 'old',
        selected: false
      }
    ]

    this.survey.howKnow = [
      {
        name: 'Friend tell',
        value: 'friend',
        selected: true
      },
      {
        name: 'Internet',
        value: 'internet',
        selected: true
      }
    ]
  }

  submit() {
    console.log('This shit gonna be sent to the server: ', this.survey.getResult());
    // localStorage.setItem('survey', '1');
    // this.router.navigate(['registration']);
  }
}
