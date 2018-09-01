// This file can be replaced during build by using the `fileReplacements` array.
// `ng build ---prod` replaces `environment.ts` with `environment.prod.ts`.
// The list of file replacements can be found in `angular.json`.

export const environment = {
  production: false
};

// export const apiEndPoint = 'http://swarranty.magenta-dev.com';
export const apiEndPoint = 'http://dev-swarranty.magentapulse.com';
export const apiEndPointBase = '/api';
export const organisationPath = '/organisations';
export const baseUrl = '/warranty/registration';
export const MEDIA_PREFIX = '/media';
// export const apiEndPointMedia   = 'http://swarranty.magenta-dev.com';
export const apiEndPointMedia   = 'http://dev-swarranty.magentapulse.com/media-api';
export const apiMediaUploadPath = '/providers/sonata.media.provider.image/media.json';
export const binariesMedia = '/binaries/reference/view.json';
//export const apiUploadWarranty = 'http://dev-swarranty.magentapulse.com/media-api/providers/sonata.media.provider.image/media.json';



/**
 * http://127.0.0.1:8000/index.php/api/qr-code/http:%2F%2Fwww.google.com.png
 */

/*
 * In development mode, to ignore zone related error stack frames such as
 * `zone.run`, `zoneDelegate.invokeTask` for easier debugging, you can
 * import the following file, but please comment it out in production mode
 * because it will have performance impact when throw error
 */
// import 'zone.js/dist/zone-error';  // Included with Angular CLI.
