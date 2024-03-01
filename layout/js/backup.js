


// this.http.post(this.url, formData).subscribe(
//   (response) => {
//     // choose the response message
//     if ('result' in response && response['result'] == 'success') {
//       this.responseMessage = 'success msg';
//       this.responseMessageClass = 'success';
//       // reset form
//       setTimeout(() => {
//         this.resetForm(contactFormDirective);
//       }, 2000);
//     } else {
//       this.responseMessage = 'fail msg';
//       this.responseMessageClass = 'danger';
//     }
//     this.contactForm.enable(); // re enable the form after a success
//     this.submitted = true; // show the response message
//     this.isLoading = false; // re enable the submit button
//     console.log(response);
//   },
//   (error) => {
//     this.responseMessage = 'fail msg';
//     this.responseMessageClass = 'danger';
//     this.contactForm.enable(); // re enable the form after a success
//     this.submitted = true; // show the response message
//     this.isLoading = false; // re enable the submit button
//     console.log(error);
//   }
// );