import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Survey, Option } from '../../model/survey';
import { RegistrationService } from '../../service/registration.service';
import { Registration } from '../../model/registration';

@Component({
  selector: 'app-survey',
  templateUrl: './survey.component.html',
  styleUrls: ['./survey.component.scss']
})
export class SurveyComponent implements OnInit {
  survey: Survey = new Survey();
  registration: Registration
  message: string;
  validating: boolean = false;
  submiting: boolean = false;

  constructor(
    private router: Router,
    private registrationService: RegistrationService
  ) { }

  ngOnInit() {
    this.registrationService.currentRegistration.subscribe(reg => {
      if (!reg) {
        this.router.navigate(['/registration']);
      }
    })
    this.buildOptions();
  }

  submit() {
    this.validating = true;
    var res = this.survey.getResult();
    if (!res) {
      this.message = "Please fill out required field";
    } else {
      // fetch some api
      this.submiting = true;
      this.registrationService.currentRegistration.subscribe(reg => {
        this.registration = reg;
        this.attachSurvey(res, reg);
        this.registrationService.postRegistration(reg).subscribe(reg => {
            localStorage.setItem('regId', reg['@id']);
            let regId = reg['@id'];
            let cutstr = '/api/registrations/';
            console.log('regId', regId, cutstr.length);
            let regRId = regId.substring(cutstr.length);
            this.router.navigate([`/upload-receipt-image/${regRId}`]);
        });
      });
    }
  }

  attachSurvey(survey, reg: Registration) {
    reg['ageGroup'] = survey.ageGroup;
    reg['hearOthers'] = survey.hearFrom.other;
    reg['reasonOthers'] = survey.reason.other;
    survey.hearFrom.options.forEach(option => {
        reg[option] = true;
    });
    survey.hearFrom.blanks.forEach(option => {
        reg[option] = false;
    });
    survey.reason.options.forEach(option => {
        reg[option] = true;
    });
    survey.reason.blanks.forEach(option => {
        reg[option] = false;
    });
    return reg;
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
