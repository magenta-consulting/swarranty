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
  validating: boolean = false;

  constructor(
    private router: Router
  ) { }

  ngOnInit() {
    this.buildOptions();
  }

  submit() {
    this.validating = true;
    var res = this.survey.getResult();
    if (!res) {
      this.message = "Please fill out required field";
    } else {
      // fetch some api
      localStorage.setItem('survey', JSON.stringify(this.survey.getResult()));
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
        value: 'hearFromOnlineSearch',
        selected: false
      },
      {
        name: 'Online advertisement (Facebook/Instagram/etc.)',
        value: 'hearFromOnlineAd',
        selected: false
      },
      {
        name: 'Introduced by friend/family',
        value: 'hearFromFriendFamily',
        selected: false
      },
      {
        name: 'Introduced by interior designer',
        value: 'reasonInteriorDesigner',
        selected: false
      },
      {
        name: 'Walk in to the shop',
        value: 'hearWalkShop',
        selected: false
      }
    ]

    this.survey.reason = [
      {
        name: 'Because there were promotions going on',
        value: 'reasonPromotions',
        selected: false
      },
      {
        name: 'Because I liked the brand',
        value: 'reasonTheBrand',
        selected: false
      },
      {
        name: 'Because I liked the technology (Suction/Easy cleaning/etc.)',
        value: 'reasonTechnology',
        selected: false
      },
      {
        name: 'Because I liked the Japanese quality',
        value: 'reasonJapanese',
        selected: false
      },
      {
        name: 'Because I liked the design',
        value: 'reasonTheDesign',
        selected: false
      },
      {
        name: 'Because price was affordable',
        value: 'reasonAffordable',
        selected: false
      },
      {
        name: 'Because my interior designer suggested to me',
        value: 'reasonDesignerSuggested',
        selected: false
      },
      {
        name: 'Because my friend/family suggested to me',
        value: 'reasonFriendFamilySuggested',
        selected: false
      }
    ]
  }
}
