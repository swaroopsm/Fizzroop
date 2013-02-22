### Table of Contents
#### Attendees.
1. [New Attendee](#new-attendee)
2. [Edit/Update an Attendee](#editupdate-attendee)
3. [Register Attendee](#register-attendee)
4. [View particular Attendee](#view-particular-attendee)
5. [View all Attendees](#view-all-attendees)
6. [Password Reset for Attendee](#attendee-password-rest)
7. [Remove an Attendee](#attendee-removal)

#### Conferences.
1. [New Conference](#create-new-conference)
2. [Edit/Update Conference](#editupdate-conference)
3. [Publish Conference](#publish-conference)
4. [View particular Conference](#view-particular-conference)
5. [View all Conferences](#view-all-conferences)

#### Abstracts.
1. [New Abstract Submission](#create-new-abstract)
2. [View all Abstracts](#view-all-abstracts)
3. [View particular Abstract](#view-particular-abstract)
4. [Edit/Update Abstract](#update-particular-abstract)
5. [Assign Abstract to Reviewer](#assign-abstract-to-a-reviewer)
6. [Unassign Abstract from a Reviewer](#unassign-a-reviewer)
7. [Remove an Abstract](#remove-an-abstract)
8. [Remove Image of an Abstract](#remove-an-abstractimage-of-a-particular-abstract)
9. [Remove all Images from AbstractImages Folder](#remove-all-images-from-abstracts-image-folder)

#### Reviewers.
1. [New Reviewer](#creates-a-new-reviewer)
2. [Edit/Update Reviewer](#updates-a-reviewer)
3. [View particular Reviewer](#view-a-particular-reviewer)
4. [View all Reviewers](#view-all-reviewers)
5. [Data for THE BIG ABSTRACTS table](#data-for-big-reviewers-table)
6. [View Assigned Abstracts to a Reviewer](#view-assigned-abstract-to-a-reviewer)
7. [Submit Abstract after reviewed by Reviewer](#submit-abstract-after-reviewed-by-a-reviewer)
8. [Password reset for a Reviewer](#reset-password-of-a-reviewer)
9. [Delete a Reviewer](#remove-a-reviewer)

#### Comments.
1. [View particular Comment](#view-a-particular-comment)
2. [View all Comments](#view-all-comments)
3. [Remove particular Comment](#remove-a-comment)

#### Scores.
1. [View all Scores](#view-all-scores)

#### Pages.
1. [Creates Page](#create-a-new-page)
2. [View particular Page](#view-a-particulat-page)
3. [View all Pages](#view-all-pages)
4. [Update particular Page](#update-a-particular-page)
5. [Delete a particular Page](#delete-a-particular-page)

#### Images.
1. [View particular Image](#view-a-particular-image)
2. [View all Images](#view-all-images)
3. [Delete Image](#remove-a-particular-image)
   
### New Attendee
    PATH /attendee/new
    POST inputFirstName, inputLastName, inputPassword, inputGender, inputDOB, inputAcademic, 
         inputInstAffiliation, inputAddress, inputPhone, inputNationality, inputPassport
    RESPONSE{
             "success" : true,
             "attendeeID" : attendeeID
           }

### Edit/Update Attendee.
    PATH /attendee/update
    POST inputFirstName, inputLastName, inputEmail, inputAttendeeID //TODO: add other fields too.
    RESPONSE{
              "success" : true,
              "attendeeID": attendeeID
            }

### Register Attendee.
    PATH /attendee/register
    POST inputAttendeeID
    RESPONSE{
              "success" : true,
              "attendeeID": attendeeID
            }

### View particular Attendee.
    PATH /attendee/<attendeeID>
    GET
    RESPONSE{
              "attendeeID",
              "attendeeFirstName",
              "attendeeLastName",
              "attendeeEmail",
              "registered",
              "attendeeGender",
              "attendeeDOB",
              "attendeeAcademic",
              "attendeeInstAffiliation",
              "attendeeAddress",
              "attendeePhone",
              "attendeeNationality",
              "attendeePassport"
            }

### View all Attendees
    PATH /attendee/view
    GET
    RESPONSE{
              "attendeeID",
              "attendeeFirstName",
              "attendeeLastName",
              "attendeeEmail",
              "registered",
              "attendeeGender",
              "attendeeDOB",
              "attendeeAcademic",
              "attendeeInstAffiliation",
              "attendeeAddress",
              "attendeePhone",
              "attendeeNationality",
              "attendeePassport"
            }

### Attendee Password Rest.
    PATH /attendee/reset
    POST inputAttendeeID, inputConfPassword, inputNewPassword
    RESPONSE{
              "success" : true|false,
              "attendeeID" : attendeeID,
              "responseMsg" : ""
            }

### Attendee Removal.
    PATH /attendee/delete
    POST inputAttendeeID
    RESPONSE{
              "success" : true|false,
              "responseMsg"
            }

### Create New Conference.
    PATH /conference/create
    POST inputYear, inputVenue, inputStartDate, inputEndDate
    RESPONSE{
              "success": true|false,
              "conferenceID": conferenceID
            }

### Edit/Update Conference.
    PATH /conference/update
    POST inputYear, inputVenue, inputStartDate, inputEndDate, inputVisibility, inputConferenceID
    RESPONSE{
              "success" : true,
              "conferenceID": conferenceID
            }

### Publish Conference.
    PATH /conference/publish
    POST inputConferenceID
    RESPONSE{
              "success" : true,
              "conferenceID" : conferenceID
            }

### View particular Conference.
    PATH /conference/<conferenceID>
    GET
    RESPONSE{
              "conferenceID",
              "year",
              "venue",
              "startDate",
              "endDate",
              "visibility"
            }

### View all Conferences.
    PATH /conference/view
    GET
    RESPONSE{
              "conferenceID",
              "year",
              "venue",
              "startDate",
              "endDate",
              "visibility"
            }

### Create new Abstract.
    PATH /abstract/create
    POST inputAbstractTitle, inputAbstractMethods, inputAbstractAim, inputAbstractResults, 
         inputAbstractConservation, inputAbstractImage, inputAbstractPreference
    RESPONSE{
              "success" : true|false,
              "abstractID" : abstractID
            }

### View all Abstracts
    PATH /abstract/view
    GET
    RESPONSE{
              "abstractID",
              "abstractTitle",
              "abstractImageFolder",
              "attendeeFirstName",
              "attendeeLastName",
              "reviewers",
              "score",
              "recommendations"
            }

### View particular Abstract.
    PATH /abstract/<abstractID>
    GET
    RESPONSE{
              "abstractID",
              "abstractTitle",
              "abstractImageFolder",
              "attendeeFirstName",
              "attendeeLastName",
              "reviewers",
              "score",
              "comments",
              "detailed_scores"
            }

### Update particular Abstract.
    PATH /abstract/update
    POST inputAbstractTitle, inputAbstractContent, inputAbstractID
    RESPONSE{
              "success" : true,
              "abstractID" : abstractID
             }

### Assign Abstract to a Reviewer.
    PATH /abstract/assign
    POST abstractID, reviewerID, reviewername
    RESPONSE{
              "success" : true,
              "reviewerFirstName" : reviewerFirstName,
              "reviewerLastName" : reviewerLastName,
              "reviewerID" : reviewerID
            }

### Unassign a Reviewer.
    PATH /abstract/unassign
    POST inputReviewerID, inputAbstractID
    RESPONSE{
              "success" : true|false,
              "error" : error //(if false)
            }

### Remove an Abstract
    PATH /abstract/delete
    POST inputAbstractID
    RESPONSE{
               "success" : true|false,
               "responseMsg" : responseMsg
             }

### Remove an AbstractImage of a particular Abstract.
    PATH /abstract/delete_abstractImage
    POST inputAbstractImage
    RESPONSE{
              "success" : true|false,
              "error" : error //(if false)
            }

### Remove all images from Abstracts image folder.
    PATH /abstract/delete_allAbstractImage
    POST inputAbstractImageFolder
    RESPONSE{
              "success" : true,
              "count" : count
            }

### Creates a new Reviewer.
    PATH /reviewer/create
    POST inputFirstName, inputLastName, inputEmail, inputPassword
    RESPONSE{
              "success" : true,
              "reviewerID" : reviewerID
            }

### Updates a Reviewer.
    PATH /reviewer/update
    POST inputFirstName, inputLastName, inputEmail
    RESPONSE{
              "success" : true,
              "reviewerID" : reviewerID
            }

### View a particular Reviewer.
    PATH /reviewer/<reviewerID>
    GET 
    RESPONSE{  
              "reviewerID" : reviewerID,
              "reviewerFirstName" : reviewerFirstName,
              "reviewerLastName" : reviewerLastName,
              "reviewerEmail" : reviewerEmail,
              "abstracts" : abstracts
            }

### View all Reviewers.
    PATH /reviewer/view
    GET 
    RESPONSE{  
              "reviewerID" : reviewerID,
              "reviewerFirstName" : reviewerFirstName,
              "reviewerLastName" : reviewerLastName,
              "reviewerEmail" : reviewerEmail,
              "workingAbstracts" : workingAbstracts,
              "abstracts" : abstracts
            }

### Data for big Reviewers table.
    PATH /reviewer/reviewer_abstracts
    GET
    RESPONSE{
              "abstractID" : abstractID
              "abstractTitle" : abstractTitle,
              "active" : active,
              "approved" : approved,
              "score" : score,
              "recommendation" : recommendation
            }

### View assigned Abstract to a Reviewer.
    PATH /reviewer/abstract/assigned/<abstractID>
    GET
    RESPONSE{
              "abstractID" : abstractID,
              "abstractTitle" : abstractTitle,
              "abstractContent" : abstractContent,
              "abstractImageFolder" : abstractImageFolder,
              "reviewerFirstName" : reviewerFirstName,
              "reviewerLastName" : reviewerLastName,
              "comments" : comments,
              "scores" : scores
            }

### Submit Abstract after reviewed by a Reviewer
    PATH /reviewer/reviewer_abstract_submit
    POST abstractID, reviewerID, comment_reviewer, comment_admin, comment_reviewer_id, comment_admin_id
         score, recommendation, scoreID

### Reset password of a Reviewer.
    PATH /reviewer/reset
    POST inputReviewerID, inputConfPassword, inputNewPassword
    RESPONSE{
              "success" : true|false,
              "reviewerID" : reviewerID,
              "responseMsg" : responseMsg
            }

### Remove a Reviewer.
    PATH /reviewer/delete
    POST inputReviewerID
    RESPONSE{
              "success" : true|false,
              "responseMsg" : responseMsg
            }

### View a particular Comment.
    PATH /comment/<commentID>
    GET
    RESPONSE{
              "commentID" : commentID,
              "commentContent" : commentContent,
              "abstractID" : abstractID,
              "reviewerID" : reviewerID,
              "commentType" : commentType
            }

### View all Comments.
    PATH /comment/view
    GET
    RESPONSE{
              "commentID" : commentID,
              "commentContent" : commentContent,
              "abstractID" : abstractID,
              "reviewerID" : reviewerID,
              "commentType" : commentType
            }

### Remove a Comment.
    PATH /comment/delete
    POST inputCommentID
    RESPONSE{
              "success" : true|false,
              "responseMsg" : responseMsg
            }

### View all Scores.
    PATH /score/view
    GET 
    RESPONSE{
              "scoreID" : scoreID,
              "score" : score,
              "abstractID" : abstractID,
              "reviewerID" : reviewerID,
              "recommendation" : recommendation
            }

### Create a new Page.
    PATH /page/create
    POST inputPageTitle, inputPageContent, inputPageType
    RESPONSE{
              "success" : true|false,
              "conferenceID" : conferenceID
            }

### View all Pages.
    PATH /page/view
    GET
    RESPONSE{
              "pageID" : pageID,
              "pageTitle" : pageTitle,
              "pageContent" : pageContent,
              "conferenceID" : conferenceID,
              "pageType" : "pageType"
            }

### View a particulat Page.
    PATH /page/<pageID>
    GET
    RESPONSE{
              "pageID" : pageID,
              "pageTitle" : pageTitle,
              "pageContent" : pageContent,
              "conferenceID" : conferenceID,
              "pageType" : pageType,
              "images" : images
            }

### Update a particular Page.
    PATH /page/update
    POST inputPageTitle, inputPageContent, conferenceID, inputPageType, inputPageID
    RESPONSE{
              "success" : true|false,
              "pageID" : pageID
            }

### Delete a particular Page.
    PATH /page/delete
    POST inputPageID
    RESPONSE{
              "success" : true
              "deleted_images" : deleted_images
            }

### View all Images.
    PATH /image/view
    GET
    RESPONSE{
              "imageID" : imageID,
              "image" : image,
              "pageID" : pageID
            }

### View a particular Image.
    PATH /image/<imageID>
    GET
    RESPONSE{
              "imageID" : imageID,
              "image" : image,
              "pageID" : pageID
            }

### Remove a particular Image.
    PATH /image/delete
    POST inputImageID
    RESPONSE{
              "success" : true
            }
