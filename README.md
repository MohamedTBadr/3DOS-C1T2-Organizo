# ThreeDOS - INSTANT - Case 1 Team 2 - ORGANIZO </br>

**dbName** is conference

## Landing Page
```
The landing page has a set of Q&As near the footer that gives some instructions
```
## Signup (either by clicking "start", "become a member" or the "login" button)
```
The form retains data upon submission failure, a convenience to the user
Adequate validation; including email validation e.g shehab@com wouldn't go through

Email verification: An OTP will be sent to verify the registration
                    OTP has expiration and it can be resent when need be

Upon a successful registration a stylized welcoming message will be mailed
```
## Login
```
The form retains data upon submission failure
The possible errors are: email not registered, invalid format, incorrect password
```
## Forgot password 
```
An OTP will be sent to verify the ownership of that e-mail </br>
The OTP has expiration and it can be resent when need be </br>
Upon successfully reseting the password a message will be mailed to document this
```
## User profile
```
The user can Edit info, change password, upgrade the subscription plan or logout
It shows the number of projects the user is involved in and tasks assigned by or to the user
We chose to include the logout here instead of having it easily reachable from the navbar
```
## Edit user profile
```
Allows the user to change first name, last name, phone number, and edit the profile picture,
as all users start with a default picture
```
## Change password
```
It asks for the current password, the new password on top of confirming the new password
The new password has to conform with the criteria of passwords as established
(having a minimum of a lowercase, uppercase, number and a special character)
Changing the password successfully will log the user out as a security measure
```
## Subscription plans
```
It dynamically shows the plans available for upgrade based on the user’s plan
It has a section that shows a neat comparison of the plans that shows up
regardless of the current plan
```
## Payment
```
It ensures that no input is empty or invalid
```
## My projects
```
Shows the user's projects
Provides filters (All, In Progress, Completed) and a search bar
A project without sprints will have a due date marked as TBD (to be decided)
An "In progress" project is a project that has sprints, and tasks
A "Completed" has all of its tasks across of all its sprints checked as "Done"
```
## Add project
```
The user specifies the name of the project and can click on 'X' to back out
```
## Edit project
```
It allows the user to change the project name
Add member: if the user's plan allows, as a freemium user can't add members
            It checks if the plan allows to add more members within the limit

Delete member: removes other team members (other than the user)
```
## View Sprints
```
It shows a given project's sprints
It has pagination, where the limit is 3 sprints / page
Add sprint popup: set the sprint name, start and end date
                  the start date is set to current day's date
                  for the user convenience but it can be changed

Delete sprint: allows the user to delete the sprint
```
## Edit sprint
```
Allows the user to edit the sprint name, start and end dates but within
constraints that relate to when is that change being done
```

## Tasks
```
shows all tasks that pertain to a given sprint of a select project
Add comment: allows users to add a comment and attach an image

View task details: opens a detailed page, discussed down below
Archive task: discussed below
Delete task: deletes the task
```

## Add Task 
```
form for adding a new task within a sprint and includes these inputs task name, category (New, Bug, improve), Priority (High, Medium, Low), Description, Start and End date, and input to assign the task to any team member and archive or unarchive option.
```

## Archive task
```
This handy button allows the task reporter (creator) to archive the task
After task archival, archived tasks will be found at "Archived tasks"
which is easily accessible through the side navbar
```
## Task details
```
Shows handful information such as who assigned the task, its status, its priority
And whether if the assignee has seen the task or not (eye icon)
Edit task: The task name, start date, status, and end date can be adjusted,
           the user can quit this form through the 'X'

The comments: who wrote the comment can delete it
Image downalod: Team members can download the attached pictures
The user can go back to viewing the tasks of the given sprint by clicking on the 'X'
```
## Archived tasks Page "to unarchive"
```
Tt shows the archived tasks and that's where the user can unhide them
```
## Personal board (my_tasks)
```
Only shows the tasks that pertain to the user
Add note: These are notes to oneself, only visible to the user
          unlike comments which are seen by the team
```
## My task details
```
A personal "Task details" view
Delete note: allows the user to delete a note
```
## Calendar
```
Dynamically shows all tasks start &end dates and provides information
when the task label is pressed
It shows the expiry date of the subscription plan as well
```
</br>
</br>

![Our team-ish](https://github.com/ShehabSerry/3DOS-C1T2-Organizo/blob/main/img/wellItired.jpg)
