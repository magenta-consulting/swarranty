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
  message: string;

  constructor(
    private router: Router
  ) { }

  ngOnInit() {
    this.buildOptions();
  }

  submit() {
    var res = this.survey.getResult();
    if (!res) {
      this.message = "Please fill out required field";
    } else {
      console.log('This shit gonna be sent to the server: ', res);
      // fetch some api
      // localStorage.setItem('survey', '1');
      this.router.navigate(['registration']);
    }
  }

  buildOptions() {
    this.survey.ageGroup = [
      {
        name: '19 and below',
        value: '19-and-below',
        selected: false
      },
      {
        name: '20-29',
        value: '20-29',
        selected: false
      },
      {
        name: '30-39',
        value: '30-39',
        selected: false
      },
      {
        name: '40-49',
        value: '40-49',
        selected: false
      },
      {
        name: '50-59',
        value: '50-59',
        selected: false
      },
      {
        name: '60 and above',
        value: '60-and-above',
        selected: false
      }
    ]

    this.survey.hearFrom = [
      {
        name: 'Online search',
        value: 'online-search',
        selected: false
      },
      {
        name: 'Online advertisement (Facebook/Instagram/etc.)',
        value: 'online-ad',
        selected: false
      },
      {
        name: 'Introduced by friend/family',
        value: 'friend-family',
        selected: false
      },
      {
        name: 'Introduced by interior designer',
        value: 'interior-designer',
        selected: false
      },
      {
        name: 'Walk in to the shop',
        value: 'shop',
        selected: false
      }
    ]

    this.survey.reason = [
      {
        name: 'Because there were promotions going on',
        value: 'promotion',
        selected: false
      },
      {
        name: 'Because I liked the brand',
        value: 'brand',
        selected: false
      },
      {
        name: 'Because I liked the technology (Suction/Easy cleaning/etc.)',
        value: 'technology',
        selected: false
      },
      {
        name: 'Because I liked the Japanese quality',
        value: 'japanese-quality',
        selected: false
      },
      {
        name: 'Because I liked the design',
        value: 'design',
        selected: false
      },
      {
        name: 'Because price was affordable',
        value: 'affordable-price',
        selected: false
      },
      {
        name: 'Because my interior designer suggested to me',
        value: 'interior-designer',
        selected: false
      },
      {
        name: 'Because my friend/family suggested to me',
        value: 'friend-family',
        selected: false
      }
    ]
  }
}
