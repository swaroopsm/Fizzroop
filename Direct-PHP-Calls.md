### Attendee Registration.
    PATH /attendee/new
    POST inputFirstName, inputLastName, inputPassword, inputGender, inputDOB, inputAcademic, 
         inputInstAffiliation, inputAddress, inputPhone, inputNationality, inputPassport
   RESPONSE:
         success: TODO(Discuss with @gonecase)

#### Admin Authentication.
     PATH /admin/login
     POST inputLoginEmail, inputLoginPwd
     RESPONSE:
       success: Redirected to /admin
       error:   Redirected to /signin

#### Attendee Authentication.
     PATH /attendee/login
     POST inputLoginEmail, inputLoginPwd
     RESPONSE:
       success: Redirected to /attendee
       error:   Redirected to /login
